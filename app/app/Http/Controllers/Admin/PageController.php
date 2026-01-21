<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::orderBy('nav_order')
            ->orderByDesc('updated_at')
            ->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['nav_order'] = Page::max('nav_order') + 1;

        $request->validate([
            'title' => ['required', Rule::unique('pages', 'title')],
            'slug' => ['nullable', Rule::unique('pages', 'slug')],
        ]);

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('status', __('ui.pages.created'));
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);

        $request->validate([
            'title' => ['required', Rule::unique('pages', 'title')->ignore($page->id)],
            'slug' => ['nullable', Rule::unique('pages', 'slug')->ignore($page->id)],
        ]);

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('status', __('ui.pages.updated'));
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('status', __('ui.pages.deleted'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'content' => ['required', 'string'],
            'title_alignment' => ['required', Rule::in(['left', 'center', 'right'])],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
        ]);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:pages,id'],
        ]);

        foreach ($data['order'] as $index => $pageId) {
            Page::whereKey($pageId)->update(['nav_order' => $index]);
        }

        return response()->noContent();
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:4096'],
        ]);

        $path = $data['image']->store('pages', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }
}
