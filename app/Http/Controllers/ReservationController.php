<?php

namespace App\Http\Controllers;

use View;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Reservation' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {
            if(!Auth::user()) {

                return redirect('/login');
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();

            return $next($request);
        });
	}

    public function index(Request $request)
    {
        $msg            = $request->session()->pull('session_msg', '');

        $rows           = Reservation::paginate(20);

        return view('pages.reservation.index', compact('rows', 'msg'));
    }

    public function create(Request $request)
    {   
        $msg        = $request->session()->pull('session_msg', '');

        $id      =      0;
        $r       =      new Reservation;
        $vehicles 	 	 =      Vehicle::get();
		$users 	 	 =      User::where('u_enabled', '=', 1)->orderBy('last_name', 'asc')->get();


        return view('pages.reservation.form', compact('r', 'vehicles', 'users', 'id', 'msg'));
    }
}
