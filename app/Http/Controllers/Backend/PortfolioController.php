<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('backend.portfolio.index');
    }

    public function create(): View
    {
        return view('backend.portfolio.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:portfolio_items,slug'],
            'client_name' => ['nullable', 'string', 'max:150'],
            'category' => ['required', 'in:web,mobile,marketing,erp,ai,software'],
            'short_desc' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'tech_stack' => ['nullable', 'string'],
            'project_url' => ['nullable', 'url', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'results' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:active,draft'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        $data['tech_stack'] = $data['tech_stack']
            ? array_filter(array_map('trim', explode(',', $data['tech_stack'])))
            : null;

        $data['results'] = $data['results']
            ? array_filter(array_map('trim', explode("\n", $data['results'])))
            : null;

        PortfolioItem::create($data);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item created.');
    }

    public function edit(PortfolioItem $portfolio): View
    {
        return view('backend.portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, PortfolioItem $portfolio): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:portfolio_items,slug,'.$portfolio->id],
            'client_name' => ['nullable', 'string', 'max:150'],
            'category' => ['required', 'in:web,mobile,marketing,erp,ai,software'],
            'short_desc' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'tech_stack' => ['nullable', 'string'],
            'project_url' => ['nullable', 'url', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'results' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:active,draft'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        $data['tech_stack'] = $data['tech_stack']
            ? array_filter(array_map('trim', explode(',', $data['tech_stack'])))
            : null;

        $data['results'] = $data['results']
            ? array_filter(array_map('trim', explode("\n", $data['results'])))
            : null;

        $portfolio->update($data);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item updated.');
    }

    public function destroy(PortfolioItem $portfolio): RedirectResponse
    {
        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item deleted.');
    }
}
