<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use App\Http\Resources\WordCollection;
use App\Http\Resources\WordResource;

use App\Models\Word;

class WordController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request $request
     */
    // * @return \App\Http\Resources\WordCollection
    public function index(Request $request)
    {
        $where = $request->where;
        $orderBy = $request->orderBy;

        $collection = DB::table('words');

        if ($where && Arr::accessible($where)) {
            foreach($where as $w) {
                try {
                    @[$column, $operator, $value, $boolean] = Str::of($w)->explode(',');

                    if ($column != '' && $operator != '' && $value != '') {
                        if (!$boolean || ($boolean != 'AND' && $boolean != 'OR')) {
                            $boolean = 'AND';
                        }

                        if ($operator == '=') {
                            $collection->where($column, $value, $boolean);
                        } else {
                            $collection->where($column, $operator, $value, $boolean);
                        }
                    }
                } catch (\Exception $e) {}
            }
        }

        if ($orderBy && Arr::accessible($orderBy)) {
            foreach($orderBy as $o) {
                try {
                    @[$column, $direction] = Str::of($o)->explode(',');

                    if ($column != '') {
                        if (!$direction || ($direction != 'asc' && $direction != 'desc')) {
                            $direction = 'asc';
                        }

                        $collection->orderBy($column, $direction);
                    }
                } catch (\Exception $e) {}
            }
        } else {
            $collection->orderBy('words.json->madde');
        }

        $words = $collection->paginate()->withQueryString()->toArray();

        return view('words.index')
            ->with('words', $words)
            ->with('where', $where)
        ;
    }

    /**
     *
     * @param  int  $word_id
     * @return \App\Http\Resources\WordResource
     */
    public function show($word_id)
    {
        $word = Word::findOrFail($word_id);

        return new WordResource($word);
    }
}
