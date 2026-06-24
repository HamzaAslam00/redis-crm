<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('frontend.home');
    }

    public function services(): View
    {
        return view('frontend.services');
    }

    public function about(): View
    {
        return view('frontend.about');
    }

    public function portfolio(): View
    {
        $items = PortfolioItem::active()
            ->orderBy('display_order')
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->get();

        return view('frontend.portfolio', compact('items'));
    }

    public function contact(): View
    {
        return view('frontend.contact');
    }

    public function faqs(): View
    {
        return view('frontend.faqs');
    }

    public function privacyPolicy(): View
    {
        return view('frontend.privacy-policy');
    }

    public function refundPolicy(): View
    {
        return view('frontend.refund-policy');
    }

    public function freeAudit(): View
    {
        return view('frontend.free-audit');
    }

    public function freeConsultation(): View
    {
        return view('frontend.free-consultation');
    }
}
