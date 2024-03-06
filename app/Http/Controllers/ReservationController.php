<?php

namespace App\Http\Controllers;

use View;
use App\Models\User;
use App\Models\Group;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\UserGroup;
use App\Models\Reservation;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // $rows           = Reservation::where('u_id', Auth::id())->where('r_id', 1)->get();
        // $approval       = count($rows->approvals);
        // dd($approval);
        $rows           = Reservation::where('u_id', Auth::id())->paginate(20);

        return view('pages.reservation.index', compact('rows', 'msg'));
    }

    public function create(Request $request)
    {   
        $msg                = $request->session()->pull('session_msg', '');

        $id                 =      0;
        $r                  =      new Reservation;
        $types 	 	        =      VehicleType::get();


        return view('pages.reservation.form', compact('r', 'types', 'id', 'msg'));
    }

    public function store(Request $request, $id)
    {	
		if($id == 0){
            $request->request->add(['u_id' 	=> Auth::id(), 'requested_by' => Auth::id() ]);
            $r          = Reservation::create($request->all());
            $last_id    = $r->r_id;

            // Get the authenticated user
            $user = Auth::id();
            
            // Get the user's group ID
            $group_id = UserGroup::where('u_id', $user)->firstOrFail();

            $group = Group::where('g_id', $group_id->g_id)->firstOrFail();

            // Find or create a single approval for the group
            $approval = $group->approvals()->firstOrCreate([
                'g_id' => $group->g_id, // Assuming the column name is 'usergroup_id'
                'r_id' => $last_id,
                'status_id' => 1, // Set appropriate status ID for pending
                'remarks' => '', // Optional: Add remarks if needed
            ]);
            
            $request->session()->put('session_msg', 'Record successfully added.');
            }
         else {
            $request->session()->put('session_msg', 'Record updated.');
        }
        return redirect(route('reservation.index'));
    }

    public function view(Request $request, $id)
    {
        $msg            = $request->session()->pull('session_msg', '');
        $r              = Reservation::where('r_id', $id)->first();

         // Get the value of app_id from the query parameters
        $app_id = $request->query('app_id');

        if(!$r) {
            $request->session()->put('session_msg', 'Record not found.');
            return redirect(route('reservation.index'));
        }
        $types          = VehicleType::orderBy('name', 'asc')->get();
        
         // Fetch available vehicles and drivers
        $availability = $this->getAvailableVehiclesAndDrivers($r->start_date, $r->end_date);
        $availableVehicles = $availability['vehicles'];
        $availableDrivers = $availability['drivers'];
        
        return view('pages.reservation.view', compact('id', 'msg', 'r', 'types', 'app_id', 'availableVehicles', 'availableDrivers'));
    }

    public function getAvailableVehiclesAndDrivers($startDate, $endDate)
{
    // Fetch available vehicles
    $availableVehicles = Vehicle::whereNotExists(function ($query) use ($startDate, $endDate) {
        $query->select(DB::raw(1))
            ->from('reservations')
            ->whereRaw('vehicles.v_id = reservations.v_id')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereDate('start_date', '<=', $endDate)
                    ->whereDate('end_date', '>=', $startDate);
            });
    })->get();

    // Fetch available drivers
    $availableDrivers = Driver::whereNotExists(function ($query) use ($startDate, $endDate) {
        $query->select(DB::raw(1))
            ->from('reservations')
            ->whereRaw('drivers.name = reservations.driver_name') // Assuming driver name is stored in the reservations table
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereDate('start_date', '<=', $endDate)
                    ->whereDate('end_date', '>=', $startDate);
            });
    })->get();

    return [
        'vehicles' => $availableVehicles,
        'drivers' => $availableDrivers,
    ];
}
}
