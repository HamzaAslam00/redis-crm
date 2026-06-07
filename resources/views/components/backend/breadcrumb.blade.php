@props(['items' => []])

@if(count($items))
<nav style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;color:var(--crm-text-muted);margin-bottom:1.25rem">
    <a href="{{ route('admin.dashboard') }}" style="color:var(--crm-text-muted);transition:color 0.15s" onmouseover="this.style.color='#FF6400'" onmouseout="this.style.color='var(--crm-text-muted)'">
        Dashboard
    </a>
    @foreach($items as $label => $url)
        <span style="color:var(--crm-border)">/</span>
        @if($url && !$loop->last)
            <a href="{{ $url }}" style="color:var(--crm-text-muted);transition:color 0.15s" onmouseover="this.style.color='#FF6400'" onmouseout="this.style.color='var(--crm-text-muted)'">{{ $label }}</a>
        @else
            <span style="color:var(--crm-text-sub)">{{ $label }}</span>
        @endif
    @endforeach
</nav>
@endif
