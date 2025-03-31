<?php

namespace App\Facades;

use App\Models\Blog;
use App\Models\Company;
use App\Models\Counter;
use App\Models\Country;
use App\Models\Hero;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\LearnMore;
use App\Models\Plan;
use App\Models\Review;
use App\Models\WhyChooseUs;

class HomeFacade
{
    public static function getHomeData(): array
    {
        return [
            'hero' => Hero::first(),
            'countries' => Country::all(),
            'jobCategories' => JobCategory::all(),
            'popularJobCategories' => JobCategory::withCount(['jobs' => function ($query) {
                $query->where(['status' => 'active'])
                    ->where('deadline', '>=', date('Y-m-d'));
            }])->where('show_at_popular', 1)->get(),
            'featuredCategories' => JobCategory::where('show_at_featured', 1)->take(10)->get(),
            'jobCount' => Job::count(),
            'whyChooseUs' => WhyChooseUs::first(),
            'learnMore' => LearnMore::first(),
            'counter' => Counter::first(),
            'companies' => Company::with('companyCountry', 'jobs')
                ->select('id', 'logo', 'name', 'slug', 'country', 'profile_completion', 'visibility')
                ->withCount(['jobs' => function ($query) {
                    $query->where(['status' => 'active'])
                        ->where('deadline', '>=', date('Y-m-d'));
                }])->where(['profile_completion' => 1, 'visibility' => 1])
                ->latest()->take(45)->get(),
            'locations' => JobLocation::latest()->take(8)->get(),
            'reviews' => Review::latest()->take(10)->get(),
            'plans' => Plan::where(['frontend_show' => 1, 'show_at_home' => 1])->get(),
            'blogs' => Blog::latest()->take(6)->get(),
        ];
    }
}
