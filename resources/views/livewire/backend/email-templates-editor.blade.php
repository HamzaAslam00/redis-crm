<div
    x-data="{
        previewOpen: false,
        previewHtml: '',
        textColor: '#333333',
        bgColor: '#ffff00',
        savedRange: null,
        sourceMode: false,
        colorPaletteOpen: false,
        templateColors: [],

        detectColors() {
            const html = this.getEditorBody();
            const matches = html.match(/#[0-9a-fA-F]{6}/gi) || [];
            const freq = {};
            matches.forEach(c => { const n = c.toLowerCase(); freq[n] = (freq[n] || 0) + 1; });
            this.templateColors = Object.entries(freq)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 10)
                .map(([hex]) => hex);
        },

        swapColor(oldHex, newHex) {
            if (!newHex || oldHex.toLowerCase() === newHex.toLowerCase()) { return; }
            const html = this.getEditorBody();
            const escaped = oldHex.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const updated = html.replace(new RegExp(escaped, 'gi'), newHex.toLowerCase());
            this.templateColors = this.templateColors.map(c =>
                c.toLowerCase() === oldHex.toLowerCase() ? newHex.toLowerCase() : c
            );
            this.loadEmailInFrame(updated);
        },

        execCmd(command, value) {
            const iframe = this.$refs.editorFrame;
            if (!iframe || !iframe.contentDocument) { return; }
            this.restoreSelection();
            iframe.contentWindow.focus();
            iframe.contentDocument.execCommand(command, false, value ?? null);
        },

        saveSelection() {
            const iframe = this.$refs.editorFrame;
            if (!iframe || !iframe.contentWindow) { return; }
            const sel = iframe.contentWindow.getSelection();
            if (sel && sel.rangeCount > 0) {
                this.savedRange = sel.getRangeAt(0).cloneRange();
            }
        },

        restoreSelection() {
            const iframe = this.$refs.editorFrame;
            if (!iframe || !iframe.contentWindow || !this.savedRange) { return; }
            iframe.contentWindow.focus();
            const sel = iframe.contentWindow.getSelection();
            sel.removeAllRanges();
            sel.addRange(this.savedRange);
        },

        insertLink() {
            const iframe = this.$refs.editorFrame;
            if (!iframe || !iframe.contentWindow) { return; }
            this.restoreSelection();
            iframe.contentWindow.focus();

            // Capture surrounding text style before the prompt dialog opens
            const sel = iframe.contentWindow.getSelection();
            let surroundColor = null;
            let surroundFont  = null;
            if (sel && sel.focusNode) {
                const node = sel.focusNode.nodeType === 3 ? sel.focusNode.parentElement : sel.focusNode;
                if (node) {
                    const cs = iframe.contentWindow.getComputedStyle(node);
                    surroundColor = cs.color;
                    surroundFont  = cs.fontFamily;
                }
            }

            const url = window.prompt('Enter URL:', 'https://');
            if (!url) { return; }

            iframe.contentDocument.execCommand('createLink', false, url);

            // Find the newly-created <a> and apply inline styles so saved HTML keeps the right colour/font
            const newSel = iframe.contentWindow.getSelection();
            if (newSel && newSel.anchorNode) {
                let el = newSel.anchorNode.nodeType === 3 ? newSel.anchorNode.parentElement : newSel.anchorNode;
                while (el && el.nodeName !== 'A') { el = el.parentElement; }
                if (el && el.nodeName === 'A') {
                    if (surroundColor) { el.style.color      = surroundColor; }
                    if (surroundFont)  { el.style.fontFamily = surroundFont;  }
                    el.style.textDecoration = 'underline';
                }
            }
        },

        loadEmailInFrame(html) {
            const iframe = this.$refs.editorFrame;
            if (!iframe) { return; }
            const doc = iframe.contentDocument || iframe.contentWindow.document;
            doc.open();
            doc.write(
                '<style>'
                + 'html,body{margin:0;padding:24px;background:#f0f2f5;box-sizing:border-box;font-family:Arial,sans-serif}'
                + 'a{color:inherit;font-family:inherit;font-size:inherit;font-weight:inherit;}'
                + '</style>'
                + (html || '')
            );
            doc.close();
            doc.designMode = 'on';
        },

        getEditorBody() {
            if (this.sourceMode) {
                return this.$refs.sourceTextarea ? this.$refs.sourceTextarea.value : '';
            }
            const iframe = this.$refs.editorFrame;
            if (!iframe || !iframe.contentDocument || !iframe.contentDocument.body) { return ''; }
            return iframe.contentDocument.body.innerHTML;
        },

        toggleSource() {
            if (this.sourceMode) {
                const html = this.$refs.sourceTextarea ? this.$refs.sourceTextarea.value : '';
                this.sourceMode = false;
                this.$nextTick(() => { this.loadEmailInFrame(html); });
            } else {
                const html = this.getEditorBody();
                this.sourceMode = true;
                this.$nextTick(() => {
                    if (this.$refs.sourceTextarea) {
                        this.$refs.sourceTextarea.value = html;
                        this.$refs.sourceTextarea.focus();
                    }
                });
            }
        },

        insertVariable(varKey, target) {
            if (target === 'body') {
                const iframe = this.$refs.editorFrame;
                if (iframe && iframe.contentWindow) {
                    iframe.contentWindow.focus();
                    iframe.contentDocument.execCommand('insertText', false, '{' + varKey + '}');
                }
            } else {
                const el = this.$refs.subjectInput;
                const start = el.selectionStart ?? el.value.length;
                const end   = el.selectionEnd   ?? el.value.length;
                const insert = '{' + varKey + '}';
                el.value = el.value.slice(0, start) + insert + el.value.slice(end);
                el.dispatchEvent(new Event('input'));
                el.focus();
                el.setSelectionRange(start + insert.length, start + insert.length);
            }
        },

        openPreview() {
            const body = this.getEditorBody();
            this.previewHtml = body
                .replace(/{client_name}/g,     'John Smith')
                .replace(/{user_name}/g,        'John Smith')
                .replace(/{user_email}/g,       'john@example.com')
                .replace(/{client_email}/g,     'john@example.com')
                .replace(/{company_name}/g,     'Redis Solution Pvt. Ltd.')
                .replace(/{company_phone}/g,    '+92 300 0000000')
                .replace(/{company_email}/g,    'info@redissolution.com')
                .replace(/{message}/g,          'I am interested in your web development services.')
                .replace(/{reply_body}/g,       'Thank you for your inquiry. We will get back to you shortly.')
                .replace(/{original_message}/g, 'I am interested in your web development services.')
                .replace(/{admin_name}/g,       'Admin User')
                .replace(/{domain}/g,           'example.com')
                .replace(/{renewal_date}/g,     '2026-07-15')
                .replace(/{days_left}/g,        '30')
                .replace(/{amount}/g,           'PKR 5,000')
                .replace(/{project_title}/g,    'E-Commerce Website')
                .replace(/{developer_name}/g,   'Ali Hassan')
                .replace(/{deadline}/g,         '2026-06-30')
                .replace(/{project_url}/g,      '#')
                .replace(/{temp_password}/g,    'Temp@1234')
                .replace(/{login_url}/g,        '#')
                .replace(/{reset_link}/g,       '#')
                .replace(/{expires_in}/g,       '60 minutes')
                .replace(/{proposal_number}/g,  'RS-PROP-2026-001')
                .replace(/{valid_until}/g,      '2026-07-01')
                .replace(/{view_link}/g,        '#')
                .replace(/{submitted_at}/g,     '2026-06-08 10:30 AM')
                .replace(/{service_interest}/g, 'Web Development')
                .replace(/{budget}/g,           'PKR 50,000–100,000')
                .replace(/{client_phone}/g,     '+92 300 0000000');
            this.previewOpen = true;
        }
    }"
    x-init="
        $nextTick(() => {
            loadEmailInFrame($wire.body || '');
            $wire.on('quill-load', ({ body }) => { loadEmailInFrame(body || ''); });
        });
    "
>

    <div style="display:grid;grid-template-columns:260px 1fr;gap:1.25rem;align-items:start">

        {{-- LEFT: Template List --}}
        <div class="crm-card" style="padding:0;overflow:hidden;position:sticky;top:80px">
            <div style="padding:0.875rem 1rem;border-bottom:1px solid var(--crm-border)">
                <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">
                    <i class="ri-mail-settings-line" style="color:#FF6400"></i> Templates
                </span>
            </div>
            <div>
                @foreach($templates as $tpl)
                    <button
                        wire:click="selectTemplate('{{ $tpl->slug }}')"
                        wire:loading.class="opacity-50"
                        style="width:100%;text-align:left;padding:0.75rem 1rem;background:{{ $selectedSlug === $tpl->slug ? 'rgba(255,100,0,0.1)' : 'transparent' }};border:none;border-bottom:1px solid var(--crm-border);cursor:pointer;transition:background 0.15s;border-left:3px solid {{ $selectedSlug === $tpl->slug ? '#FF6400' : 'transparent' }}"
                        onmouseover="if('{{ $selectedSlug }}' !== '{{ $tpl->slug }}') this.style.background='var(--crm-hover)'"
                        onmouseout="if('{{ $selectedSlug }}' !== '{{ $tpl->slug }}') this.style.background='transparent'">
                        <div style="font-size:0.82rem;font-weight:{{ $selectedSlug === $tpl->slug ? '700' : '500' }};color:{{ $selectedSlug === $tpl->slug ? '#FF6400' : 'var(--crm-text)' }};line-height:1.4">{{ $tpl->name }}</div>
                        <div style="font-size:0.72rem;color:var(--crm-text-muted);margin-top:0.15rem;font-family:monospace">{{ $tpl->slug }}</div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- RIGHT: Editor --}}
        <div>
            {{-- Subject --}}
            <div class="crm-card" style="margin-bottom:1.25rem">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:0.5rem">
                    <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted)">
                        <i class="ri-text" style="color:#FF6400"></i> Subject Line
                    </span>
                    <div style="display:flex;flex-wrap:wrap;gap:0.35rem">
                        @foreach($currentVars as $var)
                            <button type="button"
                                @click="insertVariable('{{ $var['key'] }}', 'subject')"
                                style="padding:0.2rem 0.55rem;background:rgba(255,100,0,0.1);border:1px solid rgba(255,100,0,0.25);border-radius:50px;font-size:0.72rem;font-weight:600;color:#FF6400;cursor:pointer;font-family:monospace;transition:background 0.15s"
                                onmouseover="this.style.background='rgba(255,100,0,0.2)'"
                                onmouseout="this.style.background='rgba(255,100,0,0.1)'"
                                title="{{ $var['desc'] }}">{{'{'}}{{ $var['key'] }}{{'}'}}</button>
                        @endforeach
                    </div>
                </div>
                <input
                    x-ref="subjectInput"
                    wire:model="subject"
                    type="text"
                    class="form-control"
                    placeholder="Email subject line…">
                @error('subject')
                    <p style="color:#ef4444;font-size:0.8rem;margin-top:0.3rem">{{ $message }}</p>
                @enderror
            </div>

            {{-- Body WYSIWYG --}}
            <div class="crm-card" style="margin-bottom:1.25rem;padding:0;overflow:hidden">

                {{-- Toolbar --}}
                <div style="display:flex;align-items:center;gap:2px;padding:0.5rem 0.75rem;border-bottom:1px solid var(--crm-border);background:var(--crm-hover);flex-wrap:wrap">

                    {{-- Basic formatting --}}
                    <button class="tb-btn" @mousedown.prevent="execCmd('bold')" title="Bold"><i class="ri-bold"></i></button>
                    <button class="tb-btn" @mousedown.prevent="execCmd('italic')" title="Italic"><i class="ri-italic"></i></button>
                    <button class="tb-btn" @mousedown.prevent="execCmd('underline')" title="Underline"><i class="ri-underline"></i></button>
                    <button class="tb-btn" @mousedown.prevent="execCmd('strikeThrough')" title="Strikethrough"><i class="ri-strikethrough"></i></button>

                    <span class="tb-sep"></span>

                    {{-- Font size --}}
                    <select class="tb-select" @change="execCmd('fontSize', $event.target.value)" title="Font Size">
                        <option value="1">Tiny</option>
                        <option value="2">Small</option>
                        <option value="3" selected>Normal</option>
                        <option value="4">Large</option>
                        <option value="5">Larger</option>
                        <option value="6">Huge</option>
                        <option value="7">Giant</option>
                    </select>

                    <span class="tb-sep"></span>

                    {{-- Text color --}}
                    <label class="tb-btn tb-color-btn" title="Text Color" @mousedown="saveSelection()">
                        <i class="ri-font-color" style="pointer-events:none"></i>
                        <span class="tb-color-bar" :style="'background:' + textColor" style="pointer-events:none"></span>
                        <input type="color" x-model="textColor" @change="restoreSelection(); execCmd('foreColor', textColor)">
                    </label>

                    {{-- Highlight color --}}
                    <label class="tb-btn tb-color-btn" title="Highlight / Background Color" @mousedown="saveSelection()">
                        <i class="ri-mark-pen-line" style="pointer-events:none"></i>
                        <span class="tb-color-bar" :style="'background:' + bgColor" style="pointer-events:none"></span>
                        <input type="color" x-model="bgColor" @change="restoreSelection(); execCmd('hiliteColor', bgColor)">
                    </label>

                    <span class="tb-sep"></span>

                    {{-- Alignment --}}
                    <button class="tb-btn" @mousedown.prevent="execCmd('justifyLeft')" title="Align Left"><i class="ri-align-left"></i></button>
                    <button class="tb-btn" @mousedown.prevent="execCmd('justifyCenter')" title="Align Center"><i class="ri-align-center"></i></button>
                    <button class="tb-btn" @mousedown.prevent="execCmd('justifyRight')" title="Align Right"><i class="ri-align-right"></i></button>

                    <span class="tb-sep"></span>

                    {{-- Lists --}}
                    <button class="tb-btn" @mousedown.prevent="execCmd('insertUnorderedList')" title="Bullet List"><i class="ri-list-unordered"></i></button>
                    <button class="tb-btn" @mousedown.prevent="execCmd('insertOrderedList')" title="Numbered List"><i class="ri-list-ordered"></i></button>

                    <span class="tb-sep"></span>

                    {{-- Link --}}
                    <button class="tb-btn" @mousedown.prevent="insertLink()" title="Insert Link"><i class="ri-link"></i></button>
                    <button class="tb-btn" @mousedown.prevent="execCmd('unlink')" title="Remove Link"><i class="ri-link-unlink"></i></button>

                    <span class="tb-sep"></span>

                    {{-- Clear formatting --}}
                    <button class="tb-btn" @mousedown.prevent="execCmd('removeFormat')" title="Clear Formatting"><i class="ri-format-clear"></i></button>

                    <span class="tb-sep"></span>

                    {{-- Template color theme --}}
                    <button class="tb-btn"
                        :style="colorPaletteOpen ? 'background:rgba(255,100,0,0.15);color:#FF6400' : ''"
                        @mousedown.prevent="if(!colorPaletteOpen){ detectColors(); } colorPaletteOpen = !colorPaletteOpen"
                        title="Template Color Theme — click any color to change it everywhere">
                        <i class="ri-palette-line"></i>
                    </button>

                    {{-- HTML source toggle --}}
                    <button class="tb-btn"
                        :style="sourceMode ? 'background:rgba(255,100,0,0.15);color:#FF6400' : ''"
                        @mousedown.prevent="toggleSource()"
                        title="Toggle HTML Source (advanced)">
                        <i class="ri-code-s-slash-line"></i>
                    </button>

                    {{-- Variable chips --}}
                    @if(count($currentVars))
                        <span class="tb-sep"></span>
                        <span style="font-size:0.68rem;color:var(--crm-text-muted);margin:0 4px;white-space:nowrap">Insert var:</span>
                        @foreach($currentVars as $var)
                            <button type="button"
                                @mousedown.prevent="insertVariable('{{ $var['key'] }}', 'body')"
                                style="padding:0.15rem 0.45rem;background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.25);border-radius:50px;font-size:0.68rem;font-weight:600;color:#6366f1;cursor:pointer;font-family:monospace;white-space:nowrap;transition:background 0.12s"
                                onmouseover="this.style.background='rgba(99,102,241,0.22)'"
                                onmouseout="this.style.background='rgba(99,102,241,0.1)'"
                                title="{{ $var['desc'] }}">{{'{'}}{{ $var['key'] }}{{'}'}}</button>
                        @endforeach
                    @endif
                </div>

                {{-- Color Palette Panel --}}
                <div x-show="colorPaletteOpen" x-cloak
                    style="padding:0.75rem 1rem;border-bottom:1px solid var(--crm-border);background:var(--crm-bg)">
                    <p style="font-size:0.7rem;font-weight:600;color:var(--crm-text-muted);margin:0 0 0.6rem;text-transform:uppercase;letter-spacing:0.05em">
                        <i class="ri-palette-line" style="color:#FF6400"></i>
                        Template Colors — click any swatch to change it everywhere
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:0.4rem">
                        <template x-for="(hex, i) in templateColors" :key="i">
                            <label
                                :title="'Change ' + hex + ' everywhere in this template'"
                                style="position:relative;display:inline-flex;align-items:center;gap:0.4rem;cursor:pointer;padding:0.3rem 0.6rem;border:1px solid var(--crm-border);border-radius:6px;background:var(--crm-hover);transition:border-color 0.12s"
                                onmouseover="this.style.borderColor='#FF6400'"
                                onmouseout="this.style.borderColor='var(--crm-border)'">
                                <span
                                    :style="'width:16px;height:16px;border-radius:3px;display:inline-block;flex-shrink:0;border:1px solid rgba(0,0,0,0.15);background:' + hex"
                                ></span>
                                <span x-text="hex" style="font-size:0.7rem;font-family:monospace;color:var(--crm-text);pointer-events:none"></span>
                                <input
                                    type="color"
                                    :value="hex"
                                    @change="swapColor(hex, $event.target.value)"
                                    style="position:absolute;opacity:0;inset:0;width:100%;height:100%;cursor:pointer;border:none;padding:0"
                                >
                            </label>
                        </template>
                        <template x-if="templateColors.length === 0">
                            <span style="font-size:0.75rem;color:var(--crm-text-muted)">No colors detected.</span>
                        </template>
                    </div>
                </div>

                {{-- Visual editor (iframe) --}}
                <div wire:ignore x-show="!sourceMode">
                    <iframe
                        x-ref="editorFrame"
                        style="width:100%;min-height:480px;border:none;display:block"
                        frameborder="0"
                    ></iframe>
                </div>

                {{-- HTML source editor --}}
                <div wire:ignore x-show="sourceMode" x-cloak>
                    <div style="padding:8px;background:#0d1117;border-top:1px solid #30363d">
                        <span style="font-size:0.7rem;color:#8b949e;font-family:monospace">
                            <i class="ri-information-line"></i>
                            Edit raw HTML — change colors like <code style="color:#FF6400">background:#FF6400</code> or <code style="color:#FF6400">#e05500</code> directly
                        </span>
                    </div>
                    <textarea
                        x-ref="sourceTextarea"
                        style="width:100%;min-height:480px;border:none;font-family:'SF Mono','Fira Code','Consolas',monospace;font-size:0.76rem;line-height:1.6;tab-size:2;background:#0d1117;color:#e6edf3;padding:16px;resize:vertical;outline:none;display:block;box-sizing:border-box"
                        spellcheck="false"
                    ></textarea>
                </div>
            </div>

            {{-- Actions --}}
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem">
                <div style="display:flex;gap:0.5rem">
                    <button type="button" @click="openPreview()" class="btn btn-secondary" style="display:inline-flex;align-items:center;gap:0.4rem">
                        <i class="ri-eye-line"></i> Preview
                    </button>
                    <button
                        type="button"
                        wire:click="resetToDefault"
                        wire:confirm="Reset this template to its original default content?"
                        class="btn btn-secondary"
                        style="display:inline-flex;align-items:center;gap:0.4rem;color:var(--crm-text-muted)">
                        <i class="ri-refresh-line"></i> Reset to Default
                    </button>
                </div>
                <button
                    type="button"
                    @click="$wire.setBody(getEditorBody()).then(() => $wire.save())"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="btn btn-primary"
                    style="display:inline-flex;align-items:center;gap:0.4rem">
                    <span wire:loading.remove wire:target="save"><i class="ri-save-line"></i> Save Template</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>
        </div>

    </div>

    {{-- Preview Modal --}}
    <div x-show="previewOpen" x-cloak
        style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1.5rem"
        @click.self="previewOpen = false">
        <div style="position:absolute;inset:0;background:rgba(0,0,0,0.7);backdrop-filter:blur(4px)"></div>
        <div style="position:relative;width:100%;max-width:680px;max-height:90vh;display:flex;flex-direction:column;background:var(--crm-card);border-radius:16px;border:1px solid var(--crm-border);overflow:hidden;z-index:1"
            @click.stop>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:1px solid var(--crm-border)">
                <span style="font-weight:700;color:var(--crm-text);font-size:0.9rem"><i class="ri-eye-line" style="color:#FF6400"></i> Email Preview (sample data)</span>
                <button @click="previewOpen = false" style="background:none;border:none;color:var(--crm-text-muted);cursor:pointer;font-size:1.2rem;line-height:1;padding:0">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div style="overflow-y:auto;flex:1">
                <iframe :srcdoc="previewHtml" style="width:100%;min-height:500px;border:none;background:#fff"></iframe>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }

    .tb-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 5px;
        background: transparent;
        color: var(--crm-text-muted);
        cursor: pointer;
        font-size: 0.9rem;
        position: relative;
        flex-shrink: 0;
        transition: background 0.12s, color 0.12s;
    }
    .tb-btn:hover {
        background: rgba(255,100,0,0.1);
        color: #FF6400;
    }
    .tb-select {
        height: 28px;
        border: 1px solid var(--crm-border);
        border-radius: 5px;
        background: var(--crm-input);
        color: var(--crm-text);
        font-size: 0.78rem;
        padding: 0 0.35rem;
        cursor: pointer;
        outline: none;
    }
    .tb-sep {
        width: 1px;
        height: 20px;
        background: var(--crm-border);
        margin: 0 3px;
        display: inline-block;
        flex-shrink: 0;
    }
    .tb-color-btn {
        cursor: pointer;
        padding-bottom: 4px;
    }
    .tb-color-bar {
        position: absolute;
        bottom: 3px;
        left: 5px;
        right: 5px;
        height: 3px;
        border-radius: 2px;
        display: block;
    }
    .tb-color-btn input[type="color"] {
        position: absolute;
        opacity: 0;
        inset: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        border: none;
        padding: 0;
    }
</style>
@endpush
