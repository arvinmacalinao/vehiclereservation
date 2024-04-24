<?php

namespace App\Http\Controllers;

use View;
use App\Models\User;
use App\Models\Approval;
use App\Models\UserRole;
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
        $userrole       = UserRole::wherE('u_id', $user_id)->firstorFail();

       if($userrole->roles->name == 'SUPERADMIN')
        {
            $rows           = Approval::orderby('created_at', 'desc')->paginate(20);
        }
        else
        {
            $rows           = Approval::orderby('created_at', 'desc')->where('g_id', $g_id)->paginate(20);
        }

        return view('pages.approvals.index', compact('rows', 'msg'));
    }

    public function approve(Request $request, $id)
    {
        $currentApproval = Approval::findOrFail($id);
        $user_id         = Auth::id();
        
        $currentApproval->status_id = 2;
        $currentApproval->u_id = $user_id;
        $currentApproval->save();

        $reservation = $currentApproval->reservation;

        $RDUGroupID = 3; 
        $userGroup = UserGroup::where('u_id', $user_id)->firstorfail();
       
        if ($userGroup->g_id != 3) {
            $vehicleManagerApproval = new Approval();
            $vehicleManagerApproval->reservation()->associate($reservation);
            $vehicleManagerApproval->g_id = $RDUGroupID; 
            $vehicleManagerApproval->status_id = 1; 
            $vehicleManagerApproval->save();


            $this->notifyGroup($RDUGroupID, $vehicleManagerApproval);

        }else{
            
            if (request('v_id') && request('driver_id')) {
               
                $reservation->v_id = request('v_id');
                $reservation->driver_id = request('driver_id');
                $reservation->status_id = 1;
                $reservation->save();
    

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
        $currentApproval = Approval::findOrFail($id);

        $currentApproval->status_id = 3;
        $currentApproval->save();

        $r = Reservation::where('r_id', $currentApproval->r_id)->first();
        $r->status_id = 4;
        $r->save();

        $request->session()->put('session_msg', 'Approval updated successfully.');
        return redirect()->route('approval.index');
    }

    private function notifyGroup($groupId, $vehicleManagerApproval) {
        
        $userIds = User::whereExists(function ($query) use ($groupId) {
            $query->select('u_id')
              ->from('user_groups as ug')
              ->whereRaw('users.u_id = ug.u_id')
              ->where('ug.g_id', $groupId);
        })->pluck('u_id');

        foreach ($userIds as $userId) {
        Notification::create([
            'not_message' => 'New approval created by: ' . $vehicleManagerApproval->reservation->user->fullName,
            'r_id' => null, 
            'u_id' => $userId,
            'new_user_id' => null,
            'app_id' => $vehicleManagerApproval->app_id,
            'read_at' => null,
        ]);
        }
    }

    private function notifyUser($reservation) {
        $user = User::where('u_id', $reservation->u_id)->value('u_id');

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
