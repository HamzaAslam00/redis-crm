<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::active()->orderBy('display_order')->get();

        return view('frontend.home', compact('testimonials'));
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
        $categories = FaqCategory::active()
            ->with('activeFaqs')
            ->orderBy('display_order')
            ->get();

        return view('frontend.faqs', compact('categories'));
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
