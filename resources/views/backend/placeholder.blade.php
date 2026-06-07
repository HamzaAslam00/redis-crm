<x-layouts.backend :title="$page">
    <x-backend.page-header :title="$page" description="This module will be implemented in an upcoming phase." />

    <div class="crm-card" style="text-align:center;padding:4rem 2rem">
        <div style="width:64px;height:64px;border-radius:16px;background:rgba(255,100,0,0.1);border:1px solid rgba(255,100,0,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:32px;height:32px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <h3 style="font-family:'Syne',sans-serif;font-size:1.25rem;font-weight:700;color:var(--crm-text);margin-bottom:0.5rem">Coming Soon</h3>
        <p style="color:var(--crm-text-muted);font-size:0.9rem;max-width:400px;margin:0 auto;line-height:1.7">
            The <strong style="color:var(--crm-text)">{{ $page }}</strong> module is planned and will be built in the next development phase.
        </p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="margin-top:1.5rem;display:inline-flex">← Back to Dashboard</a>
    </div>
</x-layouts.backend>
