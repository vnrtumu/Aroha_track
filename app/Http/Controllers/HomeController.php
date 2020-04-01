<?php

namespace App\Http\Controllers;
use App\UserLog;

use Illuminate\Http\Request;
use Auth;
use View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
        $total_no_of_hours = DB::table("user_logs")->where('user_id', '=', Auth::user()->id)->whereDate('created_at', Carbon::today())->get()->sum("no_of_hours");
        $userlogs = UserLog::where('user_id', '=', Auth::user()->id)
                    ->whereDate('created_at', Carbon::today())
                    ->get();
        return View::make('home', compact('userlogs', 'total_no_of_hours'));
    }
}
