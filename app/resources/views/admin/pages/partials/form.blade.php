<div class="form-group">
    <label>Title</label>
    <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" required>
</div>
<div class="form-group">
    <label>Status</label>
    <select name="status">
        <option value="draft" {{ old('status', $page->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ old('status', $page->status ?? 'draft') === 'published' ? 'selected' : '' }}>Published</option>
    </select>
</div>
<div class="form-group">
    <label>Content</label>
    <div class="card" style="background:#111827;border:1px solid #1f2937;">
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;">
            <button class="btn btn-outline" type="button" data-command="bold">Bold</button>
            <button class="btn btn-outline" type="button" data-command="italic">Italic</button>
            <button class="btn btn-outline" type="button" data-command="underline">Underline</button>
            <button class="btn btn-outline" type="button" data-command="insertUnorderedList">List</button>
            <button class="btn btn-outline" type="button" data-command="insertOrderedList">Numbered</button>
            <button class="btn btn-outline" type="button" data-command="createLink">Link</button>
            <button class="btn btn-outline" type="button" data-command="insertColumns">2 Spalten</button>
            <button class="btn btn-secondary" type="button" data-command="removeFormat">Clear</button>
        </div>
        <div class="wysiwyg-editor" data-editor contenteditable="true" style="min-height:180px;padding:12px;border:1px solid #374151;border-radius:8px;background:#0f172a;color:#e5e7eb;">
            {!! old('content', $page->content ?? '') !!}
        </div>
        <textarea name="content" data-editor-input hidden required>{{ old('content', $page->content ?? '') }}</textarea>
        <p style="margin-top:8px;color:#94a3b8;">Formatiere den Text direkt im Editor. Die Inhalte werden als HTML gespeichert.</p>
    </div>
</div>
<div class="form-group">
    <label>SEO Title</label>
    <input type="text" name="seo_title" value="{{ old('seo_title', $page->seo_title ?? '') }}">
</div>
<div class="form-group">
    <label>SEO Description</label>
    <textarea name="seo_description" rows="2">{{ old('seo_description', $page->seo_description ?? '') }}</textarea>
</div>

<script>
    const editor = document.querySelector('[data-editor]');
    const editorInput = document.querySelector('[data-editor-input]');
    const toolbarButtons = document.querySelectorAll('[data-command]');

    if (editor && editorInput) {
        const syncEditor = () => {
            editorInput.value = editor.innerHTML;
        };

        toolbarButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const command = button.dataset.command;
                if (command === 'createLink') {
                    const url = window.prompt('Link URL');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                    return;
                }
                if (command === 'insertColumns') {
                    const columnsMarkup = `
                        <div class="editor-columns">
                            <div class="editor-column">
                                <p><strong>Bildbereich</strong></p>
                                <p>Füge hier ein Bild ein.</p>
                            </div>
                            <div class="editor-column">
                                <p><strong>Textbereich</strong></p>
                                <p>Schreibe hier deinen Text.</p>
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
