<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function index(): View
    {
        $categories = BlogCategory::withCount('posts')->orderBy('name')->get();

        return view('backend.blog.categories.index', compact('categories'));
    }

    public function edit(BlogCategory $category): View
    {
        return view('backend.blog.categories.edit', compact('category'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:blog_categories,name'],
            'color' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['color'] = $data['color'] ?? '#FF6400';

        BlogCategory::create($data);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category created.');
    }

    public function update(Request $request, BlogCategory $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:blog_categories,name,'.$category->id],
            'color' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['color'] = $data['color'] ?? '#FF6400';

        $category->update($data);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category updated.');
    }

    public function destroy(BlogCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category deleted.');
    }
}
