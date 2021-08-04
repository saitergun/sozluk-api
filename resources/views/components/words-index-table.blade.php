<table class="table table-bordered table-striped m-0">
  <thead>
    <tr>
      <th style="width: 75px">#</th>
      <th>madde</th>
      <th>telaffuz</th>
      <th>lisan_kodu</th>
      <th>lisan</th>
      <th>anlamlar</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($words as $word)
      @php
        $json = json_decode($word->json);
        $json_pretty = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
      @endphp

      <tr>
        <td>{{ $word->id }}</td>

        <td>
          <span class="fw-bolde cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasJson-{{ $word->id }}">{{ $json->madde }}</span>

          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasJson-{{ $word->id }}">
            <div class="offcanvas-header">
              <h5 class="fs-5 fw-bolder m-0" id="offcanvasJson-{{ $word->id }}-label">{{ $json->madde }}</h5>

              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body border-top">
              <pre class="white-space-pre-wrap">{{ $json_pretty }}</pre>
            </div>
          </div>
        </td>

        <td>{{ $json->telaffuz }}</td>

        <td>
          @if ($json->lisan_kodu != '0')
            {{ $json->lisan_kodu }}
          @endif
        </td>

        <td>{{ $json->lisan }}</td>

        <td>
          @foreach ($json->anlamlarListe as $anlam)
            <p class="m-0">{{ $anlam->anlam }}</p>
          @endforeach
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
