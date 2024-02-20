<?php

namespace App\Http\Controllers;

use View;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\UserGroup;
use App\Models\Reservation;
use App\Models\VehicleType;
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
        $msg                = $request->session()->pull('session_msg', '');

        $id                 =      0;
        $r                  =      new Reservation;
        $types 	 	    =      VehicleType::get();
		$users 	 	        =      User::where('u_enabled', '=', 1)->orderBy('last_name', 'asc')->get();


        return view('pages.reservation.form', compact('r', 'types', 'users', 'id', 'msg'));
    }

    public function store(Request $request, $id)
	{
		$vehicle 		= Vehicle::find($request->get('v_id'));
		$passengers 	= $request->get('passengers');

		$request->request->add(['u_id' 	=> Auth::id(), 'requested_by' => Auth::id() ]);
		
		if($id == 0) {

            $user = Auth::id();
            
            // Get the user's group ID
            $group = UserGroup::where('u_id', $user)->first();
            
           
            $groupId = $group->g_id;

            // Find the manager of the user's group
            $groupManager = UserRoles::where('role_id', 2) // Assuming manager role ID is 1
                                ->whereHas('UserGroup', function ($query) use ($groupId) {
                                    $query->where('id', $groupId);
                                })
                                ->firstOrFail()
                                ->user;

            // Create an approval for the group manager
            $reservation->approvals()->create([
                'user_id' => $groupManager->id,
                'status' => 'pending'
            ]);

            $r    = Reservation::create($request->all());
            $request->session()->put('session_msg', 'Record successfully added.');
		}
		else {
			$alert          = 'alert-info';
            $message        = 'Reservation successfully updated.';
            $reservation    = Reservation::find($id);
            $notif_tags 	= array_diff($passengers, $reservation->passengers->pluck('id')->toArray());
            $reservation->update($request->all());
            $reservation->passengers()->sync($request->get('passengers'));
 		}

 		// $this->submitComment($id == 0 ? $reservation->id : $id, 1);
 		// $this->newNotification($notif_tags, $reservation->id, 'Vehicle Reservation', 'View Reservation', 'Tag');
		return redirect()->route('reservation.index');
	}
}
