@props(['type' => 'muted', 'dot' => false])

<span class="badge badge-{{ $type }}">
    @if($dot)<span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>@endif
    {{ $slot }}
</span>
