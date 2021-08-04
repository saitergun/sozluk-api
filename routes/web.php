<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use App\Models\Word;
use App\Http\Controllers\Web\WordController;

function get_words_by_range ($first, $last) {
    $words = collect();

    $multi_curl = new Curl\MultiCurl();

    // $multi_curl->setConcurrency(25); // default 25
    // $multi_curl->setConnectTimeout(300); // default 300

    $multi_curl->setRetry(function ($instance) {
        if ($instance->retries < 3) {
            if ($instance->retries != 0) {
                error_log('RETRY => '. $instance->url . ' ('. $instance->retries .')');
            }

            usleep(500000);

            return true;
        }

        return false;
    });

    $multi_curl->success(function($instance) use ($words) {
        // error_log('SUCCESS => '. $instance->url);

        $response = collect(json_decode($instance->response, true));

        if ($response->collect()->first() == 'Sonuç bulunamadı') {
            $words->push([
                'success' => false,
                'code' => 1404,
                'message' => 'Sonuç bulunamadı ' . $instance->url,
            ]);
        } else {
            $word = $response->collect()->first();

            $id = (int) $word['madde_id'];

            Arr::pull($word, 'madde_id');

            if (Arr::exists($word, 'atasozu')) {
                Arr::set($word, 'atasozu', Arr::pluck($word['atasozu'], 'madde_id'));
            }

            $words->push([
                'success' => true,
                'id' => $id,
                'json' => json_encode($word, JSON_UNESCAPED_UNICODE),
            ]);
        }
    });

    $multi_curl->error(function($instance) use ($words) {
        // error_log('ERROR => '. $instance->url);

        $words->push([
            'success' => false,
            'code' => $instance->errorCode,
            'message' => $instance->errorMessage,
        ]);
    });

    // $multi_curl->complete(function($instance) {
    //     error_log('COMPLETE => '. $instance->url);
    // });

    collect(range($first, $last))->each(function ($id) use ($multi_curl) {
        $multi_curl->addGet('https://sozluk.gov.tr/gts_id', [
            'id' => $id,
        ]);
    });

    $multi_curl->start();

    return $words;
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/words', [WordController::class, 'index']);
Route::get('/words/{word_id}', [WordController::class, 'show']);

if (env('APP_ENV') == 'local') {
    Route::get('/vacuum', function () {
        DB::statement('vacuum');

        return '<h1>hüüüp</h1>';
    });

    Route::get('/crawl', function () {
        $start_time = time();
        $total = 100000;

        Storage::disk('local')->put('crawl.log', '');
        Storage::prepend('crawl.log', date('Y-m-d H:i:s') .' => START');

        get_words_by_range(1, $total)->each((function ($word) {
            if ($word['success']) {
                Word::updateOrCreate(['id' => $word['id']], ['json' => $word['json']]);
            } else if ($word['code'] != 1404) {
                Storage::prepend('crawl.log', date('Y-m-d H:i:s') .' => ERR '. $word['message']);
            }
        }));

        $passingTime = (time() - $start_time);

        Storage::prepend('crawl.log', date('Y-m-d H:i:s') .' => END ('. $passingTime .')');

        echo '<h1>Ok '. $passingTime .' sec.</h1>';
    });
}
