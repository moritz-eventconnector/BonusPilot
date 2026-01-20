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
            <button class="btn btn-outline" type="button" data-command="insertColumns">{{ __('ui.pages.editor.columns') }}</button>
            <button class="btn btn-secondary" type="button" data-command="removeFormat">{{ __('ui.pages.editor.clear') }}</button>
        </div>
        <div class="wysiwyg-editor" data-editor contenteditable="true" style="min-height:180px;padding:12px;border:1px solid #374151;border-radius:8px;background:#0f172a;color:#e5e7eb;">
            {!! old('content', $page->content ?? '') !!}
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

    if (editor && editorInput) {
        const linkPrompt = @json(__('ui.pages.editor.link_prompt'));
        const leftColumnTitle = @json(__('ui.pages.editor.columns_left_title'));
        const leftColumnText = @json(__('ui.pages.editor.columns_left_text'));
        const rightColumnTitle = @json(__('ui.pages.editor.columns_right_title'));
        const rightColumnText = @json(__('ui.pages.editor.columns_right_text'));

        const syncEditor = () => {
            editorInput.value = editor.innerHTML;
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
                document.execCommand(command, false, null);
                editor.focus();
            });
        });

        editor.addEventListener('input', syncEditor);
        editor.closest('form').addEventListener('submit', syncEditor);
    }
</script>
