<x-layouts.backend title="New Blog Post">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
        <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h1 class="page-title">New Blog Post</h1>
            <p class="page-subtitle">Write and publish a new article.</p>
        </div>
    </div>

    {{-- Pass initial content (e.g. old() on validation fail) to JS before Alpine boots --}}
    <script>window.__blogEditorInit = @json(old('content', ''));</script>

    <form method="POST" action="{{ route('admin.blog.posts.store') }}"
        x-data="blogEditor"
        @submit="$refs.contentInput.value = getContent()">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

            {{-- Main Content --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem">

                <div class="crm-card">
                    <div class="form-group">
                        <label class="form-label" for="title">Title <span style="color:#F87171">*</span></label>
                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="Enter post title" autofocus style="font-size:1.1rem;font-weight:600">
                        @error('title')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="margin-top:1rem">
                        <label class="form-label" for="excerpt">Excerpt</label>
                        <textarea id="excerpt" name="excerpt" rows="2"
                            class="form-control @error('excerpt') is-invalid @enderror"
                            placeholder="Short summary shown in blog listing (max 500 chars)…" maxlength="500">{{ old('excerpt') }}</textarea>
                        @error('excerpt')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="margin-top:1rem">
                        <label class="form-label">Content <span style="color:#F87171">*</span></label>
                        <textarea name="content" x-ref="contentInput" style="display:none">{{ old('content') }}</textarea>
                        @error('content')<p class="form-error" style="margin-bottom:0.5rem">{{ $message }}</p>@enderror

                        {{-- Hidden file input for uploads --}}
                        <input type="file" x-ref="mediaUpload" accept="image/*,video/mp4,video/webm,video/mov" style="display:none" @change="handleUpload($event)">

                        <div style="border:1px solid var(--crm-border);border-radius:10px;overflow:hidden">

                            {{-- Main Toolbar --}}
                            <div style="display:flex;align-items:center;gap:2px;padding:0.45rem 0.75rem;border-bottom:1px solid var(--crm-border);background:var(--crm-hover);flex-wrap:wrap">
                                <select class="tb-select" @change="execCmd('formatBlock', $event.target.value)" title="Heading">
                                    <option value="p">Paragraph</option>
                                    <option value="h2">Heading 2</option>
                                    <option value="h3">Heading 3</option>
                                    <option value="h4">Heading 4</option>
                                    <option value="blockquote">Blockquote</option>
                                </select>
                                <span class="tb-sep"></span>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('bold')" title="Bold"><i class="ri-bold"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('italic')" title="Italic"><i class="ri-italic"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('underline')" title="Underline"><i class="ri-underline"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('strikeThrough')" title="Strikethrough"><i class="ri-strikethrough"></i></button>
                                <span class="tb-sep"></span>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('justifyLeft')" title="Left"><i class="ri-align-left"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('justifyCenter')" title="Center"><i class="ri-align-center"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('justifyRight')" title="Right"><i class="ri-align-right"></i></button>
                                <span class="tb-sep"></span>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('insertUnorderedList')" title="Bullet List"><i class="ri-list-unordered"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('insertOrderedList')" title="Numbered List"><i class="ri-list-ordered"></i></button>
                                <span class="tb-sep"></span>
                                <button type="button" class="tb-btn" @mousedown.prevent="insertLink()" title="Link"><i class="ri-link"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('unlink')" title="Remove Link"><i class="ri-link-unlink"></i></button>
                                <span class="tb-sep"></span>
                                <button type="button" class="tb-btn" @mousedown.prevent="insertImageUrl()" title="Image from URL"><i class="ri-image-line"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="$refs.mediaUpload.click()" title="Upload image or video from device" :style="uploading ? 'color:#FF6400' : ''"><i :class="uploading ? 'ri-loader-4-line' : 'ri-upload-cloud-line'"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="insertVideoUrl()" title="Embed YouTube video"><i class="ri-film-line"></i></button>
                                <button type="button" class="tb-btn" @mousedown.prevent="insertCodeBlock()" title="Code Block"><i class="ri-code-box-line"></i></button>
                                <span class="tb-sep"></span>
                                <button type="button" class="tb-btn" @mousedown.prevent="execCmd('removeFormat')" title="Clear Format"><i class="ri-format-clear"></i></button>
                                <span class="tb-sep"></span>
                                <button type="button" class="tb-btn" :style="sourceMode ? 'background:rgba(255,100,0,0.15);color:#FF6400' : ''" @mousedown.prevent="toggleSource()" title="HTML Source"><i class="ri-code-s-slash-line"></i></button>
                            </div>

                            {{-- Image position bar — appears when an image is clicked in editor --}}
                            <div x-show="showImgBar && !sourceMode" x-cloak
                                style="display:flex;align-items:center;gap:6px;padding:0.35rem 0.75rem;border-bottom:1px solid var(--crm-border);background:rgba(255,100,0,0.05)">
                                <span style="font-size:0.72rem;color:var(--crm-text-muted);margin-right:4px"><i class="ri-image-edit-line"></i> Image position:</span>
                                <button type="button" class="tb-btn" style="width:auto;padding:0 8px;font-size:0.72rem;gap:4px" @mousedown.prevent="setImgPosition('left')"><i class="ri-align-left"></i> Float Left</button>
                                <button type="button" class="tb-btn" style="width:auto;padding:0 8px;font-size:0.72rem;gap:4px" @mousedown.prevent="setImgPosition('center')"><i class="ri-align-center"></i> Center</button>
                                <button type="button" class="tb-btn" style="width:auto;padding:0 8px;font-size:0.72rem;gap:4px" @mousedown.prevent="setImgPosition('right')"><i class="ri-align-right"></i> Float Right</button>
                                <button type="button" class="tb-btn" style="width:auto;padding:0 8px;font-size:0.72rem;gap:4px" @mousedown.prevent="setImgPosition('full')"><i class="ri-fullscreen-line"></i> Full Width</button>
                            </div>

                            {{-- Visual iframe --}}
                            <div x-show="!sourceMode">
                                <iframe x-ref="editorFrame" style="width:100%;min-height:500px;border:none;display:block;background:var(--crm-input)" frameborder="0"></iframe>
                            </div>

                            {{-- Source textarea --}}
                            <div x-show="sourceMode" x-cloak>
                                <textarea x-ref="srcArea" style="width:100%;min-height:500px;border:none;font-family:monospace;font-size:0.78rem;line-height:1.6;background:var(--crm-input);color:var(--crm-text);padding:16px;resize:vertical;outline:none;display:block;box-sizing:border-box" spellcheck="false"></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- SEO --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1rem">SEO</h3>
                    <div class="form-grid-2">
                        <div class="form-group" style="grid-column:span 2">
                            <label class="form-label" for="slug">URL Slug</label>
                            <input type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug') }}" placeholder="auto-generated-from-title">
                            @error('slug')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="meta_title">Meta Title <small style="color:var(--crm-text-muted)">(max 80)</small></label>
                            <input type="text" id="meta_title" name="meta_title" maxlength="80"
                                class="form-control @error('meta_title') is-invalid @enderror"
                                value="{{ old('meta_title') }}" placeholder="SEO title for search engines">
                            @error('meta_title')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="meta_description">Meta Description <small style="color:var(--crm-text-muted)">(max 170)</small></label>
                            <input type="text" id="meta_description" name="meta_description" maxlength="170"
                                class="form-control @error('meta_description') is-invalid @enderror"
                                value="{{ old('meta_description') }}" placeholder="SEO description">
                            @error('meta_description')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;position:sticky;top:1.5rem">

                {{-- Publish --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1rem">Publish</h3>

                    <div class="form-group">
                        <label class="form-label" for="status">Status <span style="color:#F87171">*</span></label>
                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div style="display:flex;gap:0.75rem;margin-top:1.25rem">
                        <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-secondary" style="flex:1;justify-content:center">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">
                            <i class="ri-save-line"></i> Save
                        </button>
                    </div>
                </div>

                {{-- Category --}}
                <div class="crm-card">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1rem">Category</h3>
                    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('admin.blog.categories.index') }}" style="font-size:0.78rem;color:#FF6400;display:inline-block;margin-top:0.5rem">
                        <i class="ri-settings-3-line"></i> Manage categories
                    </a>
                    @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                {{-- Featured Image --}}
                <div class="crm-card" x-data="featuredImageUploader">
                    <h3 style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--crm-text-muted);margin-bottom:1rem">Featured Image</h3>

                    {{-- Preview --}}
                    <div x-show="preview" style="margin-bottom:0.75rem">
                        <img :src="preview" alt="" style="width:100%;height:140px;object-fit:cover;border-radius:8px;border:1px solid var(--crm-border)">
                    </div>

                    {{-- Upload button --}}
                    <input type="file" x-ref="fileInput" accept="image/*" style="display:none" @change="upload($event)">
                    <button type="button" @click="$refs.fileInput.click()" :disabled="uploading"
                        style="display:flex;align-items:center;gap:0.5rem;width:100%;padding:0.6rem 1rem;margin-bottom:0.75rem;border-radius:8px;border:1.5px dashed var(--crm-border);background:transparent;color:var(--crm-text-muted);font-size:0.85rem;cursor:pointer;transition:all 0.15s"
                        onmouseover="this.style.borderColor='#FF6400';this.style.color='#FF6400'" onmouseout="this.style.borderColor='var(--crm-border)';this.style.color='var(--crm-text-muted)'">
                        <i :class="uploading ? 'ri-loader-4-line' : 'ri-upload-cloud-line'" style="font-size:1rem"></i>
                        <span x-text="uploading ? 'Uploading…' : 'Upload from device'"></span>
                    </button>

                    {{-- URL fallback --}}
                    <label class="form-label" for="featured_image" style="font-size:0.78rem">Or paste image URL</label>
                    <input type="text" id="featured_image" name="featured_image"
                        class="form-control @error('featured_image') is-invalid @enderror"
                        x-model="url" placeholder="https://… or /storage/…">
                    @error('featured_image')<p class="form-error">{{ $message }}</p>@enderror
                </div>

            </div>

        </div>
    </form>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    .tb-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border: none; border-radius: 5px;
        background: transparent; color: var(--crm-text-muted); cursor: pointer;
        font-size: 0.9rem; flex-shrink: 0; transition: background 0.12s, color 0.12s;
    }
    .tb-btn:hover { background: rgba(255,100,0,0.1); color: #FF6400; }
    .tb-select {
        height: 28px; border: 1px solid var(--crm-border); border-radius: 5px;
        background: var(--crm-input); color: var(--crm-text); font-size: 0.78rem;
        padding: 0 0.35rem; cursor: pointer; outline: none;
    }
    .tb-sep {
        width: 1px; height: 20px; background: var(--crm-border);
        margin: 0 3px; display: inline-block; flex-shrink: 0;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('blogEditor', () => ({
        sourceMode: false,
        uploading: false,
        selectedImg: null,
        showImgBar: false,

        init() {
            this.$nextTick(() => this.initEditor(window.__blogEditorInit || ''));
        },

        initEditor(html) {
            const iframe = this.$refs.editorFrame;
            if (!iframe) return;
            const isLight = document.documentElement.getAttribute('data-theme') === 'light' ||
                (!document.documentElement.hasAttribute('data-theme') && window.matchMedia('(prefers-color-scheme: light)').matches);
            const bg   = isLight ? '#ffffff' : '#0d1117';
            const text = isLight ? '#1a1829'  : '#e6edf3';
            const head = isLight ? '#1a1829'  : '#ffffff';
            const bq   = isLight ? 'rgba(26,24,41,0.55)' : 'rgba(255,255,255,0.6)';
            const code = isLight ? 'rgba(26,24,41,0.07)'  : 'rgba(255,255,255,0.1)';
            const doc = iframe.contentDocument || iframe.contentWindow.document;
            doc.open();
            doc.write(
                '<style>' +
                'html,body{margin:0;padding:16px 20px;font-family:Arial,sans-serif;font-size:15px;line-height:1.7;color:' + text + ';background:' + bg + '}' +
                'h1,h2,h3,h4{margin:1.4rem 0 0.6rem;color:' + head + '}' +
                'p{margin:0 0 1rem}' +
                'a{color:#FF6400}' +
                'ul,ol{padding-left:1.5rem;margin:0 0 1rem}' +
                'blockquote{border-left:3px solid #FF6400;padding-left:1rem;margin:1rem 0;color:' + bq + ';font-style:italic}' +
                'code{background:' + code + ';padding:0.1rem 0.35rem;border-radius:4px;font-size:0.875em;font-family:monospace}' +
                'pre{background:#161b22;border:1px solid rgba(255,255,255,0.1);border-radius:8px;padding:1.1rem 1.2rem;overflow-x:auto;margin:1.2rem 0}' +
                'pre code{background:transparent;padding:0;font-size:0.82em;color:#79c0ff;line-height:1.65;display:block}' +
                'img{max-width:100%;height:auto;border-radius:8px;margin:0.5rem 0;cursor:pointer}' +
                'img.img-selected{outline:2px solid #FF6400;outline-offset:2px}' +
                'video{max-width:100%;border-radius:8px;margin:1rem 0}' +
                'iframe{max-width:100%;border-radius:8px}' +
                '</style>' + (html || '')
            );
            doc.close();
            doc.designMode = 'on';

            const self = this;
            doc.addEventListener('click', (e) => {
                doc.querySelectorAll('img.img-selected').forEach(i => i.classList.remove('img-selected'));
                if (e.target.tagName === 'IMG') {
                    e.target.classList.add('img-selected');
                    self.selectedImg = e.target;
                    self.showImgBar = true;
                } else {
                    self.selectedImg = null;
                    self.showImgBar = false;
                }
            });
        },

        setImgPosition(pos) {
            if (!this.selectedImg) return;
            const styles = {
                left:   'float:left;margin:0 1.2rem 0.8rem 0;max-width:48%;border-radius:8px',
                center: 'display:block;float:none;margin:1rem auto;max-width:100%;border-radius:8px',
                right:  'float:right;margin:0 0 0.8rem 1.2rem;max-width:48%;border-radius:8px',
                full:   'display:block;float:none;width:100%;margin:1rem 0;border-radius:8px',
            };
            this.selectedImg.style.cssText = styles[pos] || '';
        },

        execCmd(cmd, val) {
            const iframe = this.$refs.editorFrame;
            if (!iframe) return;
            iframe.contentWindow.focus();
            iframe.contentDocument.execCommand(cmd, false, val ?? null);
        },

        insertLink() {
            const iframe = this.$refs.editorFrame;
            if (!iframe) return;
            iframe.contentWindow.focus();
            const url = window.prompt('URL:', 'https://');
            if (url) iframe.contentDocument.execCommand('createLink', false, url);
        },

        insertImageUrl() {
            const url = window.prompt('Image URL:', 'https://');
            if (!url) return;
            const iframe = this.$refs.editorFrame;
            iframe.contentWindow.focus();
            iframe.contentDocument.execCommand('insertImage', false, url);
        },

        insertVideoUrl() {
            const url = window.prompt('YouTube URL:', 'https://www.youtube.com/watch?v=');
            if (!url) return;
            const yt = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/);
            const embedUrl = yt ? 'https://www.youtube.com/embed/' + yt[1] : url;
            const html =
                '<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;margin:1.2rem 0;border-radius:10px">' +
                '<iframe src="' + embedUrl + '" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;border-radius:10px" allowfullscreen loading="lazy"></iframe>' +
                '</div><p><br></p>';
            const iframe = this.$refs.editorFrame;
            iframe.contentWindow.focus();
            iframe.contentDocument.execCommand('insertHTML', false, html);
        },

        async handleUpload(e) {
            const file = e.target.files[0];
            if (!file) return;
            this.uploading = true;
            try {
                const fd = new FormData();
                fd.append('file', file);
                const res = await fetch('{{ route('admin.blog.upload-media') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: fd,
                });
                if (!res.ok) { alert('Upload failed.'); return; }
                const data = await res.json();
                const iframe = this.$refs.editorFrame;
                iframe.contentWindow.focus();
                if (data.type === 'video') {
                    const html =
                        '<video controls style="max-width:100%;border-radius:8px;margin:1rem 0">' +
                        '<source src="' + data.url + '" type="' + data.mime + '">' +
                        '</video><p><br></p>';
                    iframe.contentDocument.execCommand('insertHTML', false, html);
                } else {
                    iframe.contentDocument.execCommand('insertImage', false, data.url);
                }
            } finally {
                this.uploading = false;
                e.target.value = '';
            }
        },

        insertCodeBlock() {
            const iframe = this.$refs.editorFrame;
            iframe.contentWindow.focus();
            iframe.contentDocument.execCommand('insertHTML', false, '<pre><code>// your code here</code></pre><p><br></p>');
        },

        toggleSource() {
            const iframe = this.$refs.editorFrame;
            if (this.sourceMode) {
                const html = this.$refs.srcArea.value;
                this.sourceMode = false;
                this.$nextTick(() => this.initEditor(html));
            } else {
                const html = iframe.contentDocument.body.innerHTML;
                this.sourceMode = true;
                this.$nextTick(() => { this.$refs.srcArea.value = html; });
            }
        },

        getContent() {
            if (this.sourceMode) return this.$refs.srcArea.value;
            const iframe = this.$refs.editorFrame;
            return iframe?.contentDocument?.body?.innerHTML || '';
        },
    }));

    Alpine.data('featuredImageUploader', (initial = '') => ({
        url: initial,
        preview: initial || null,
        uploading: false,
        async upload(event) {
            const file = event.target.files[0];
            if (!file) { return; }
            this.uploading = true;
            const form = new FormData();
            form.append('file', file);
            form.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            try {
                const res = await fetch('{{ route('admin.blog.upload-media') }}', { method: 'POST', body: form });
                const data = await res.json();
                this.url = data.url;
                this.preview = data.url;
            } catch (e) {
                console.error('Upload failed', e);
            } finally {
                this.uploading = false;
                event.target.value = '';
            }
        },
    }));
});
</script>
@endpush

</x-layouts.backend>
