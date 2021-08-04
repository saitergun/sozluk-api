<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Sözlük API</title>

  <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />
</head>
<body>
	<span class="position-fixed top-0 bottom-0 start-0 end-0 w-100 h-100 d-flex flex-row overflow-hidden">

		<aside class="h-100 bg-light p-4 overflow-y-auto" style="min-width: 320px">
			<x-words-index-side-filter
        :page="$words['current_page']"
        :where="$where"
      />
		</aside>

		<div class="w-full flex-grow-1 border-start overflow-auto p-4">
			@if (count($words) > 0)
        <x-words-index-table :words="$words['data']" />

        <div class="d-flex align-items-center justify-content-between py-2 px-2">
          <p class="m-0">{{ $words['total'] }} kayıt bulundu</p>

          <x-words-index-pagination :links="$words['links']" />
        </div>
			@else
				<div class="alert alert-danger">Sonuç bulunamadı.</div>
			@endif

      {{-- <x-pre-json :data="get_defined_vars()['__data']['words']" /> --}}
		</div>
	</span>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
