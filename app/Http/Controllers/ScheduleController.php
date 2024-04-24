<?php

namespace App\Http\Controllers;

use View;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Schedule' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {
            if(!Auth::user()) {

                return redirect('/login');
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();

            return $next($request);
        });
	}

    public function vehicle(Request $request, $id)
    {
        $msg            = $request->session()->pull('session_msg', '');

        $rows =     Reservation::where('status_id', 1)->where('v_id', $id)->orderby('start_date', 'desc')->paginate(20);
       
        return view('pages.schedule.vehicle', compact('rows', 'msg', 'id'));
    }

    public function driver(Request $request, $id)
    {
        $msg            = $request->session()->pull('session_msg', '');

        $rows           = Reservation::where('status_id', 1)->where('driver_id', $id)->orderby('start_date', 'desc')->paginate(20);
       
        return view('pages.schedule.driver', compact('rows', 'msg', 'id'));
    }
}
