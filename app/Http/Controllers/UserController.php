<?php

namespace App\Http\Controllers;

use View;
use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Users' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {  
            if(!Auth::user()) {
                abort(404);
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();
            
            return $next($request);
        });
	}
    
    public function index(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');

        $rows       = User::paginate(20);
       
        return view('pages.users.index', compact('rows', 'msg'));
    }

    public function create(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $groups     = Group::get();
        $roles      = Role::get();
        $ugroups    = User::get();

        $id      =      0;
        $user    =      new User;
        return view('pages.users.form', compact('id', 'user', 'msg', 'ugroups', 'roles', 'groups'));
    }

    public function store(Request $request, $id)
    {
        // $input      = $request->validated();
        if($id == 0) {
            
            $request->request->add(['created_at' => Carbon::now()]);
            $user   = User::create($request->all());
            $user->groups()->sync([$request->input('g_id')]);          
            $user->roles()->sync([$request->input('role_id')]);    

        } else {
            $user   = User::where('u_id', $id)->first();
            if(!$user) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('user.index'));
            } else {
                $request->request->add(['updated_at' => Carbon::now()]);
                
                if ($request->filled('password')) {
                    $user->password = $request->input('password');
                }
                
                $checkboxFields = ['u_enabled'];

                foreach ($checkboxFields as $field) {
                    $value = $request->has($field) ? 1 : 0;
                    $user->$field = $value;
                }
                $request->request->remove('password');  
                $user->groups()->sync([$request->input('g_id')]);          
                $user->roles()->sync([$request->input('role_id')]);          
                $user->update($request->all());
            }
        }

        $request->session()->put('session_msg', 'Record updated.');
        return redirect(route('user.index'));
    }

    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $groups     = Group::get();
        $roles      = Role::get();
        $user       = User::where('u_id', $id)->first();
        

        // dd($ugroup_id);
        if(!$user) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('user.lists'));
        }
        return view('pages.users.form', compact('msg', 'id', 'user', 'groups', 'roles'));
    }

    public function delete(Request $request, $id)
    {
        $user = User::where('u_id', $id)->first();
        if(!$user) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('user.index'));
        } else {
            $user->delete();
            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('user.index'));
        }        
    }

    public function disable(Request $request, $id)
    {
        $user = User::where('u_id', $id)->first();
        if(!$user) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('user.lists'));
        } else {
            $user->update(['u_enabled' => '0']);
            $request->session()->put('session_msg', 'Account Disabled!');
            return redirect(route('user.lists'));
        }      
    }

    public function enable(Request $request, $id)
    {
        $user = User::where('u_id', $id)->first();
        if(!$user) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('user.lists'));
        } else {
            $user->update(['u_enabled' => '1']);
            $request->session()->put('session_msg', 'Account Enabled!');
            return redirect(route('user.lists'));
        }      
    }
}
