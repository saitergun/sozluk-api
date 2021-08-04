<ul class="pagination justify-content-center m-0">
  @foreach ($links as $link)
    <li class="page-item @if ($link['active']) active disabled @endif @if (!$link['url']) disabled @endif">
      @if ($link['url'])
        <a class="page-link" href="{{ $link['url'] }}">{!! $link['label'] !!}</a>
      @else
        <span class="page-link">{!! $link['label'] !!}</span>
      @endif
    </li>
  @endforeach
</ul>
