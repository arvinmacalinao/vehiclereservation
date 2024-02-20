<?php

namespace App\Http\Controllers;

Use View;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Group' ];
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

        $rows           = Group::paginate(20);

        return view('pages.group.index', compact('rows', 'msg'));
    }
    
    public function create(Request $request)
    {   
        $msg        = $request->session()->pull('session_msg', '');

        $id         =      0;
        $group      =      new Group;
        return view('pages.group.form', compact('group', 'id', 'msg'));
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
            $group     = Group::create($request->all());

            $request->session()->put('session_msg', 'Record successfully added.');
        } else {
            $group     = Group::where('g_id', $id)->first();
            if(!$group ) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('group.index'));
            }

            $request->request->add([
                'updated_at' => Carbon::now(), 
            ]);

            $checkboxFields = ['recommending', 'approval'];

            foreach ($checkboxFields as $field) {
                $value = $request->has($field) ? 1 : 0;
                $group->$field = $value;
            }

            $group->update($request->all());

            $request->session()->put('session_msg', 'Record updated.');
        }

        return redirect(route('group.index'));
    }

    
    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $group          = Group::where('g_id', $id)->first();
        if(!$group) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('group.index'));
        }
        return view('pages.group.form', compact('group', 'id', 'msg'));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Request $request, $id)
    {
        $d = Group::where('g_id', $id)->first();
        if(!$d) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('group.index'));
        } else {
            $d->deleted_at = Carbon::now();
            $d->update();

            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('group.index'));
        }        
    }
}
