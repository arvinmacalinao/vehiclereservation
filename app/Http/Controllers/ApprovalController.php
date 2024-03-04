<?php

namespace App\Http\Controllers;

use View;
use App\Models\Approval;
use App\Models\UserGroup;
use App\Models\Reservation;
use Illuminate\Http\Request;
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
        }else{
            $r_id = $currentApproval->r_id;
            $reservation = Reservation::where('r_id', $r_id)->firstOrFail(); // Fetch single reservation
            $reservation->status = 1;
            $reservation->save(); // Update the status
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

}
