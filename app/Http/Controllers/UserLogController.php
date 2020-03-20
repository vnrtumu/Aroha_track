<?php

namespace App\Http\Controllers;

use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;

class UserLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userlog = UserLog::all();
       
        return view('home', compact('userlog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $userlog  = [];
        $user  = DB::table('users')
                ->where('email', '=', $request->email)
                ->get();

        if(count($user) == 1){
            $userlog['user_id'] = $user[0]->id;
            $userlog['last_login_time'] = $request->last_login_time;
            $userlog = UserLog::create($userlog);
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserLog $userLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLog $userLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $task_status = DB::table('user_logs')
            ->where('user_id', '=', $request->user_id)
            ->update(['last_logout_time' => $request->last_logout_time,  'updated_at' => now()]);
        Auth::logout();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLog $userLog)
    {
        //
    }
}
