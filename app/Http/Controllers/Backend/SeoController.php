<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreSeoBacklinkRequest;
use App\Http\Requests\Backend\StoreSeoKeywordRequest;
use App\Http\Requests\Backend\UpdateSeoPageRequest;
use App\Models\SeoBacklink;
use App\Models\SeoKeyword;
use App\Models\SeoPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoController extends Controller
{
    // ── Dashboard ────────────────────────────────────────────────────────────

    public function index(): View
    {
        $pages = SeoPage::all();
        $keywords = SeoKeyword::count();
        $backlinks = SeoBacklink::count();
        $activeLinks = SeoBacklink::where('status', 'active')->count();
        $issues = $pages->sum(fn ($p) => count($p->issues()));
        $avgScore = $pages->count() ? (int) $pages->avg(fn ($p) => $p->healthScore()) : 0;

        $robotsTxt = file_exists(public_path('robots.txt'))
            ? file_get_contents(public_path('robots.txt'))
            : "User-agent: *\nAllow: /\n\nSitemap: ".url('sitemap.xml');

        return view('backend.seo.index', compact(
            'pages', 'keywords', 'backlinks', 'activeLinks', 'issues', 'avgScore', 'robotsTxt'
        ));
    }

    // ── Pages ─────────────────────────────────────────────────────────────────

    public function editPage(SeoPage $seoPage): View
    {
        return view('backend.seo.edit-page', compact('seoPage'));
    }

    public function updatePage(UpdateSeoPageRequest $request, SeoPage $seoPage): RedirectResponse
    {
        $seoPage->update($request->validated());

        return back()->with('success', 'SEO for "'.$seoPage->page_label.'" updated.');
    }

    // ── Keywords ─────────────────────────────────────────────────────────────

    public function keywords(): View
    {
        return view('backend.seo.keywords');
    }

    public function storeKeyword(StoreSeoKeywordRequest $request): RedirectResponse
    {
        SeoKeyword::create($request->validated());

        return back()->with('success', 'Keyword added.');
    }

    public function updateKeyword(StoreSeoKeywordRequest $request, SeoKeyword $keyword): RedirectResponse
    {
        $keyword->update($request->validated());

        return back()->with('success', 'Keyword updated.');
    }

    public function destroyKeyword(SeoKeyword $keyword): RedirectResponse
    {
        $keyword->delete();

        return back()->with('success', 'Keyword removed.');
    }

    // ── Backlinks ─────────────────────────────────────────────────────────────

    public function backlinks(): View
    {
        return view('backend.seo.backlinks');
    }

    public function storeBacklink(StoreSeoBacklinkRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['source_domain'] = SeoBacklink::extractDomain($data['source_url']);
        SeoBacklink::create($data);

        return back()->with('success', 'Backlink added.');
    }

    public function updateBacklink(StoreSeoBacklinkRequest $request, SeoBacklink $backlink): RedirectResponse
    {
        $data = $request->validated();
        $data['source_domain'] = SeoBacklink::extractDomain($data['source_url']);
        $backlink->update($data);

        return back()->with('success', 'Backlink updated.');
    }

    public function destroyBacklink(SeoBacklink $backlink): RedirectResponse
    {
        $backlink->delete();

        return back()->with('success', 'Backlink removed.');
    }

    // ── Tools ─────────────────────────────────────────────────────────────────

    public function auditLogs(): View
    {
        return view('backend.seo.audit-logs');
    }

    public function tools(): View
    {
        $robotsTxt = file_exists(public_path('robots.txt'))
            ? file_get_contents(public_path('robots.txt'))
            : "User-agent: *\nAllow: /\n\nSitemap: ".url('sitemap.xml');

        return view('backend.seo.tools', compact('robotsTxt'));
    }

    public function updateRobots(Request $request): RedirectResponse
    {
        $request->validate(['robots_txt' => ['required', 'string', 'max:10000']]);
        file_put_contents(public_path('robots.txt'), $request->input('robots_txt'));

        return back()->with('success', 'robots.txt updated.');
    }

    public function regenerateSitemap(): RedirectResponse
    {
        \Artisan::call('sitemap:generate');

        return back()->with('success', 'Sitemap regenerated at /sitemap.xml');
    }
}
