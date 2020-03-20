<?php

namespace App\Http\Controllers;
use App\UserLog;

use Illuminate\Http\Request;
use Auth;

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
        $last_log = UserLog::where([['user_id', '=', Auth::user()->id],['last_logout_time', '=', '']])->get();
        $userlogs = UserLog::where('user_id', '=', Auth::user()->id)->get();
        return view('home', compact('userlogs', 'last_log'));
    }
}
