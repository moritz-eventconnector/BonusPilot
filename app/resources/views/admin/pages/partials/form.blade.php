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
    <textarea name="content" rows="6" required>{{ old('content', $page->content ?? '') }}</textarea>
</div>
<div class="form-group">
    <label>SEO Title</label>
    <input type="text" name="seo_title" value="{{ old('seo_title', $page->seo_title ?? '') }}">
</div>
<div class="form-group">
    <label>SEO Description</label>
    <textarea name="seo_description" rows="2">{{ old('seo_description', $page->seo_description ?? '') }}</textarea>
</div>
