<?php

namespace App\Http\Controllers;

use View;
use App\Models\User;
use App\Models\Approval;
use App\Models\UserGroup;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Approvals' ];
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
        
        $user_id        = Auth::id();
        $g_id           = UserGroup::where('u_id', $user_id)->pluck('g_id');

        $rows           = Approval::where('g_id', $g_id)->paginate(20);

        return view('pages.approvals.index', compact('rows', 'msg'));
    }

    public function approve(Request $request, $id)
    {
        // Find the current approval
        $currentApproval = Approval::findOrFail($id);
        $user_id         = Auth::id();
        
        // Update the status of the current approval to 'approved'
        $currentApproval->status_id = 2;
        $currentApproval->u_id = $user_id;
        $currentApproval->save();

        // Get the reservation associated with the current approval
        $reservation = $currentApproval->reservation;

        // Find the user ID of the vehicle manager (you need to replace this with your logic)
        $RDUGroupID = 3; // Example group ID of the vehicle manager
        $userGroup = UserGroup::where('u_id', $user_id)->firstorfail();
       
        if ($userGroup->g_id != 3) {
            // Create a new approval for the vehicle manager
            $vehicleManagerApproval = new Approval();
            $vehicleManagerApproval->reservation()->associate($reservation);
            $vehicleManagerApproval->g_id = $RDUGroupID; // Set the ID of the vehicle manager
            $vehicleManagerApproval->status_id = 1; // Set the status as pending
            $vehicleManagerApproval->save();

           // Notify the users in the group
            $this->notifyGroup($RDUGroupID, $vehicleManagerApproval);

        }else{
            // Check if both vehicle_id and driver_id are not null
            if (request('v_id') && request('name')) {
                // Update the status
                $reservation->v_id = request('v_id');
                $reservation->driver_name = request('name');
                $reservation->status = 1;
                $reservation->save();
                // Other logic after approval...

                $this->notifyUser($reservation);
                
                $request->session()->put('session_msg', 'Approval updated successfully.');
                return redirect()->route('approval.index');
            } else {
                $request->session()->put('session_msg', 'Cannot approve reservation without assigning both vehicle and driver.');
                return redirect()->route('approval.index');
            }
        }
        $request->session()->put('session_msg', 'Approval updated successfully. New approval created for vehicle manager.');
        return redirect()->route('approval.index');

    }

    public function disapprove(Request $request, $id)
    {
        // Find the current approval
        $currentApproval = Approval::findOrFail($id);

        // Update the status of the current approval to 'denied'
        $currentApproval->status_id = 3;
        $currentApproval->save();

        $request->session()->put('session_msg', 'Approval updated successfully.');
        return redirect()->route('approval.index');
    }

    private function notifyGroup($groupId, $vehicleManagerApproval) {
        // Retrieve all user IDs belonging to the specified group
        // dd($vehicleManagerApproval->app_id);

        $userIds = User::whereExists(function ($query) use ($groupId) {
            $query->select('u_id')
              ->from('user_groups as ug')
              ->whereRaw('users.u_id = ug.u_id')
              ->where('ug.g_id', $groupId);
        })->pluck('u_id');

        // Create notifications for each user in the group
        foreach ($userIds as $userId) {
        Notification::create([
            'not_message' => 'New approval created by: ' . $vehicleManagerApproval->reservation->user->fullName,
            'r_id' => null, // Assuming this is not relevant for this notification
            'u_id' => $userId,
            'new_user_id' => null,
            'app_id' => $vehicleManagerApproval->app_id,
            'read_at' => null,
        ]);
        }
    }

    private function notifyUser($reservation) {
        $user = User::where('u_id', $reservation->u_id)->value('u_id');

        // Create notifications for single user
        Notification::create([
            'not_message' => 'Vehicle Reservation has been approved by RDU',
            'r_id' => $reservation->r_id,
            'u_id' => $user,
            'new_user_id' => null,
            'app_id' => null,
            'read_at' => null,
        ]);
        
    }
}
