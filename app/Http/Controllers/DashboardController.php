<?php

namespace App\Http\Controllers;

use View;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Dashboard' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {
            if(!Auth::user()) {

                return redirect('/login');
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();

            return $next($request);
        });
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $msg            = $request->session()->pull('session_msg', '');

        $now = now(); // Get the current date and time

        $reservations = Reservation::where('status_id', '1')->get();

        // Format reservation data for FullCalendar
        $events = [];
        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => $reservation->purpose,
                'start' => $reservation->start_date . 'T' . $reservation->time, 
                'time' => $reservation->time,
                'purpose' => $reservation->purpose,
                'destination' => $reservation->destination,
                'driver' => $reservation->driver_name ?? 'not set',
                'vehicle' => $reservation->vehicle->equipment_name ?? 'not set',
                'status' => $reservation->status->name,
            ];
        }


        return view('pages.dashboard', compact('msg', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
