@props(['title', 'description' => null, 'action' => null, 'actionLabel' => 'Create', 'actionRoute' => null])

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem">
    <div>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:700;color:var(--crm-text);margin:0">{{ $title }}</h2>
        @if($description)
        <p style="font-size:0.875rem;color:var(--crm-text-muted);margin-top:0.25rem">{{ $description }}</p>
        @endif
    </div>

    @if($actionRoute)
    <a href="{{ $actionRoute }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        {{ $actionLabel }}
    </a>
    @endif

    @if($action)
    {{ $action }}
    @endif
</div>
