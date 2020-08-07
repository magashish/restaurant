<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cms;

class CmsController extends Controller
{
    //

    public function contact()
    {
        $cms = Cms::all();
        return view('pages.contact',compact('cms'));
    }

    public function about()
    {
        $cms = Cms::all();
        return view('pages.about',compact('cms'));
    }


    public function carrer()
    {
        $cms = Cms::all();
        return view('pages.carrers',compact('cms'));
    }

    public function teams()
    {
        $cms = Cms::all();
        return view('pages.teams',compact('cms'));
    }

    public function termsConditions()
    {
        $cms = Cms::all();
        return view('pages.termsConditions',compact('cms'));
    }

    public function refundCancellation()
    {
        $cms = Cms::all();
        return view('pages.refundCancellation',compact('cms'));
    }

    public function privacyPolicy()
    {
        $cms = Cms::all();
        return view('pages.privacyPolicy',compact('cms'));
    }

    public function cookiePolicy()
    {
        $cms = Cms::all();
        return view('pages.cookiePolicy',compact('cms'));
    }

    public function helpSupport()
    {
        $cms = Cms::all();
        return view('pages.helpSupport',compact('cms'));
    }

    public function partnerwithUs()
    {
        $cms = Cms::all();
        return view('pages.partnerwithUs',compact('cms'));
    }

    public function ridewithUs()
    {
        $cms = Cms::all();
        return view('pages.ridewithUs',compact('cms'));
    }
}
