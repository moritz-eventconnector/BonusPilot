<div class="form-group">
    <label>{{ __('ui.pages.form.title') }}</label>
    <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" required>
</div>
<div class="form-group">
    <label>{{ __('ui.pages.form.slug') }}</label>
    <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}">
    <p style="margin-top:8px;color:#94a3b8;">{{ __('ui.pages.form.slug_help') }}</p>
</div>
<div class="form-group">
    <label>{{ __('ui.pages.form.status') }}</label>
    <select name="status">
        <option value="draft" {{ old('status', $page->status ?? 'draft') === 'draft' ? 'selected' : '' }}>{{ __('ui.pages.status.draft') }}</option>
        <option value="published" {{ old('status', $page->status ?? 'draft') === 'published' ? 'selected' : '' }}>{{ __('ui.pages.status.published') }}</option>
    </select>
</div>
<div class="form-group">
    <label>{{ __('ui.pages.form.content') }}</label>
    <div class="card" style="background:#111827;border:1px solid #1f2937;">
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;">
            <button class="btn btn-outline" type="button" data-command="bold">{{ __('ui.pages.editor.bold') }}</button>
            <button class="btn btn-outline" type="button" data-command="italic">{{ __('ui.pages.editor.italic') }}</button>
            <button class="btn btn-outline" type="button" data-command="underline">{{ __('ui.pages.editor.underline') }}</button>
            <button class="btn btn-outline" type="button" data-command="insertUnorderedList">{{ __('ui.pages.editor.list') }}</button>
            <button class="btn btn-outline" type="button" data-command="insertOrderedList">{{ __('ui.pages.editor.numbered') }}</button>
            <button class="btn btn-outline" type="button" data-command="createLink">{{ __('ui.pages.editor.link') }}</button>
            <button class="btn btn-outline" type="button" data-command="insertImage">{{ __('ui.pages.editor.image') }}</button>
            <button class="btn btn-outline" type="button" data-command="insertColumns">{{ __('ui.pages.editor.columns') }}</button>
            <button class="btn btn-secondary" type="button" data-command="removeFormat">{{ __('ui.pages.editor.clear') }}</button>
        </div>
        <input type="file" accept="image/*" data-editor-upload hidden>
        <div class="wysiwyg-editor" data-editor contenteditable="true" style="min-height:180px;padding:12px;border:1px solid #374151;border-radius:8px;background:#0f172a;color:#e5e7eb;">
            {!! old('content', $page->content ?? '') !!}
        </div>
        <div class="editor-image-controls" data-image-controls hidden>
            <div class="editor-image-group">
                <span class="editor-image-label">{{ __('ui.pages.editor.image_size') }}</span>
                <input type="range" min="20" max="100" value="100" data-image-size>
                <span class="editor-image-value" data-image-size-value>100%</span>
            </div>
            <div class="editor-image-group">
                <span class="editor-image-label">{{ __('ui.pages.editor.image_align') }}</span>
                <button type="button" class="btn btn-outline btn-sm" data-image-align="left">{{ __('ui.pages.editor.align_left') }}</button>
                <button type="button" class="btn btn-outline btn-sm" data-image-align="center">{{ __('ui.pages.editor.align_center') }}</button>
                <button type="button" class="btn btn-outline btn-sm" data-image-align="right">{{ __('ui.pages.editor.align_right') }}</button>
            </div>
            <div class="editor-image-group">
                <button type="button" class="btn btn-secondary btn-sm" data-image-remove>{{ __('ui.pages.editor.remove_image') }}</button>
            </div>
        </div>
        <textarea name="content" data-editor-input hidden required>{{ old('content', $page->content ?? '') }}</textarea>
        <p style="margin-top:8px;color:#94a3b8;">{{ __('ui.pages.form.content_help') }}</p>
    </div>
</div>
<div class="form-group">
    <label>{{ __('ui.pages.form.seo_title') }}</label>
    <input type="text" name="seo_title" value="{{ old('seo_title', $page->seo_title ?? '') }}">
</div>
<div class="form-group">
    <label>{{ __('ui.pages.form.seo_description') }}</label>
    <textarea name="seo_description" rows="2">{{ old('seo_description', $page->seo_description ?? '') }}</textarea>
</div>

<script>
    const editor = document.querySelector('[data-editor]');
    const editorInput = document.querySelector('[data-editor-input]');
    const toolbarButtons = document.querySelectorAll('[data-command]');
    const uploadButton = document.querySelector('[data-command="insertImage"]');
    const uploadInput = document.querySelector('[data-editor-upload]');
    const uploadUrl = @json(route('admin.pages.upload-image'));
    const imageControls = document.querySelector('[data-image-controls]');
    const imageSizeInput = document.querySelector('[data-image-size]');
    const imageSizeValue = document.querySelector('[data-image-size-value]');
    const imageAlignButtons = document.querySelectorAll('[data-image-align]');
    const imageRemoveButton = document.querySelector('[data-image-remove]');
    let selectedImage = null;

    if (editor && editorInput) {
        const linkPrompt = @json(__('ui.pages.editor.link_prompt'));
        const leftColumnTitle = @json(__('ui.pages.editor.columns_left_title'));
        const leftColumnText = @json(__('ui.pages.editor.columns_left_text'));
        const rightColumnTitle = @json(__('ui.pages.editor.columns_right_title'));
        const rightColumnText = @json(__('ui.pages.editor.columns_right_text'));

        const syncEditor = () => {
            editorInput.value = editor.innerHTML;
        };

        const updateImageSize = (value) => {
            if (!selectedImage) {
                return;
            }
            selectedImage.style.width = `${value}%`;
            selectedImage.style.height = 'auto';
            imageSizeValue.textContent = `${value}%`;
            syncEditor();
        };

        const updateImageAlignment = (alignment) => {
            if (!selectedImage) {
                return;
            }
            selectedImage.classList.remove('align-left', 'align-center', 'align-right');
            selectedImage.classList.add(`align-${alignment}`);
            syncEditor();
        };

        const showImageControls = (image) => {
            selectedImage = image;
            if (!imageControls || !imageSizeInput || !imageSizeValue) {
                return;
            }
            const editorWidth = editor.getBoundingClientRect().width || 1;
            const widthStyle = image.style.width;
            let currentWidth = 100;
            if (widthStyle?.includes('%')) {
                currentWidth = Math.min(100, Math.max(20, parseInt(widthStyle, 10)));
            } else if (image.width) {
                currentWidth = Math.min(100, Math.max(20, Math.round((image.width / editorWidth) * 100)));
            }
            imageSizeInput.value = currentWidth.toString();
            imageSizeValue.textContent = `${currentWidth}%`;
            imageControls.hidden = false;
        };

        const hideImageControls = () => {
            selectedImage = null;
            if (imageControls) {
                imageControls.hidden = true;
            }
        };

        toolbarButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const command = button.dataset.command;
                if (command === 'createLink') {
                    const url = window.prompt(linkPrompt);
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                    return;
                }
                if (command === 'insertColumns') {
                    const columnsMarkup = `
                        <div class="editor-columns">
                            <div class="editor-column">
                                <p><strong>${leftColumnTitle}</strong></p>
                                <p>${leftColumnText}</p>
                            </div>
                            <div class="editor-column">
                                <p><strong>${rightColumnTitle}</strong></p>
                                <p>${rightColumnText}</p>
                            </div>
                        </div>
                    `;
                    document.execCommand('insertHTML', false, columnsMarkup);
                    editor.focus();
                    syncEditor();
                    return;
                }
                if (command === 'insertImage') {
                    uploadInput?.click();
                    return;
                }
                document.execCommand(command, false, null);
                editor.focus();
            });
        });

        if (uploadButton && uploadInput) {
            uploadInput.addEventListener('change', async () => {
                const file = uploadInput.files?.[0];
                if (!file) {
                    return;
                }
                const formData = new FormData();
                formData.append('image', file);
                const token = document.querySelector('meta[name="csrf-token"]')?.content;
                try {
                    const response = await fetch(uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token ?? '',
                        },
                        body: formData,
                    });
                    if (!response.ok) {
                        throw new Error('Upload failed');
                    }
                    const data = await response.json();
                    if (data?.url) {
                        document.execCommand('insertImage', false, data.url);
                    }
                } catch (error) {
                    alert('Image upload failed.');
                } finally {
                    uploadInput.value = '';
                    editor.focus();
                    editorInput.value = editor.innerHTML;
                }
            });
        }

        if (imageSizeInput) {
            imageSizeInput.addEventListener('input', (event) => {
                const value = parseInt(event.target.value, 10);
                if (!Number.isNaN(value)) {
                    updateImageSize(value);
                }
            });
        }

        if (imageAlignButtons.length) {
            imageAlignButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    updateImageAlignment(button.dataset.imageAlign);
                });
            });
        }

        if (imageRemoveButton) {
            imageRemoveButton.addEventListener('click', () => {
                if (!selectedImage) {
                    return;
                }
                selectedImage.remove();
                hideImageControls();
                syncEditor();
            });
        }

        editor.addEventListener('click', (event) => {
            const target = event.target;
            if (target && target.tagName === 'IMG') {
                showImageControls(target);
                return;
            }
            if (!event.target.closest('[data-image-controls]')) {
                hideImageControls();
            }
        });

        document.addEventListener('click', (event) => {
            if (!editor.contains(event.target) && !event.target.closest('[data-image-controls]')) {
                hideImageControls();
            }
        });

        editor.addEventListener('input', syncEditor);
        editor.closest('form').addEventListener('submit', syncEditor);
    }
</script>
