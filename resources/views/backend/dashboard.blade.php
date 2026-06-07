<x-layouts.backend title="Dashboard">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;flex-wrap:wrap;gap:0.5rem">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome back, {{ Auth::user()->name }}</p>
        </div>
        <span style="font-size:0.8rem;color:var(--crm-text-muted)">{{ now()->format('l, d M Y') }}</span>
    </div>

    {{-- ── Stat Cards ─────────────────────────────────────────────────────── --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;margin-bottom:1.75rem">

        <x-backend.stat-card :value="$activeProjects" label="Active Projects">
            <x-slot:icon><i class="ri-folder-line" style="font-size:1.4rem"></i></x-slot:icon>
        </x-backend.stat-card>

        <x-backend.stat-card :value="'PKR ' . number_format($monthIncome, 0)" label="Income This Month">
            <x-slot:icon><i class="ri-arrow-up-circle-line" style="font-size:1.4rem;color:#34D399"></i></x-slot:icon>
        </x-backend.stat-card>

        <x-backend.stat-card :value="'PKR ' . number_format($monthExpense, 0)" label="Expenses This Month">
            <x-slot:icon><i class="ri-arrow-down-circle-line" style="font-size:1.4rem;color:#F87171"></i></x-slot:icon>
        </x-backend.stat-card>

        <x-backend.stat-card :value="($runningBalance >= 0 ? '+' : '') . 'PKR ' . number_format($runningBalance, 0)" label="Running Balance">
            <x-slot:icon><i class="ri-wallet-3-line" style="font-size:1.4rem;color:{{ $runningBalance >= 0 ? '#34D399' : '#F87171' }}"></i></x-slot:icon>
        </x-backend.stat-card>

    </div>

    {{-- ── Row 2: Project Due + Renewals ──────────────────────────────────── --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem">

        {{-- Projects Due This Week --}}
        <div class="crm-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
                <h3 style="font-family:'Syne',sans-serif;font-size:0.9rem;font-weight:700;color:var(--crm-text);margin:0">
                    <i class="ri-calendar-todo-line" style="color:#FF6400;margin-right:0.4rem"></i>
                    Due This Week
                </h3>
                @can('project.view')
                    <a href="{{ route('admin.projects.index') }}" style="font-size:0.75rem;color:#FF6400;text-decoration:none">View all →</a>
                @endcan
            </div>
            @forelse($projectsDueThisWeek as $p)
                @php
                    $statusColors = ['pending'=>'#FBBF24','in_progress'=>'#60A5FA','in_review'=>'#A78BFA','testing'=>'#22D3EE','completed'=>'#34D399','on_hold'=>'#FB923C','cancelled'=>'#F87171'];
                    $sc = $statusColors[$p->status] ?? '#94A3B8';
                    $daysLeft = now()->diffInDays($p->deadline, false);
                @endphp
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0.75rem;border-radius:8px;background:var(--crm-hover);margin-bottom:0.5rem">
                    <div style="min-width:0">
                        <div style="font-size:0.8rem;font-weight:600;color:var(--crm-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->title }}</div>
                        <div style="font-size:0.72rem;color:var(--crm-text-muted)">{{ $p->client_name }} · {{ $p->project_code }}</div>
                    </div>
                    <div style="text-align:right;flex-shrink:0;margin-left:0.75rem">
                        <div style="font-size:0.72rem;font-weight:600;color:{{ $daysLeft <= 1 ? '#F87171' : ($daysLeft <= 3 ? '#FBBF24' : '#34D399') }}">
                            {{ $daysLeft < 0 ? 'Overdue' : ($daysLeft === 0 ? 'Today' : $daysLeft . 'd left') }}
                        </div>
                        <div style="font-size:0.7rem;color:{{ $sc }}">{{ \App\Models\Project::$statuses[$p->status] ?? $p->status }}</div>
                    </div>
                </div>
            @empty
                <p style="text-align:center;padding:1.5rem;color:var(--crm-text-muted);font-size:0.8rem;opacity:0.6">No projects due this week.</p>
            @endforelse
        </div>

        {{-- Hosting Renewals --}}
        <div class="crm-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
                <h3 style="font-family:'Syne',sans-serif;font-size:0.9rem;font-weight:700;color:var(--crm-text);margin:0">
                    <i class="ri-server-line" style="color:#FF6400;margin-right:0.4rem"></i>
                    Renewals Due (30d)
                    @if($renewalsDue > 0)
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:#F87171;color:#fff;font-size:0.65rem;font-weight:700;margin-left:0.35rem">{{ $renewalsDue }}</span>
                    @endif
                </h3>
                @can('hosting.view')
                    <a href="{{ route('admin.hosting.index') }}" style="font-size:0.75rem;color:#FF6400;text-decoration:none">View all →</a>
                @endcan
            </div>
            @forelse($renewalAlerts as $client)
                @php
                    $days = $client->days_until_renewal;
                    $renewalColor = $days < 0 ? '#F87171' : ($days <= 7 ? '#F87171' : '#FBBF24');
                @endphp
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0.75rem;border-radius:8px;background:var(--crm-hover);margin-bottom:0.5rem">
                    <div style="min-width:0">
                        <div style="font-size:0.8rem;font-weight:600;color:var(--crm-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $client->client_name }}</div>
                        <div style="font-size:0.72rem;color:var(--crm-text-muted);display:flex;align-items:center;gap:0.3rem">
                            <i class="ri-global-line" style="font-size:0.65rem"></i> {{ $client->domain_name }}
                        </div>
                    </div>
                    <div style="text-align:right;flex-shrink:0;margin-left:0.75rem">
                        <div style="font-size:0.72rem;font-weight:600;color:{{ $renewalColor }}">
                            {{ $days < 0 ? abs($days) . 'd overdue' : ($days === 0 ? 'Today' : $days . 'd left') }}
                        </div>
                        <div style="font-size:0.7rem;color:var(--crm-text-muted)">{{ $client->next_renewal_date->format('d M Y') }}</div>
                    </div>
                </div>
            @empty
                <p style="text-align:center;padding:1.5rem;color:var(--crm-text-muted);font-size:0.8rem;opacity:0.6">No renewals due in the next 30 days.</p>
            @endforelse
        </div>

    </div>

    {{-- ── Quick Actions ───────────────────────────────────────────────────── --}}
    <div class="crm-card">
        <h3 style="font-family:'Syne',sans-serif;font-size:0.9rem;font-weight:700;color:var(--crm-text);margin:0 0 1rem">Quick Actions</h3>
        <div style="display:flex;flex-wrap:wrap;gap:0.5rem">
            @can('project.create')
                <a href="{{ route('admin.projects.create') }}" class="btn btn-secondary"><i class="ri-folder-add-line"></i> New Project</a>
            @endcan
            @can('budget.create')
                <a href="{{ route('admin.budget.incomes.create') }}" class="btn btn-secondary"><i class="ri-add-circle-line"></i> Add Income</a>
                <a href="{{ route('admin.budget.expenses.create') }}" class="btn btn-secondary"><i class="ri-subtract-line"></i> Add Expense</a>
            @endcan
            @can('investment.create')
                <a href="{{ route('admin.investments.create') }}" class="btn btn-secondary"><i class="ri-briefcase-line"></i> New Investment</a>
            @endcan
            @can('hosting.create')
                <a href="{{ route('admin.hosting.create') }}" class="btn btn-secondary"><i class="ri-server-line"></i> Add Hosting Client</a>
            @endcan
        </div>
    </div>

</x-layouts.backend>
