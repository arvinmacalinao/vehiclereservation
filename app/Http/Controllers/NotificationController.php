<?php

namespace App\Http\Controllers;

use View;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Notifications' ];
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

        $rows           = Notification::where('u_id', Auth::id('u_id'))->orderby('created_at', 'desc')->paginate(10);

        return view('pages.notifications.index', compact('rows', 'msg'));
    }

    public function markSingleAsRead(Notification $notification)
    {
        // Check if the notification is unread before marking it as read
        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        return redirect()->back()->with('success', 'Notification marked as read');
    }
}
