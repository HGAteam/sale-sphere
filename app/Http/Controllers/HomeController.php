<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $breadcrumb = [
            ['url' => '/', 'label' => trans('Home')],
            // ['url' => '/productos', 'label' => 'Brands'],
            // ['url' => '/productos/zapatos', 'label' => 'Zapatos'],
        ];
        return view('home',compact('breadcrumb'));
    }
}
