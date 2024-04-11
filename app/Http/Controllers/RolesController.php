<?php

namespace App\Http\Controllers;

use View;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Roles' ];
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
        $msg        =      $request->session()->pull('session_msg', '');

        $rows       =      Role::paginate(20);

        return view('pages.role.index', compact('rows', 'msg'));
    }
    
    public function create(Request $request)
    {   
        $msg        =      $request->session()->pull('session_msg', '');

        $id         =      0;
        $role       =      new Role;
        return view('pages.role.form', compact('role', 'id', 'msg'));
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
            $role     = Role::create($request->all());

            $request->session()->put('session_msg', 'Record successfully added.');
        } else {
            $role     = Role::where('role_id', $id)->first();
            if(!$role ) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('role.index'));
            }
            
            $request->request->add([
                'updated_at' => Carbon::now(), 
                'updated_by' => Auth::id()
            ]);
            $role->update($request->all());

            $request->session()->put('session_msg', 'Record updated.');
        }

        return redirect(route('role.index'));
    }

    
    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $role          = Role::where('role_id', $id)->first();
        if(!$role) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('role.index'));
        }
        return view('pages.role.form', compact('role', 'id', 'msg'));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Request $request, $id)
    {
        $role = Role::where('role_id', $id)->first();
        if(!$role) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('role.index'));
        } else {
            $role->delete();

            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('role.index'));
        }        
    }
}
