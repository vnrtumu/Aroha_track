<?php

namespace App\Http\Controllers;

use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use DateTime;
use Carbon\Carbon;


use Illuminate\Support\Facades\Mail;

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

    public function history()
    {
        $total_no_of_hours = DB::table("user_logs")->where('user_id', '=', Auth::user()->id)->whereDate('created_at', Carbon::today())->get()->sum("no_of_hours");
        $userlogs = UserLog::where('user_id', '=', Auth::user()->id)
                    ->whereDate('created_at', Carbon::today())
                    ->get();
        return view('history', compact('userlogs', 'total_no_of_hours'));
    }


    public function sendemails()
    {
        $users = User::all();
       
        $array = [];
        for($i = 0; $i < count($users); $i++){
            $total_no_of_hours = DB::table("user_logs")->where('user_id', '=', $users[$i]->id)->whereDate('created_at', Carbon::today())->get()->sum("no_of_hours");
            $msg = "Today ".$users[$i]->name . "'s work timing is: " . gmdate("H:i:s", (int)$total_no_of_hours) ."secs" ;

            $email = $users[$i]->email;
            $messageData = ['name' => $users[$i]->name, 'email' => $users[$i]->email, 'data' =>  $msg];
            Mail::send('emails.mail', $messageData, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Aroha tracer Today work Status');
                $message->from('admin@aroha.co.in', 'Aroha Tracking');
            });

            array_push($array, $msg);

        }

        $data = $array;
        $email = 'ramesh@aroha.co.in';
        $messageData = ['name' => "Admin",  'data' =>  $data];
        Mail::send('emails.adminemail', $messageData, function ($message) use ($email) {
            $message->to($email)
                ->subject('Aroha tracer Today work Status');
            $message->from('admin@aroha.co.in', 'Aroha Tracking');
        });
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
        $task_status_login = DB::table('user_logs')
        ->where([['user_id', '=', $request->user_id], ['last_logout_time', '=', Null]])
        ->select('last_login_time')
        ->get();
        $seconds  = strtotime($request->last_logout_time) - strtotime($task_status_login[0]->last_login_time );
        $task_status = DB::table('user_logs')
            ->where([['user_id', '=', $request->user_id], ['last_logout_time', '=', Null]])
            ->update(['last_logout_time' => $request->last_logout_time, 'no_of_hours' => $seconds,  'updated_at' => now()]);
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
