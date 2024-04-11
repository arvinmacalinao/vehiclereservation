<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Vehicle;
use App\Models\UserGroup;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use App\Models\VehicleStatus;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Vehicle' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {
            if(!Auth::user()) {
                return redirect('/login');
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();

            // Get the user's ID
            $userId = Auth::id();

            // Check if the user belongs to the RDU group
            $isRDU = UserGroup::where('u_id', $userId)
                ->where('g_id', 3)->orwhere('g_id', 1) // Replace $rduGroupId with the ID of the RDU group
                ->exists();

            if (!$isRDU) {
                // Redirect the user to a different route or show an error message
                return redirect()->route('dashboard')->with('session_msg', 'Unauthorized.');
            }

            return $next($request);
        });
	}

    public function index(Request $request)
    {
        $msg            = $request->session()->pull('session_msg', '');

        $rows           = Vehicle::paginate(20);

        return view('pages.vehicle.index', compact('rows', 'msg'));
    }
    
    public function create(Request $request)
    {   
        $msg        = $request->session()->pull('session_msg', '');
        $types      = VehicleType::get();
        $statuses   = VehicleStatus::get();

        $id      =      0;
        $v      =      new Vehicle;
        return view('pages.vehicle.form', compact('v', 'id', 'msg', 'types', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // $input      = $request->validated();

        if($id == 0) {
            $request->request->add(['created_by' => Auth::id()]);
            $v     = Vehicle::create($request->all());

            $request->session()->put('session_msg', 'Record successfully added.');
        } else {
            $v     = Vehicle::where('v_id', $id)->first();
            if(!$v ) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('vehicle.index'));
            }
            
            $request->request->add([
                'updated_at' => Carbon::now(), 
                'updated_by' => Auth::id()
            ]);
            $v->update($request->all());

            $request->session()->put('session_msg', 'Record updated.');
        }

        return redirect(route('vehicle.index'));
    }

    
    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $v          = Vehicle::where('v_id', $id)->first();

        $types      = VehicleType::get();
        $statuses   = VehicleStatus::get();

        if(!$v) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('vehicle.index'));
        }
        return view('pages.vehicle.form', compact('v', 'id', 'msg', 'types', 'statuses'));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Request $request, $id)
    {
        $v = Vehicle::where('v_id', $id)->first();
        if(!$v) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('vehicle.index'));
        } else {
            $v->deleted_at = Carbon::now();
            $v->update();

            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('vehicle.index'));
        }        
    }
}
