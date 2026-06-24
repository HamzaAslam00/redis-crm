<div>

    {{-- Stats strip --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem">
        <div class="crm-card" style="text-align:center;padding:1.25rem">
            <div style="font-size:2rem;font-weight:800;color:#FF6400">{{ number_format($totalAudits) }}</div>
            <div style="font-size:0.78rem;color:var(--crm-text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:0.05em">Total Audits</div>
        </div>
        <div class="crm-card" style="text-align:center;padding:1.25rem">
            <div style="font-size:2rem;font-weight:800;color:#6366F1">{{ number_format($uniqueUrls) }}</div>
            <div style="font-size:0.78rem;color:var(--crm-text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:0.05em">Unique Websites</div>
        </div>
        <div class="crm-card" style="text-align:center;padding:1.25rem">
            <div style="font-size:2rem;font-weight:800;color:#10B981">{{ number_format($uniqueCountries) }}</div>
            <div style="font-size:0.78rem;color:var(--crm-text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:0.05em">Countries</div>
        </div>
    </div>

    {{-- Search --}}
    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem">
        <div style="position:relative;flex:1">
            <i class="ri-search-line" style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:var(--crm-text-muted)"></i>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Search by website URL…"
                style="width:100%;padding:0.6rem 1rem 0.6rem 2.4rem;border:1px solid var(--crm-input-border);border-radius:8px;background:var(--crm-input);color:var(--crm-text);font-size:0.875rem">
        </div>
    </div>

    {{-- Table --}}
    <div class="crm-card" style="padding:0;overflow:hidden">
        @if($logs->isEmpty())
            <div style="padding:3rem;text-align:center;color:var(--crm-text-muted)">
                <i class="ri-radar-line" style="font-size:2.5rem;display:block;margin-bottom:0.75rem"></i>
                No audit records yet. They appear once someone uses the Free SEO Audit tool on the website.
            </div>
        @else
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="border-bottom:1px solid var(--crm-border)">
                        <th style="padding:0.75rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Website URL</th>
                        <th style="padding:0.75rem 1rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Audits</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Countries</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">First Seen</th>
                        <th style="padding:0.75rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Last Audit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $row)
                        <tr style="border-bottom:1px solid var(--crm-border);transition:background 0.15s" onmouseover="this.style.background='var(--crm-hover)'" onmouseout="this.style.background=''">
                            <td style="padding:0.9rem 1.25rem;max-width:280px">
                                <div style="font-size:0.875rem;font-weight:600;color:var(--crm-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="{{ $row->url }}">
                                    {{ $row->url }}
                                </div>
                            </td>
                            <td style="padding:0.9rem 1rem;text-align:center">
                                <button wire:click="showDetails('{{ addslashes($row->url) }}')"
                                    style="display:inline-flex;align-items:center;justify-content:center;min-width:40px;padding:0.3rem 0.75rem;background:rgba(255,100,0,0.12);border:1px solid rgba(255,100,0,0.3);color:#FF6400;border-radius:20px;font-size:0.82rem;font-weight:700;cursor:pointer">
                                    {{ $row->total_audits }}
                                </button>
                            </td>
                            <td style="padding:0.9rem 1rem">
                                <span style="font-size:0.8rem;color:var(--crm-text-muted)">
                                    {{ $row->countries ?: '—' }}
                                </span>
                            </td>
                            <td style="padding:0.9rem 1rem">
                                <span style="font-size:0.8rem;color:var(--crm-text-muted)">
                                    {{ \Carbon\Carbon::parse($row->first_audit)->format('d M Y') }}
                                </span>
                            </td>
                            <td style="padding:0.9rem 1.25rem">
                                <span style="font-size:0.8rem;color:var(--crm-text-muted)">
                                    {{ \Carbon\Carbon::parse($row->last_audit)->diffForHumans() }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($logs->hasPages())
                <div style="padding:1rem 1.25rem;border-top:1px solid var(--crm-border)">
                    {{ $logs->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- Detail Modal --}}
    @if($showModal)
        <div style="position:fixed;inset:0;z-index:1000;display:flex;align-items:center;justify-content:center;padding:1rem"
            wire:click.self="closeModal">
            <div style="position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px)" wire:click="closeModal"></div>

            <div style="position:relative;z-index:1001;background:var(--crm-card);border:1px solid var(--crm-border);border-radius:16px;width:100%;max-width:800px;max-height:85vh;display:flex;flex-direction:column;overflow:hidden">

                {{-- Modal header --}}
                <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--crm-border);display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-shrink:0">
                    <div>
                        <h3 style="font-size:1rem;font-weight:700;color:var(--crm-text);margin:0 0 0.25rem">Audit History</h3>
                        <p style="font-size:0.78rem;color:var(--crm-text-muted);margin:0;word-break:break-all">{{ $selectedUrl }}</p>
                    </div>
                    <button wire:click="closeModal" style="background:none;border:none;color:var(--crm-text-muted);cursor:pointer;font-size:1.3rem;flex-shrink:0;padding:0.1rem">
                        <i class="ri-close-line"></i>
                    </button>
                </div>

                {{-- Modal body --}}
                <div style="overflow-y:auto;flex:1">
                    <table style="width:100%;border-collapse:collapse">
                        <thead style="position:sticky;top:0;background:var(--crm-card);z-index:1">
                            <tr style="border-bottom:1px solid var(--crm-border)">
                                <th style="padding:0.65rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">#</th>
                                <th style="padding:0.65rem 1rem;text-align:left;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Date & Time</th>
                                <th style="padding:0.65rem 1rem;text-align:left;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">IP Address</th>
                                <th style="padding:0.65rem 1rem;text-align:left;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Location</th>
                                <th style="padding:0.65rem 1rem;text-align:left;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">ISP</th>
                                <th style="padding:0.65rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">Device</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedLogs as $i => $log)
                                <tr style="border-bottom:1px solid var(--crm-border)">
                                    <td style="padding:0.75rem 1.25rem;font-size:0.78rem;color:var(--crm-text-muted)">{{ $i + 1 }}</td>
                                    <td style="padding:0.75rem 1rem;white-space:nowrap">
                                        <div style="font-size:0.82rem;font-weight:600;color:var(--crm-text)">
                                            {{ \Carbon\Carbon::parse($log['created_at'])->format('d M Y') }}
                                        </div>
                                        <div style="font-size:0.75rem;color:var(--crm-text-muted)">
                                            {{ \Carbon\Carbon::parse($log['created_at'])->format('H:i:s') }}
                                        </div>
                                    </td>
                                    <td style="padding:0.75rem 1rem">
                                        <span style="font-size:0.82rem;font-family:monospace;color:var(--crm-text)">
                                            {{ $log['ip_address'] ?? '—' }}
                                        </span>
                                    </td>
                                    <td style="padding:0.75rem 1rem">
                                        @if($log['country'])
                                            <div style="font-size:0.82rem;color:var(--crm-text)">
                                                {{ $log['city'] ? $log['city'].', ' : '' }}{{ $log['country'] }}
                                            </div>
                                            @if($log['region'])
                                                <div style="font-size:0.75rem;color:var(--crm-text-muted)">{{ $log['region'] }}</div>
                                            @endif
                                        @else
                                            <span style="font-size:0.82rem;color:var(--crm-text-muted)">—</span>
                                        @endif
                                    </td>
                                    <td style="padding:0.75rem 1rem;max-width:160px">
                                        <span style="font-size:0.78rem;color:var(--crm-text-muted);display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="{{ $log['isp'] ?? '' }}">
                                            {{ $log['isp'] ?? '—' }}
                                        </span>
                                    </td>
                                    <td style="padding:0.75rem 1.25rem;max-width:180px">
                                        @php
                                            $ua = $log['user_agent'] ?? '';
                                            $device = 'Desktop';
                                            if (stripos($ua, 'Mobile') !== false || stripos($ua, 'Android') !== false) $device = 'Mobile';
                                            elseif (stripos($ua, 'Tablet') !== false || stripos($ua, 'iPad') !== false) $device = 'Tablet';
                                            $browser = 'Other';
                                            if (stripos($ua, 'Chrome') !== false && stripos($ua, 'Edg') === false) $browser = 'Chrome';
                                            elseif (stripos($ua, 'Firefox') !== false) $browser = 'Firefox';
                                            elseif (stripos($ua, 'Safari') !== false && stripos($ua, 'Chrome') === false) $browser = 'Safari';
                                            elseif (stripos($ua, 'Edg') !== false) $browser = 'Edge';
                                        @endphp
                                        <div style="font-size:0.82rem;color:var(--crm-text)">{{ $browser }} · {{ $device }}</div>
                                        <div style="font-size:0.72rem;color:var(--crm-text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="{{ $ua }}">
                                            {{ Str::limit($ua, 40) }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="padding:1rem 1.5rem;border-top:1px solid var(--crm-border);flex-shrink:0;text-align:right">
                    <button wire:click="closeModal" class="btn btn-secondary btn-sm">Close</button>
                </div>
            </div>
        </div>
    @endif

</div>
