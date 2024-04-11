<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Group;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Approval;
use App\Models\UserRole;
use App\Models\UserGroup;
use App\Models\Reservation;
use App\Models\VehicleType;
use App\Models\Notification;
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

        // Get the authenticated user
        $user = Auth::id();

        // Get the user's group ID
        $userGroup = UserGroup::where('u_id', $user)->firstOrFail();
        // Get the user's role ID
        $userrole  = UserRole::wherE('u_id', $user)->firstorFail();

        if($userrole->roles->name == 'RANK AND FILE')
        {
            $rows  = Reservation::where('u_id', Auth::id())->paginate(20);
        }
        elseif($userrole->roles->name == 'SUPERADMIN')
        {
            $rows  = Reservation::paginate(20);
        }
        elseif($userGroup->g_id == 3)
        {
            $rows  = Reservation::paginate(20);
        }
        else
        {
         // Display reservations for the user group
           $rows = Reservation::join('users', 'reservations.u_id', '=', 'users.u_id')
                   ->join('user_groups', 'users.u_id', '=', 'user_groups.u_id')
                   ->where('user_groups.g_id', $userGroup->g_id)
                   ->paginate(20);
        }
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
            $status_id = 2;
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
                'g_id' => $group->g_id,
                'r_id' => $last_id,
                'status_id' => 1,
                'remarks' => '',
            ]);

            // Notify admins
            $this->notifyAdminsAboutNewReservation($r);

            // Notify user group
            $this->notifyUserGroup($approval);

            $request->session()->put('session_msg', 'Record successfully added.');
            }
         else {
            $r     = Reservation::where('r_id', $id)->first();
            if(!$r ) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('reservation.index'));
            }
            
            $request->request->add([
                'updated_at' => Carbon::now(), 
                'updated_by' => Auth::id()
            ]);
            $r->update($request->all());
            $request->session()->put('session_msg', 'Record updated.');
        }
        return redirect(route('reservation.index'));
    }

    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $r          = Reservation::where('r_id', $id)->first();
        if(!$r) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('reservation.index'));
        }

        $types 	 	        =      VehicleType::get();

        return view('pages.reservation.form', compact('r', 'id', 'msg', 'types'));
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
        $availability = $this->getAvailableVehiclesAndDrivers($r->start_date, $r->end_date, $r->time, $r->end_time, $r->vtype_id);
        $availableVehicles = $availability['vehicles'];
        $availableDrivers = $availability['drivers'];
        
        return view('pages.reservation.view', compact('id', 'msg', 'r', 'types', 'app_id', 'availableVehicles', 'availableDrivers'));
    }

    public function getAvailableVehiclesAndDrivers($startDate, $endDate, $startTime, $endTime, $vtype_id)
    {
        // Fetch available vehicles
        // $availableVehicles = Vehicle::
        // where('type_id', $vtype_id)
        // ->where('status_id', '=', 1)->get();

        $availableDrivers = Driver::whereHas('roless', function ($query) {
            $query->whereHas('roles', function ($query) {
                $query->where('name', 'DRIVER');
            });
        })
        ->get();

        // Fetch available vehicles
        $availableVehicles = Vehicle::
        where('type_id', $vtype_id)
        ->where('status_id', '=', 1)
        ->whereNotExists(function ($query) use ($startDate, $endDate, $startTime, $endTime) {
        $query->select(DB::raw(1))
            ->from('reservations')
            ->whereRaw('vehicles.v_id = reservations.v_id')
            ->where(function ($query) use ($startDate, $endDate, $startTime, $endTime) {
                $query->whereDate('start_date', '<=', $endDate)
                    ->whereDate('end_date', '>=', $startDate)
                    ->whereTime('time', '<=', $endTime)
                    ->whereTime('end_time', '>=', $startTime);
            });
        })
        ->get();

        // Fetch available drivers
        // $availableDrivers = Driver::
        //     whereHas('roles', function ($query) {
        //         $query->where('name', 'DRIVER');
        //     })
        //     ->whereNotExists(function ($query) use ($startDate, $endDate, $startTime, $endTime) {
        //         $query->select(DB::raw(1))
        //             ->from('reservations')
        //             ->whereRaw('drivers.u_id = reservations.driver_id')
        //             ->where(function ($query) use ($startDate, $endDate, $startTime, $endTime) {
        //                 $query->whereDate('start_date', '<=', $endDate)
        //                     ->whereDate('end_date', '>=', $startDate)
        //                     ->whereTime('time', '<=', $endTime)
        //                     ->whereTime('end_time', '>=', $startTime);
        //             });
        //     })
        // ->get();
        

        return [
            'vehicles' => $availableVehicles,
            'drivers' => $availableDrivers,
        ];
    }

    private function notifyAdminsAboutNewReservation($r) {
        // Get the IDs of admins with the SUPERADMIN role
        $superAdmins = UserRole::whereHas('roles', function ($query) {
            $query->where('name', 'SUPERADMIN');
        })->pluck('u_id')->toArray();
    
        // Create notifications for each admin
        foreach ($superAdmins as $adminId) {
            Notification::create([
                'not_message' => 'New reservation created by: ' . $r->user->full_name,
                'r_id' => $r->r_id, 
                'u_id' => $adminId,
                'new_user_id' => null,
                'app_id' => null,
                'read_at' => null,
            ]);
        }
    }

    private function notifyUserGroup($approval) {
        // Retrieve all user IDs belonging to the user group
        $userIds = User::join('user_groups', 'users.u_id', '=', 'user_groups.u_id')
        ->where('user_groups.g_id', $approval->g_id)
        ->pluck('users.u_id');

        $userIdsFiltered = User::leftJoin('user_roles', 'users.u_id', '=', 'user_roles.u_id')
        ->where('users.deleted_at', null) // Ensure users are not soft deleted
        ->where('user_roles.role_id', '<>', 1) // Exclude users with role_id = 1 (RANK AND FILE)
        ->whereIn('users.u_id', $userIds)
        ->pluck('users.u_id');
        
        // Send notifications to the filtered users
        foreach ($userIdsFiltered as $userId) {
        Notification::create([
            'not_message' => 'New approval created for Reservation created by ' . $approval->reservation->user->full_name,
            'r_id' => null, // Assuming this is not relevant for this notification
            'u_id' => $userId,
            'new_user_id' => null,
            'app_id' => $approval->app_id,
            'read_at' => null,
        ]);
        }
    }


    public function view2(Request $request, $id)
    {
        $msg            = $request->session()->pull('session_msg', '');
        $r              = Reservation::where('r_id', $id)->first();
        if(!$r) {
            $request->session()->put('session_msg', 'Record not found.');
            return redirect(route('reservation.index'));
        }
        $vehicle_type  = VehicleType::where('vtype_id', $r->vtype_id)->first();

         // Fetch available vehicles and drivers
         $availability = $this->getAvailableVehiclesAndDrivers($r->start_date, $r->end_date, $r->time, $r->end_time, $r->vtype_id);
         $availableVehicles = $availability['vehicles'];
         $availableDrivers = $availability['drivers'];
        
        return view('pages.reservation.view2', compact('id', 'msg', 'r', 'vehicle_type'));
    }

    public function destroy(Request $request, $id)
    {
        $r = Reservation::with('approvals')->findOrFail($id);
        if(!$r) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('reservation.index'));
        } else {
            // Retrieve and delete the associated approvals
            $approvals = Approval::where('r_id', $r->r_id)->get();
            foreach ($approvals as $approval) {
                $approval->delete();
            }
    
            // Delete the reservation
            $r->delete();

            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('reservation.index'));
        }        
    }

    public function cancel(Request $request, $id)
    {
        $r = Reservation::with('approvals')->findOrFail($id);
        if(!$r) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('reservation.index'));
        } else {
            // Retrieve and delete the associated approvals
            $approvals = Approval::where('r_id', $r->r_id)->get();
            foreach ($approvals as $approval) {
                $approval->update(['status_id' => 4]);
            }
    
            // Delete the reservation
            $r->update(['status_id' => 3]);

            $this->notifyUserGroupCancel($r);

            $request->session()->put('session_msg', 'Reservation Cancelled!');
            return redirect(route('reservation.index'));
        }        
    }


    private function notifyUserGroupCancel($r) {
        // Retrieve all user IDs belonging to the user group
        $userIds = User::join('user_groups', 'users.u_id', '=', 'user_groups.u_id')
        ->where('user_groups.g_id', $r->g_id)
        ->pluck('users.u_id');

        $userIdsFiltered = User::leftJoin('user_roles', 'users.u_id', '=', 'user_roles.u_id')
        ->where('users.deleted_at', null) // Ensure users are not soft deleted
        ->where('user_roles.role_id', '<>', 1) // Exclude users with role_id = 1 (RANK AND FILE)
        ->whereIn('users.u_id', $userIds)
        ->pluck('users.u_id');
        
        // Send notifications to the filtered users
        foreach ($userIdsFiltered as $userId) {
        Notification::create([
            'not_message' => 'Reservation has been cancelled by:' . $r->user->full_name,
            'r_id' => $r->r_id, // Assuming this is not relevant for this notification
            'u_id' => $userId,
            'new_user_id' => null,
            'app_id' => null,
            'read_at' => null,
        ]);
        }
    }
}
