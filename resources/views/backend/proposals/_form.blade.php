@php
    $isEdit      = !is_null($proposal);
    $defaultMilestones = [
        ['label' => 'On Project Start (50%)', 'amount' => 0],
        ['label' => 'On Final Delivery (50%)', 'amount' => 0],
    ];
    $initialMilestones = ($isEdit && !empty($proposal->milestones)) ? $proposal->milestones : $defaultMilestones;
    $initialItems = $isEdit
        ? $proposal->items->map(fn($i) => [
            'title'         => $i->title,
            'description'   => $i->description ?? '',
            'delivery_days' => $i->delivery_days ?? '',
            'price'         => (float) $i->total,
          ])->values()->toArray()
        : [['title' => '', 'description' => '', 'delivery_days' => '', 'price' => 0]];

    // Order matches PDF output order exactly
    $initialSections = array_merge(
        ['description' => true, 'scope' => true, 'prices' => true, 'pricing' => true, 'details' => true, 'terms' => true, 'why_us' => true, 'contact' => true],
        ($isEdit && $proposal->sections_enabled) ? $proposal->sections_enabled : []
    );

    $sectionLabels = [
        'description' => ['icon' => 'ri-file-text-line',    'label' => 'Project Overview'],
        'scope'       => ['icon' => 'ri-list-check',         'label' => 'Scope of Work'],
        'prices'      => ['icon' => 'ri-money-dollar-circle-line', 'label' => 'Show Item Prices'],
        'pricing'     => ['icon' => 'ri-price-tag-3-line',   'label' => 'Pricing Summary'],
        'details'     => ['icon' => 'ri-calendar-line',      'label' => 'Project Details'],
        'terms'       => ['icon' => 'ri-file-shield-2-line', 'label' => 'Terms & Conditions'],
        'why_us'      => ['icon' => 'ri-award-line',         'label' => 'Why Redis Solution'],
        'contact'     => ['icon' => 'ri-phone-line',         'label' => 'Contact / CTA'],
    ];

    $companyName    = setting('company_name', 'Redis Solution Pvt. Ltd.');
    $companyAddress = setting('company_address', 'Rawalpindi, Pakistan');
    $companyEmail   = setting('company_email', 'info@redissolution.com');
    $companyPhone   = setting('company_phone', '+92 349 3614440');
    $logoFile       = public_path('assets/brand/logo-main.png');

    $counterProjects = setting('counter_projects', '100');
    $counterYears    = setting('counter_years', '4');
    $counterSat      = setting('counter_satisfaction', '98');
@endphp

@push('styles')
<style>
/* ── Document-style input fields ── */
.pdf-field {
    border: none;
    border-bottom: 1.5px dashed rgba(0,0,0,0.18);
    background: transparent;
    color: #1a1a1a;
    outline: none;
    width: 100%;
    padding: 3px 0 4px;
    font-family: inherit;
    display: block;
    line-height: 1.4;
    transition: border-color 0.15s;
}
.pdf-field:focus { border-bottom-color: #FF6400; }
.pdf-field::placeholder { color: #bbb; }
.pdf-field-sm { font-size: 0.82rem; }
.pdf-field-lg { font-size: 1rem; font-weight: 700; }
.pdf-doc-section {
    padding: 14px 28px;
    border-bottom: 1px solid #e8e8e8;
}
.pdf-sec-title {
    font-size: 0.62rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #FF6400;
    border-bottom: 1.5px solid #FF6400;
    padding-bottom: 4px;
    margin-bottom: 10px;
}
.desc-editor,
.desc-editor * {
    color: #1a1a1a !important;
    background: transparent !important;
}
</style>
@endpush

<div x-data="proposalBuilder()">

    @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:0.75rem 1rem;margin-bottom:1.25rem">
            <strong style="color:#dc2626;font-size:0.88rem">Please fix the following errors:</strong>
            <ul style="margin:0.35rem 0 0 1.2rem;font-size:0.82rem;color:#dc2626">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $action }}" id="proposal-form" @submit="syncDesc()">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <input type="hidden" name="sections_enabled" :value="JSON.stringify(sections)">

        <div style="display:grid;grid-template-columns:1fr 330px;gap:1.5rem;align-items:start">

            {{-- ─────────────────────────────────────────
                 LEFT: Document-style proposal layout
            ───────────────────────────────────────────── --}}
            <div>

                {{-- Document wrapper --}}
                <div style="background:#fff;border:1px solid #d5d5d5;box-shadow:0 3px 16px rgba(0,0,0,0.1);overflow:hidden">

                    {{-- ── TOP ACCENT ── --}}
                    <div style="height:5px;background:#FF6400"></div>

                    {{-- ── HEADER BAND ── --}}
                    <div style="padding:18px 28px 15px;border-bottom:2px solid #FF6400">
                        <div style="display:grid;grid-template-columns:1fr auto;gap:2rem;align-items:start">
                            <div>
                                @if(file_exists($logoFile))
                                    <img src="{{ asset('assets/brand/logo-main.png') }}" style="height:44px;margin-bottom:7px;display:block">
                                @else
                                    <div style="font-size:1.1rem;font-weight:800;color:#FF6400;margin-bottom:4px">{{ $companyName }}</div>
                                @endif
                                <div style="font-size:0.7rem;color:#666;line-height:1.85">
                                    {{ $companyAddress }}<br>
                                    {{ $companyEmail }}<br>
                                    {{ $companyPhone }}
                                </div>
                            </div>
                            <div style="text-align:right;flex-shrink:0">
                                <div style="font-size:1.35rem;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#1a1a1a">Proposal</div>
                                <div style="display:inline-block;background:#FF6400;color:#fff;padding:2px 10px;font-weight:700;font-family:monospace;font-size:0.82rem;margin-top:3px">
                                    {{ $isEdit ? '#'.$proposal->proposal_number : '#NEW' }}
                                </div>
                                <div style="font-size:0.7rem;color:#666;line-height:1.85;margin-top:5px">
                                    Date: {{ now()->format('d M Y') }}<br>
                                    Currency: <span x-text="currency" style="font-weight:700;color:#1a1a1a"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── CLIENT / PROJECT BAND ── --}}
                    <div style="background:#fafafa;border-bottom:2px solid #FF6400;padding:16px 28px">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem">

                            {{-- Client --}}
                            <div>
                                <div style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#FF6400;margin-bottom:7px">Prepared For</div>

                                <input type="text" name="client_name" x-model="clientName"
                                    value="{{ old('client_name', $proposal?->client_name) }}"
                                    placeholder="Client Name *" required
                                    class="pdf-field pdf-field-lg"
                                    style="margin-bottom:7px">
                                @error('client_name')<div style="font-size:0.72rem;color:#dc2626;margin-top:-4px;margin-bottom:5px">{{ $message }}</div>@enderror

                                <input type="text" name="client_company"
                                    value="{{ old('client_company', $proposal?->client_company) }}"
                                    placeholder="Company (optional)"
                                    class="pdf-field pdf-field-sm"
                                    style="margin-bottom:5px">

                                <input type="email" name="client_email"
                                    value="{{ old('client_email', $proposal?->client_email) }}"
                                    placeholder="Email"
                                    class="pdf-field pdf-field-sm"
                                    style="margin-bottom:5px">

                                <input type="text" name="client_phone"
                                    value="{{ old('client_phone', $proposal?->client_phone) }}"
                                    placeholder="Phone"
                                    class="pdf-field pdf-field-sm"
                                    style="margin-bottom:6px">

                                <select name="platform" x-model="platform"
                                    class="pdf-field pdf-field-sm"
                                    style="cursor:pointer;margin-bottom:5px">
                                    <option value="">Platform — Select</option>
                                    @foreach(\App\Models\Proposal::platforms() as $key => $label)
                                        <option value="{{ $key }}" {{ old('platform', $proposal?->platform) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>

                                <div x-show="platform === 'fiverr'" x-transition style="display:flex;align-items:center;gap:4px">
                                    <span style="font-size:0.85rem;color:#888">@</span>
                                    <input type="text" name="fiverr_username"
                                        value="{{ old('fiverr_username', $proposal?->fiverr_username) }}"
                                        placeholder="fiverr username"
                                        class="pdf-field pdf-field-sm">
                                </div>
                            </div>

                            {{-- Project --}}
                            <div style="border-left:2px solid #FF6400;padding-left:1.5rem">
                                <div style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#FF6400;margin-bottom:7px">Project</div>

                                <input type="text" name="project_title"
                                    value="{{ old('project_title', $proposal?->project_title) }}"
                                    placeholder="Project Title *" required
                                    class="pdf-field pdf-field-lg"
                                    style="margin-bottom:10px">
                                @error('project_title')<div style="font-size:0.72rem;color:#dc2626;margin-top:-7px;margin-bottom:7px">{{ $message }}</div>@enderror

                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:8px">
                                    <div>
                                        <div style="font-size:0.58rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:3px">Timeline</div>
                                        <input type="text" name="timeline" x-model="timeline"
                                            value="{{ old('timeline', $proposal?->timeline) }}"
                                            placeholder="e.g. 2–3 Weeks"
                                            class="pdf-field pdf-field-sm">
                                    </div>
                                    <div>
                                        <div style="font-size:0.58rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:3px">Revisions</div>
                                        <input type="number" name="revision_rounds" x-model="revisionRounds"
                                            value="{{ old('revision_rounds', $proposal?->revision_rounds) }}"
                                            placeholder="3" min="0"
                                            class="pdf-field pdf-field-sm">
                                    </div>
                                </div>

                                <div>
                                    <div style="font-size:0.58rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:3px">Valid Until</div>
                                    <input type="date" name="valid_until" x-model="validUntil"
                                        value="{{ old('valid_until', $proposal?->valid_until?->format('Y-m-d') ?? now()->addDays(3)->format('Y-m-d')) }}"
                                        class="pdf-field pdf-field-sm">
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 1: Project Overview
                    ══════════════════════════════════════════════ --}}
                    <div x-show="sections['description']" x-transition class="pdf-doc-section">
                        <div class="pdf-sec-title">1. Project Overview</div>

                        {{-- Description toolbar --}}
                        <div style="display:flex;gap:3px;padding:5px 6px;border:1px solid #e0e0e0;border-bottom:0;border-radius:6px 6px 0 0;background:#f9f9f9;flex-wrap:wrap">
                            <button type="button" @mousedown.prevent="descCmd('bold')" style="width:26px;height:26px;border:1px solid #d8d8d8;border-radius:4px;background:#fff;cursor:pointer;font-weight:700;font-size:0.8rem;color:#1a1a1a">B</button>
                            <button type="button" @mousedown.prevent="descCmd('italic')" style="width:26px;height:26px;border:1px solid #d8d8d8;border-radius:4px;background:#fff;cursor:pointer;font-style:italic;font-size:0.8rem;color:#1a1a1a">I</button>
                            <button type="button" @mousedown.prevent="descCmd('underline')" style="width:26px;height:26px;border:1px solid #d8d8d8;border-radius:4px;background:#fff;cursor:pointer;text-decoration:underline;font-size:0.8rem;color:#1a1a1a">U</button>
                            <div style="width:1px;background:#e0e0e0;margin:2px 3px"></div>
                            <button type="button" @mousedown.prevent="descCmd('insertUnorderedList')" style="width:26px;height:26px;border:1px solid #d8d8d8;border-radius:4px;background:#fff;cursor:pointer;font-size:0.82rem;color:#1a1a1a"><i class="ri-list-unordered"></i></button>
                            <button type="button" @mousedown.prevent="descCmd('insertOrderedList')" style="width:26px;height:26px;border:1px solid #d8d8d8;border-radius:4px;background:#fff;cursor:pointer;font-size:0.82rem;color:#1a1a1a"><i class="ri-list-ordered"></i></button>
                            <div style="width:1px;background:#e0e0e0;margin:2px 3px"></div>
                            <button type="button" @mousedown.prevent="descClear()" style="padding:0 7px;height:26px;border:1px solid #d8d8d8;border-radius:4px;background:#fff;cursor:pointer;font-size:0.72rem;color:#888">Clear</button>
                        </div>
                        <div x-ref="descEditor"
                            contenteditable="true"
                            class="desc-editor"
                            @input="descHtml = $event.target.innerHTML"
                            style="min-height:100px;padding:0.65rem;border:1px solid #e0e0e0;border-radius:0 0 6px 6px;background:#fff;font-size:0.88rem;line-height:1.65;outline:none;cursor:text"></div>
                        <input type="hidden" name="project_description" :value="descHtml">
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 2: Scope of Work
                    ══════════════════════════════════════════════ --}}
                    <div x-show="sections['scope']" x-transition class="pdf-doc-section">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
                            <div class="pdf-sec-title" style="margin-bottom:0;flex:1;margin-right:12px">2. Scope of Work</div>
                            <button type="button" @click="addItem()"
                                style="background:#FF6400;color:#fff;border:none;border-radius:5px;padding:4px 11px;font-size:0.75rem;font-weight:700;cursor:pointer;white-space:nowrap;flex-shrink:0">
                                + Add Item
                            </button>
                        </div>

                        {{-- Unified table: header + items in one table so columns align --}}
                        <table style="width:100%;border-collapse:collapse">
                            <colgroup>
                                <col style="width:28px">
                                <col>
                                <col style="width:100px">
                                <template x-if="sections['prices']"><col style="width:100px"></template>
                                <col style="width:28px">
                            </colgroup>
                            <thead>
                                <tr style="background:#FF6400">
                                    <th style="padding:6px 8px;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#fff;text-align:left">#</th>
                                    <th style="padding:6px 8px;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#fff;text-align:left">Service / Deliverable</th>
                                    <th style="padding:6px 8px;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#fff;text-align:center">Delivery Days</th>
                                    <th x-show="sections['prices']" style="padding:6px 8px;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#fff;text-align:right">Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in items" :key="index">
                                    <tr :style="index % 2 === 1 ? 'background:#fdf8f5;border-bottom:1px solid #eee' : 'background:#fff;border-bottom:1px solid #eee'">
                                        <td style="padding:8px;font-size:0.72rem;color:#aaa;vertical-align:top;padding-top:11px" x-text="index + 1"></td>
                                        <td style="padding:8px;vertical-align:top">
                                            <input :name="'items['+index+'][title]'" x-model="item.title" required
                                                placeholder="Service or deliverable"
                                                class="pdf-field"
                                                style="font-size:0.85rem;font-weight:600;color:#1a1a1a;margin-bottom:4px">
                                            <input :name="'items['+index+'][description]'" x-model="item.description"
                                                placeholder="Description (optional)"
                                                class="pdf-field"
                                                style="font-size:0.78rem;color:#666;border-bottom-color:rgba(0,0,0,0.1)">
                                        </td>
                                        <td style="padding:8px;vertical-align:top;text-align:center">
                                            <input :name="'items['+index+'][delivery_days]'" x-model="item.delivery_days"
                                                placeholder="e.g. 5 Days"
                                                class="pdf-field"
                                                style="font-size:0.8rem;text-align:center">
                                        </td>
                                        <td x-show="sections['prices']" style="padding:8px;vertical-align:top">
                                            <input type="number" :name="'items['+index+'][price]'" x-model="item.price"
                                                min="0" step="0.01" placeholder="0.00"
                                                class="pdf-field"
                                                style="font-size:0.85rem;text-align:right;font-weight:700;color:#FF6400">
                                        </td>
                                        <td style="text-align:center;vertical-align:top;padding-top:8px">
                                            <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                                style="border:none;background:none;color:#ef4444;cursor:pointer;padding:2px 4px;font-size:0.88rem;line-height:1">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 3: Pricing Summary
                    ══════════════════════════════════════════════ --}}
                    <div x-show="sections['pricing']" x-transition class="pdf-doc-section">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
                            <div class="pdf-sec-title" style="margin-bottom:0;flex:1">3. Pricing Summary</div>
                            {{-- Mode toggle --}}
                            <div style="display:flex;gap:0;border:1px solid #e0e0e0;border-radius:6px;overflow:hidden;flex-shrink:0">
                                <button type="button" @click="milestoneMode = false"
                                    :style="!milestoneMode ? 'background:#FF6400;color:#fff' : 'background:#f9f9f9;color:#555'"
                                    style="padding:4px 10px;font-size:0.7rem;font-weight:700;border:none;cursor:pointer;transition:all 0.15s">
                                    Total Only
                                </button>
                                <button type="button" @click="milestoneMode = true"
                                    :style="milestoneMode ? 'background:#FF6400;color:#fff' : 'background:#f9f9f9;color:#555'"
                                    style="padding:4px 10px;font-size:0.7rem;font-weight:700;border:none;cursor:pointer;border-left:1px solid #e0e0e0;transition:all 0.15s">
                                    Milestones
                                </button>
                            </div>
                        </div>

                        {{-- Total Only mode --}}
                        <div x-show="!milestoneMode" style="max-width:290px;margin-left:auto">
                            <div style="border:2px solid #FF6400;padding:8px 12px;display:flex;justify-content:space-between;align-items:center">
                                <span style="font-size:0.95rem;font-weight:800;color:#FF6400">TOTAL</span>
                                <span style="font-size:1rem;font-weight:800;color:#FF6400" x-text="currency + ' ' + fmt(total)"></span>
                            </div>
                        </div>

                        {{-- Milestones mode --}}
                        <div x-show="milestoneMode">
                            <table style="width:100%;border-collapse:collapse;margin-bottom:8px">
                                <thead>
                                    <tr style="background:#f5f5f5">
                                        <th style="padding:6px 8px;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#555;text-align:left">Milestone / Payment Phase</th>
                                        <th style="padding:6px 8px;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#555;text-align:right;width:120px">Amount</th>
                                        <th style="width:28px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(ms, mi) in milestones" :key="mi">
                                        <tr style="border-bottom:1px solid #eee">
                                            <td style="padding:6px 8px">
                                                <input :name="'ms_label_'+mi" x-model="ms.label"
                                                    placeholder="e.g. On Project Start (50%)"
                                                    class="pdf-field" style="font-size:0.82rem">
                                            </td>
                                            <td style="padding:6px 8px">
                                                <input type="number" :name="'ms_amount_'+mi" x-model="ms.amount"
                                                    placeholder="0.00" min="0" step="0.01"
                                                    class="pdf-field" style="font-size:0.82rem;text-align:right;font-weight:700;color:#FF6400">
                                            </td>
                                            <td style="text-align:center">
                                                <button type="button" @click="removeMilestone(mi)" x-show="milestones.length > 1"
                                                    style="border:none;background:none;color:#ef4444;cursor:pointer;font-size:0.88rem">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <div style="display:flex;align-items:center;justify-content:space-between">
                                <button type="button" @click="addMilestone()"
                                    style="font-size:0.72rem;font-weight:700;color:#FF6400;background:none;border:1px dashed #FF6400;border-radius:4px;padding:3px 10px;cursor:pointer">
                                    + Add Milestone
                                </button>
                                <div style="font-size:0.78rem;color:#555">
                                    Total: <strong x-text="currency + ' ' + fmt(milestoneTotal)" style="color:#FF6400"></strong>
                                    <span x-show="Math.abs(milestoneTotal - total) > 0.01" style="color:#e53e3e;font-size:0.7rem" x-text="' ≠ ' + currency + ' ' + fmt(total) + ' (scope total)'"></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="milestone_mode" :value="milestoneMode ? '1' : '0'">
                        <input type="hidden" name="milestones" :value="JSON.stringify(milestones)">
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 4: Project Details (live preview)
                    ══════════════════════════════════════════════ --}}
                    <div x-show="sections['details']" x-transition class="pdf-doc-section">
                        <div class="pdf-sec-title">4. Project Details</div>
                        <div style="display:flex;gap:10px;flex-wrap:wrap">
                            <div x-show="timeline" style="border:1px solid #e0e0e0;padding:8px 12px;min-width:110px">
                                <div style="font-size:0.58rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:2px">Timeline</div>
                                <div style="font-size:0.9rem;font-weight:700;color:#1a1a1a" x-text="timeline"></div>
                            </div>
                            <div x-show="revisionRounds !== ''" style="border:1px solid #e0e0e0;padding:8px 12px;min-width:110px">
                                <div style="font-size:0.58rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:2px">Revision Rounds</div>
                                <div style="font-size:0.9rem;font-weight:700;color:#1a1a1a" x-text="revisionRounds + ' Rounds'"></div>
                            </div>
                            <div x-show="validUntil" style="border:1px solid #e0e0e0;padding:8px 12px;min-width:110px">
                                <div style="font-size:0.58rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#FF6400;margin-bottom:2px">Valid Until</div>
                                <div style="font-size:0.9rem;font-weight:700;color:#1a1a1a" x-text="validUntil"></div>
                            </div>
                            <div x-show="!timeline && revisionRounds === '' && !validUntil" style="font-size:0.8rem;color:#aaa;font-style:italic;padding:4px 0">
                                Fill in Timeline, Revisions, or Valid Until above to see this section
                            </div>
                        </div>
                        <div style="font-size:0.68rem;color:#bbb;margin-top:7px"><i class="ri-arrow-up-line"></i> Live preview — values come from the Project fields above</div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 5: Terms & Conditions
                    ══════════════════════════════════════════════ --}}
                    <div x-show="sections['terms']" x-transition class="pdf-doc-section">
                        <div class="pdf-sec-title">5. Terms &amp; Conditions</div>
                        <textarea name="terms_conditions" rows="5"
                            placeholder="• 50% advance payment required before project starts&#10;• Remaining 50% upon completion&#10;• Source code transferred after full payment"
                            style="width:100%;font-size:0.82rem;color:#333;border:1px dashed #d8d8d8;border-radius:6px;padding:8px 10px;background:#fafafa;outline:none;resize:vertical;line-height:1.75;font-family:inherit;box-sizing:border-box">{{ old('terms_conditions', $defaultTerms) }}</textarea>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 6: Why Redis Solution (static preview)
                    ══════════════════════════════════════════════ --}}
                    <div x-show="sections['why_us']" x-transition class="pdf-doc-section" style="opacity:0.8">
                        <div class="pdf-sec-title">6. Why Redis Solution?</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:5px;font-size:0.8rem;color:#333;line-height:1.7">
                            <div><span style="color:#FF6400;font-weight:700">✓</span> {{ $counterProjects }}+ Projects Delivered</div>
                            <div><span style="color:#FF6400;font-weight:700">✓</span> {{ $counterYears }}+ Years Experience</div>
                            <div><span style="color:#FF6400;font-weight:700">✓</span> {{ $counterSat }}% Client Satisfaction</div>
                            <div><span style="color:#FF6400;font-weight:700">✓</span> 24/7 Post-Launch Support</div>
                            <div><span style="color:#FF6400;font-weight:700">✓</span> 100% Code Ownership</div>
                            <div><span style="color:#FF6400;font-weight:700">✓</span> Agile Development</div>
                            <div><span style="color:#FF6400;font-weight:700">✓</span> NDA Before Discussion</div>
                            <div><span style="color:#FF6400;font-weight:700">✓</span> Transparent Communication</div>
                            <div><span style="color:#FF6400;font-weight:700">✓</span> On-Time Delivery</div>
                        </div>
                        <div style="font-size:0.67rem;color:#ccc;margin-top:6px"><i class="ri-lock-line"></i> Static content — auto-populated in PDF</div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 7: Contact / CTA (static preview)
                    ══════════════════════════════════════════════ --}}
                    <div x-show="sections['contact']" x-transition style="padding:14px 28px;background:#fff8f2;border-bottom:1px solid #ffd5a8;text-align:center">
                        <div style="font-size:0.95rem;font-weight:800;color:#FF6400;margin-bottom:3px">Ready to Get Started?</div>
                        <div style="font-size:0.75rem;color:#555;margin-bottom:5px">Accept this proposal by reaching out to us — we'll begin immediately upon advance payment.</div>
                        <div style="font-size:0.8rem;color:#333">
                            <strong>Email:</strong> {{ $companyEmail }}
                            &nbsp;|&nbsp;
                            <strong>Phone / WhatsApp:</strong> {{ $companyPhone }}
                        </div>
                        <div style="font-size:0.67rem;color:#ccc;margin-top:5px"><i class="ri-lock-line"></i> Static content — auto-populated in PDF</div>
                    </div>

                    {{-- ── INTERNAL NOTES (always — not in PDF) ── --}}
                    <div style="padding:12px 28px;background:#fffbf0;border-top:2px dashed #f0d080">
                        <div style="display:flex;align-items:center;gap:6px;margin-bottom:6px">
                            <i class="ri-eye-off-line" style="color:#d97706;font-size:0.88rem"></i>
                            <span style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#d97706">Internal Notes — NOT in PDF</span>
                        </div>
                        <textarea name="notes" rows="2"
                            placeholder="Private notes about this client or project…"
                            style="width:100%;font-size:0.82rem;color:#333;border:1px dashed #f0d080;border-radius:6px;padding:6px 10px;background:#fffde7;outline:none;resize:vertical;line-height:1.7;font-family:inherit;box-sizing:border-box">{{ old('notes', $proposal?->notes) }}</textarea>
                    </div>

                    {{-- ── FOOTER PREVIEW ── --}}
                    <div style="background:#1a1a1a;padding:5px 28px">
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <span style="font-size:0.62rem;color:#999">Confidential — Prepared exclusively for <span x-text="clientName || '[Client Name]'" style="color:#ccc"></span></span>
                            <span style="font-size:0.62rem;color:#777">{{ $isEdit ? $proposal->proposal_number : 'RS-PROP-####' }} · {{ now()->format('d M Y') }}</span>
                        </div>
                    </div>

                </div>{{-- end document --}}
            </div>{{-- end left --}}

            {{-- ─────────────────────────────────────────
                 RIGHT SIDEBAR
            ───────────────────────────────────────────── --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:1.5rem">

                {{-- Settings & Actions --}}
                <div class="crm-card">
                    <h3 style="font-size:0.8rem;font-weight:700;margin:0 0 1rem;text-transform:uppercase;letter-spacing:0.05em;opacity:0.6">Proposal Settings</h3>
                    <div class="form-group" style="margin-bottom:1.25rem">
                        <label class="form-label">Currency</label>
                        <select name="currency" x-model="currency" class="form-control">
                            @foreach(\App\Models\Proposal::currencies() as $code => $label)
                                <option value="{{ $code }}" {{ old('currency', $proposal?->currency ?? 'USD') === $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:0.6rem">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center" data-loading-text="Saving…">
                            <i class="ri-save-line"></i> {{ $isEdit ? 'Save Changes' : 'Create Proposal' }}
                        </button>
                        @if($isEdit)
                            <a href="{{ route('admin.proposals.preview', $proposal) }}" target="_blank" class="btn btn-secondary" style="width:100%;justify-content:center">
                                <i class="ri-eye-line"></i> Preview PDF
                            </a>
                            <a href="{{ route('admin.proposals.pdf', $proposal) }}" target="_blank" class="btn btn-secondary" style="width:100%;justify-content:center">
                                <i class="ri-download-line"></i> Download PDF
                            </a>
                        @endif
                        <a href="{{ $isEdit ? route('admin.proposals.show', $proposal) : route('admin.proposals.index') }}" class="btn btn-secondary" style="width:100%;justify-content:center">
                            Cancel
                        </a>
                    </div>
                </div>

                {{-- Live Price --}}
                <div class="crm-card" style="border:2px solid #FF640033">
                    <h3 style="font-size:0.85rem;font-weight:700;margin:0 0 0.75rem;color:#FF6400">
                        <i class="ri-price-tag-3-line"></i> Price Summary
                    </h3>
                    <div style="display:flex;flex-direction:column;gap:0.4rem">
                        <div style="display:flex;justify-content:space-between;font-size:0.84rem">
                            <span style="color:var(--crm-text-muted)">Items</span>
                            <span x-text="items.length + ' item' + (items.length !== 1 ? 's' : '')"></span>
                        </div>
                        <div style="border-top:2px solid #FF6400;margin-top:0.4rem;padding-top:0.5rem;display:flex;justify-content:space-between;font-size:1.05rem;font-weight:800;color:#FF6400">
                            <span>TOTAL</span>
                            <span x-text="currency + ' ' + fmt(total)"></span>
                        </div>
                    </div>
                </div>

                {{-- PDF STRUCTURE PREVIEW --}}
                <div class="crm-card" style="padding:0;overflow:hidden">
                    <div style="padding:0.85rem 1rem 0.6rem;border-bottom:1px solid var(--crm-border);display:flex;align-items:center;gap:0.5rem">
                        <i class="ri-file-pdf-line" style="color:#FF6400;font-size:1rem"></i>
                        <div>
                            <h3 style="font-size:0.82rem;font-weight:700;margin:0;text-transform:uppercase;letter-spacing:0.05em">PDF Preview</h3>
                            <p style="font-size:0.7rem;color:var(--crm-text-muted);margin:0">Click a section to toggle it</p>
                        </div>
                    </div>
                    <div style="padding:0.65rem 0.85rem;display:flex;flex-direction:column;gap:2px">

                        <div style="display:flex;align-items:center;gap:0.5rem;padding:0.42rem 0.6rem;border-left:3px solid #FF6400;background:#FF640009;border-radius:0 6px 6px 0">
                            <i class="ri-building-line" style="color:#FF6400;font-size:0.82rem;flex-shrink:0"></i>
                            <span style="font-size:0.76rem;font-weight:700;flex:1">Company Header</span>
                            <span style="font-size:0.65rem;color:#FF6400;font-weight:700;letter-spacing:0.04em">ALWAYS</span>
                        </div>

                        <div style="display:flex;align-items:center;gap:0.5rem;padding:0.42rem 0.6rem;border-left:3px solid #FF6400;background:#FF640009;border-radius:0 6px 6px 0">
                            <i class="ri-user-line" style="color:#FF6400;font-size:0.82rem;flex-shrink:0"></i>
                            <span style="font-size:0.76rem;font-weight:700;flex:1">Client &amp; Project</span>
                            <span style="font-size:0.65rem;color:#FF6400;font-weight:700;letter-spacing:0.04em">ALWAYS</span>
                        </div>

                        <div style="margin:0.2rem 0 0.2rem 0.5rem;padding-left:0.85rem;border-left:1px dashed var(--crm-border)">
                            <span style="font-size:0.67rem;color:var(--crm-text-muted);letter-spacing:0.05em">OPTIONAL SECTIONS</span>
                        </div>

                        @foreach($sectionLabels as $sKey => $sInfo)
                        <div @click="sections['{{ $sKey }}'] = !sections['{{ $sKey }}']"
                            style="display:flex;align-items:center;gap:0.5rem;padding:0.42rem 0.6rem;cursor:pointer;transition:all 0.15s;user-select:none;border-radius:6px"
                            :style="sections['{{ $sKey }}']
                                ? 'border-left:3px solid #FF6400;background:#FF640009;opacity:1'
                                : 'border-left:3px solid var(--crm-border);background:transparent;opacity:0.35'">
                            <span style="font-size:0.65rem;font-weight:800;min-width:14px;text-align:center;pointer-events:none"
                                :style="sections['{{ $sKey }}'] ? 'color:#FF6400' : 'color:var(--crm-text-muted)'">{{ $loop->iteration }}</span>
                            <i class="{{ $sInfo['icon'] }}" style="font-size:0.8rem;flex-shrink:0;pointer-events:none"
                                :style="sections['{{ $sKey }}'] ? 'color:#FF6400' : 'color:var(--crm-text-muted)'"></i>
                            <span style="font-size:0.76rem;font-weight:600;flex:1;pointer-events:none"
                                :style="sections['{{ $sKey }}'] ? 'text-decoration:none;color:var(--crm-text)' : 'text-decoration:line-through;color:var(--crm-text-muted)'">{{ $sInfo['label'] }}</span>
                            <div style="width:7px;height:7px;border-radius:50%;flex-shrink:0;pointer-events:none"
                                :style="sections['{{ $sKey }}'] ? 'background:#FF6400' : 'background:var(--crm-border)'"></div>
                        </div>
                        @endforeach

                        <div style="margin:0.2rem 0 0.2rem 0.5rem;padding-left:0.85rem;border-left:1px dashed var(--crm-border)"></div>

                        <div style="display:flex;align-items:center;gap:0.5rem;padding:0.42rem 0.6rem;border-left:3px solid #444;background:var(--crm-bg);border-radius:0 6px 6px 0">
                            <i class="ri-layout-bottom-line" style="color:#666;font-size:0.82rem;flex-shrink:0"></i>
                            <span style="font-size:0.76rem;font-weight:700;flex:1;color:var(--crm-text-muted)">Page Footer</span>
                            <span style="font-size:0.65rem;color:#666;font-weight:700;letter-spacing:0.04em">ALWAYS</span>
                        </div>

                    </div>
                </div>

            </div>{{-- end sidebar --}}
        </div>
    </form>
</div>

@push('scripts')
<script>
function proposalBuilder() {
    return {
        currency:       '{{ old('currency', $proposal?->currency ?? 'USD') }}',
        platform:       '{{ old('platform', $proposal?->platform ?? '') }}',
        items:          @json($initialItems),
        sections:       @json($initialSections),
        descHtml:       @json(old('project_description', $proposal?->project_description ?? '')),
        clientName:     @json(old('client_name', $proposal?->client_name ?? '')),
        timeline:       @json(old('timeline', $proposal?->timeline ?? '')),
        revisionRounds: @json(old('revision_rounds', $proposal?->revision_rounds !== null ? (string)$proposal->revision_rounds : '')),
        validUntil:     @json(old('valid_until', $proposal?->valid_until?->format('Y-m-d') ?? now()->addDays(3)->format('Y-m-d'))),
        milestoneMode:  {{ ($proposal?->milestone_mode ?? false) ? 'true' : 'false' }},
        milestones:     @json($initialMilestones),

        init() {
            this.$nextTick(() => {
                const el = this.$refs.descEditor;
                if (el && this.descHtml) {
                    el.innerHTML = this.descHtml;
                }
            });
        },

        descCmd(cmd) {
            this.$refs.descEditor.focus();
            document.execCommand(cmd, false, null);
            this.descHtml = this.$refs.descEditor.innerHTML;
        },

        descClear() {
            this.$refs.descEditor.focus();
            document.execCommand('removeFormat', false, null);
            this.descHtml = this.$refs.descEditor.innerHTML;
        },

        syncDesc() {
            this.descHtml = this.$refs.descEditor ? this.$refs.descEditor.innerHTML : '';
        },

        get subtotal() {
            return this.items.reduce((sum, item) => sum + (parseFloat(item.price) || 0), 0);
        },

        get total() {
            return this.subtotal;
        },

        get milestoneTotal() {
            return this.milestones.reduce((sum, ms) => sum + (parseFloat(ms.amount) || 0), 0);
        },

        addItem() {
            this.items.push({ title: '', description: '', delivery_days: '', price: 0 });
        },

        removeItem(index) {
            if (this.items.length > 1) { this.items.splice(index, 1); }
        },

        addMilestone() {
            this.milestones.push({ label: '', amount: 0 });
        },

        removeMilestone(index) {
            if (this.milestones.length > 1) { this.milestones.splice(index, 1); }
        },

        fmt(num) {
            return new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num || 0);
        },
    };
}
</script>
@endpush
