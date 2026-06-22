<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Proposal {{ $proposal->proposal_number }}</title>

@php
    // ── Pre-compute everything to keep HTML clean of PHP conditionals in text nodes ──

    $logoFile = public_path('assets/brand/logo-main.png');
    $logoSrc  = file_exists($logoFile)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoFile))
        : null;

    $companyName    = setting('company_name', 'Redis Solution Pvt. Ltd.');
    $companyAddress = setting('company_address', 'Rawalpindi, Pakistan');
    $companyEmail   = setting('company_email', 'info@redissolution.com');
    $companyPhone   = setting('company_phone', '+92 349 3614440');

    $platforms     = \App\Models\Proposal::platforms();
    $platformLabel = $proposal->platform ? ($platforms[$proposal->platform] ?? $proposal->platform) : null;

    $clientLines = [];
    if ($proposal->client_company)  $clientLines[] = e($proposal->client_company);
    if ($proposal->client_email)    $clientLines[] = e($proposal->client_email);
    if ($proposal->client_phone)    $clientLines[] = e($proposal->client_phone);
    if ($platformLabel) {
        $pLine = 'Platform: ' . e($platformLabel);
        if ($proposal->fiverr_username) {
            $pLine .= ' &middot; @' . e($proposal->fiverr_username);
        }
        $clientLines[] = $pLine;
    }
    $clientDetailHtml = implode('<br>', $clientLines);

    $projectLines = [];
    if ($proposal->timeline)                 $projectLines[] = 'Timeline: ' . e($proposal->timeline);
    if ($proposal->revision_rounds !== null) $projectLines[] = 'Revisions: ' . $proposal->revision_rounds . ' Rounds';
    $projectDetailHtml = implode('<br>', $projectLines);

    $discountLabel = 'Discount';
    if ($proposal->discount_type === 'percent') {
        $discountLabel .= ' (' . number_format((float) $proposal->discount_amount, 2) . '%)';
    }

    $validUntilStr = $proposal->valid_until ? $proposal->valid_until->format('d M Y') : null;
@endphp

<style>
@page { margin: 0; size: A4 portrait; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 9pt;
    color: #1a1a1a;
    background: #ffffff;
    line-height: 1.5;
    margin: 0;
    padding: 0;
}

/* Left orange accent bar — repeats on every page */
.left-bar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 5px;
    background: #FF6400;
}

/* Fixed footer */
.pdf-footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
}

/* ── SECTION TITLE ── */
.sec-title {
    font-size: 7pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #FF6400;
    border-bottom: 1.5px solid #FF6400;
    padding-bottom: 4px;
    margin-bottom: 9px;
    page-break-after: avoid;
}

/* ── ITEM TABLE ── */
.itbl { width: 100%; border-collapse: collapse; }
.itbl-hd { background: #FF6400; }
.itbl-hd th {
    color: #fff;
    font-size: 7pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 7px 10px;
}
.itbl-even { background: #fdf8f5; }
.itbl td { padding: 8px 10px; vertical-align: top; border-bottom: 1px solid #eeeeee; }

/* ── TOTALS ── */
.tot-tbl { width: 100%; border-collapse: collapse; }
.tot-tbl td { padding: 3px 8px; font-size: 8.5pt; }

/* ── WHY TABLE ── */
.why-tbl { width: 100%; border-collapse: collapse; }
.why-tbl td { padding: 4px 5px; font-size: 8pt; color: #333; vertical-align: top; width: 33%; }
</style>
</head>
<body>

{{-- Left orange accent bar --}}
<div class="left-bar"></div>

{{-- Fixed footer --}}
<div class="pdf-footer">
    <div style="height:4px;background:#FF6400"></div>
    <table style="width:100%;background:#1a1a1a;border-collapse:collapse;padding:0">
        <tr>
            <td style="font-size:6.5pt;color:#999;padding:5px 28px">Confidential &mdash; Prepared exclusively for {{ $proposal->client_name }}</td>
            <td style="font-size:6.5pt;color:#999;text-align:right;padding:5px 28px">{{ $proposal->proposal_number }} &middot; {{ $proposal->created_at->format('d M Y') }}</td>
        </tr>
    </table>
</div>

{{-- ══ TOP ACCENT ══ --}}
<div style="height:5px;background:#FF6400;width:100%"></div>

{{-- ══ HEADER ══ --}}
<div style="padding:18px 28px 16px 28px;border-bottom:2px solid #FF6400">
    <table style="width:100%;border-collapse:collapse">
        <tr>
            <td style="width:55%;vertical-align:top">
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" style="max-height:56px;max-width:195px;display:block;margin-bottom:7px">
                @else
                    <div style="font-size:14pt;font-weight:bold;color:#FF6400;line-height:1.1">{{ $companyName }}</div>
                    <div style="font-size:7pt;color:#888;letter-spacing:0.04em;margin-top:2px">Innovate. Create. Succeed.</div>
                @endif
                <div style="font-size:7.5pt;color:#555;line-height:1.9;margin-top:7px">
                    {{ $companyAddress }}<br>
                    {{ $companyEmail }}<br>
                    {{ $companyPhone }}
                </div>
            </td>
            <td style="width:45%;vertical-align:top;text-align:right">
                <div style="font-size:20pt;font-weight:bold;color:#1a1a1a;letter-spacing:3px;text-transform:uppercase;line-height:1">Proposal</div>
                <div style="display:inline-block;background:#FF6400;color:#fff;font-size:9.5pt;font-weight:bold;padding:3px 11px;font-family:monospace;margin-top:5px">#{{ $proposal->proposal_number }}</div>
                <div style="font-size:7.5pt;color:#555;line-height:2;margin-top:7px">
                    Date: {{ $proposal->created_at->format('d M Y') }}<br>
                    @if($validUntilStr)
                        Valid Until: {{ $validUntilStr }}<br>
                    @endif
                    Currency: {{ $proposal->currency }}
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- ══ CLIENT BAND ══ --}}
<div style="background:#fafafa;border-bottom:1px solid #e0e0e0;padding:13px 28px">
    <table style="width:100%;border-collapse:collapse">
        <tr>
            <td style="width:50%;vertical-align:top;padding-right:18px">
                <div style="font-size:6.5pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.12em;color:#FF6400;margin-bottom:4px">Prepared For</div>
                <div style="font-size:11.5pt;font-weight:bold;color:#1a1a1a;line-height:1.2">{{ $proposal->client_name }}</div>
                @if($clientDetailHtml)
                    <div style="font-size:8pt;color:#555;line-height:1.75;margin-top:3px">{!! $clientDetailHtml !!}</div>
                @endif
            </td>
            <td style="width:50%;vertical-align:top;border-left:2px solid #FF6400;padding-left:18px">
                <div style="font-size:6.5pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.12em;color:#FF6400;margin-bottom:4px">Project</div>
                <div style="font-size:11.5pt;font-weight:bold;color:#1a1a1a;line-height:1.2">{{ $proposal->project_title }}</div>
                @if($projectDetailHtml)
                    <div style="font-size:8pt;color:#555;line-height:1.75;margin-top:3px">{!! $projectDetailHtml !!}</div>
                @endif
            </td>
        </tr>
    </table>
</div>

{{-- ══ 1: PROJECT OVERVIEW ══ --}}
@if($proposal->isSectionEnabled('description') && $proposal->project_description)
    <div style="padding:14px 28px;border-bottom:1px solid #ebebeb">
        <div class="sec-title">Project Overview</div>
        <div style="font-size:11pt;font-weight:bold;color:#1a1a1a;margin-bottom:6px;page-break-after:avoid">{{ $proposal->project_title }}</div>
        <div style="font-size:8.5pt;color:#333;line-height:1.75">{!! $proposal->project_description !!}</div>
    </div>
@endif

{{-- ══ 2: SCOPE OF WORK ══ --}}
@if($proposal->isSectionEnabled('scope') && $proposal->items->count())
    <div style="padding:14px 28px;border-bottom:1px solid #ebebeb">
        <div class="sec-title">Scope of Work</div>
        <table class="itbl">
            <colgroup>
                <col style="width:4%">
                <col style="width:46%">
                <col style="width:8%">
                <col style="width:21%">
                <col style="width:21%">
            </colgroup>
            <thead>
                <tr class="itbl-hd" style="page-break-inside:avoid">
                    <th style="text-align:left">#</th>
                    <th style="text-align:left">Service / Deliverable</th>
                    <th style="text-align:right">Qty</th>
                    <th style="text-align:right">Unit Price</th>
                    <th style="text-align:right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proposal->items as $idx => $item)
                    <tr class="{{ $idx % 2 === 1 ? 'itbl-even' : '' }}" style="page-break-inside:avoid">
                        <td style="font-size:7.5pt;color:#aaa;text-align:left">{{ $idx + 1 }}</td>
                        <td style="text-align:left">
                            <div style="font-weight:bold;font-size:8.5pt;color:#1a1a1a">{{ $item->title }}</div>
                            @if($item->description)
                                <div style="font-size:7.5pt;color:#777;margin-top:2px;line-height:1.45">{{ $item->description }}</div>
                            @endif
                        </td>
                        <td style="text-align:right;font-size:8.5pt">{{ $item->quantity }}</td>
                        <td style="text-align:right;font-size:8.5pt;white-space:nowrap">
                            @if($item->unit_price)
                                {{ $proposal->currency }}&nbsp;{{ number_format((float) $item->unit_price, 2) }}
                            @else
                                &mdash;
                            @endif
                        </td>
                        <td style="text-align:right;font-weight:bold;color:#FF6400;font-size:8.5pt;white-space:nowrap">
                            {{ $proposal->currency }}&nbsp;{{ number_format((float) $item->total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

{{-- ══ 3: PRICING SUMMARY ══ --}}
@if($proposal->isSectionEnabled('pricing'))
    <div style="padding:14px 28px;border-bottom:1px solid #ebebeb;page-break-inside:avoid">
        <div class="sec-title">Pricing Summary</div>
        {{-- 55/45 split keeps totals right-aligned; white-space:nowrap stops line-breaks in values --}}
        <table style="width:100%;border-collapse:collapse">
            <tr>
                <td style="width:55%"></td>
                <td style="width:45%;vertical-align:top">
                    <table style="width:100%;border-collapse:collapse">
                        <tr>
                            <td style="font-size:8.5pt;color:#555;padding:3px 8px;text-align:left;white-space:nowrap">Subtotal</td>
                            <td style="font-size:8.5pt;font-weight:bold;padding:3px 8px;text-align:right;white-space:nowrap">{{ $proposal->currency }}&nbsp;{{ number_format((float) $proposal->subtotal, 2) }}</td>
                        </tr>
                        @if($proposal->discount_amount > 0)
                            <tr>
                                <td style="font-size:8.5pt;color:#c0392b;padding:3px 8px;text-align:left;white-space:nowrap">{{ $discountLabel }}</td>
                                <td style="font-size:8.5pt;font-weight:bold;color:#c0392b;padding:3px 8px;text-align:right;white-space:nowrap">&minus;&nbsp;{{ $proposal->currency }}&nbsp;{{ number_format((float) $proposal->discountValue(), 2) }}</td>
                            </tr>
                        @endif
                    </table>
                    <table style="width:100%;border-collapse:collapse;margin-top:5px;border:2px solid #FF6400">
                        <tr>
                            <td style="font-size:10pt;font-weight:bold;color:#FF6400;padding:7px 10px;text-align:left;white-space:nowrap;letter-spacing:1px">TOTAL</td>
                            <td style="font-size:10pt;font-weight:bold;color:#FF6400;padding:7px 10px;text-align:right;white-space:nowrap">{{ $proposal->currency }}&nbsp;{{ number_format((float) $proposal->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
@endif

{{-- ══ 4: PROJECT DETAILS ══ --}}
@if($proposal->isSectionEnabled('details') && ($proposal->timeline || $proposal->revision_rounds !== null || $validUntilStr))
    <div style="padding:14px 28px;border-bottom:1px solid #ebebeb;page-break-inside:avoid">
        <div class="sec-title">Project Details</div>
        <table style="width:100%;border-collapse:separate;border-spacing:8px 0">
            <tr>
                @if($proposal->timeline)
                    <td style="border:1px solid #e0e0e0;padding:9px 12px;vertical-align:top;width:33%">
                        <div style="font-size:6.5pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:2px">Timeline</div>
                        <div style="font-size:9pt;font-weight:bold;color:#1a1a1a">{{ $proposal->timeline }}</div>
                    </td>
                @endif
                @if($proposal->revision_rounds !== null)
                    <td style="border:1px solid #e0e0e0;padding:9px 12px;vertical-align:top;width:33%">
                        <div style="font-size:6.5pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:2px">Revision Rounds</div>
                        <div style="font-size:9pt;font-weight:bold;color:#1a1a1a">{{ $proposal->revision_rounds }} Rounds</div>
                    </td>
                @endif
                @if($validUntilStr)
                    <td style="border:1px solid #e0e0e0;padding:9px 12px;vertical-align:top;width:33%">
                        <div style="font-size:6.5pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:2px">Valid Until</div>
                        <div style="font-size:9pt;font-weight:bold;color:#1a1a1a">{{ $validUntilStr }}</div>
                    </td>
                @endif
                <td></td>
            </tr>
        </table>
    </div>
@endif

{{-- ══ 5: TERMS & CONDITIONS ══ --}}
@if($proposal->isSectionEnabled('terms') && $proposal->terms_conditions)
    <div style="padding:14px 28px;border-bottom:1px solid #ebebeb">
        <div class="sec-title">Terms &amp; Conditions</div>
        <div style="font-size:8pt;color:#444;line-height:1.85;white-space:pre-line">{{ $proposal->terms_conditions }}</div>
    </div>
@endif

{{-- ══ 6: WHY REDIS SOLUTION ══ --}}
@if($proposal->isSectionEnabled('why_us'))
    <div style="padding:14px 28px;border-bottom:1px solid #ebebeb;page-break-inside:avoid">
        <div class="sec-title">Why Redis Solution?</div>
        <table class="why-tbl">
            <tr style="page-break-inside:avoid">
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> {{ setting('counter_projects', '100') }}+ Projects Delivered</td>
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> {{ setting('counter_years', '4') }}+ Years Experience</td>
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> {{ setting('counter_satisfaction', '98') }}% Client Satisfaction</td>
            </tr>
            <tr style="page-break-inside:avoid">
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> 24/7 Post-Launch Support</td>
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> 100% Code Ownership</td>
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> Agile Development</td>
            </tr>
            <tr style="page-break-inside:avoid">
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> NDA Before Discussion</td>
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> Transparent Communication</td>
                <td><span style="color:#FF6400;font-weight:bold">&#10003;</span> On-Time Delivery</td>
            </tr>
        </table>
    </div>
@endif

{{-- ══ 7: CONTACT / CTA ══ --}}
@if($proposal->isSectionEnabled('contact'))
    <div style="padding:14px 28px;background:#fff5ed;border-top:1px solid #ffd5a8;border-bottom:1px solid #ffd5a8;text-align:center;page-break-inside:avoid">
        <div style="font-size:11pt;font-weight:bold;color:#FF6400;margin-bottom:5px">Ready to Get Started?</div>
        <div style="font-size:8pt;color:#555;margin-bottom:8px">Accept this proposal by reaching out to us &mdash; we&apos;ll begin immediately upon advance payment.</div>
        <div style="font-size:8.5pt;color:#333">
            <strong>Email:</strong> {{ $companyEmail }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Phone / WhatsApp:</strong> {{ $companyPhone }}
        </div>
    </div>
@endif

{{-- ══ TAGLINE ══ --}}
<div style="text-align:center;padding:10px 28px 34px;font-size:7pt;color:#aaa;text-transform:uppercase;letter-spacing:0.15em;page-break-inside:avoid">
    {{ $companyName }} &mdash; Innovate. Create. Succeed.
</div>

</body>
</html>
