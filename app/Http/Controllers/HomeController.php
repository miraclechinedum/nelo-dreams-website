<?php

namespace App\Http\Controllers;

use App\Models\CoreValue;
use App\Models\GalleryImage;
use App\Models\ImpactStory;
use App\Models\Objective;
use App\Models\Partner;
use App\Models\Program;
use App\Models\Statistic;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'statistics' => Statistic::active()->ordered()->get(),
            'objectives' => Objective::active()->ordered()->get(),
            'coreValues' => CoreValue::active()->ordered()->get(),
            'programs' => Program::active()->ordered()->get(),
            'stories' => ImpactStory::active()->ordered()->get(),
            'gallery' => GalleryImage::active()->ordered()->get(),
            'testimonials' => Testimonial::active()->ordered()->get(),
            'rangers' => Partner::where('is_strategic', true)->active()->ordered()->first(),
            'partners' => Partner::where('is_strategic', false)->active()->ordered()->get(),
        ]);
    }
}
