<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function __construct()
    {
		$data = [ 'page' => 'Driver' ];
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

        $rows = Driver::whereHas('role', function ($query) {
            $query->whereHas('roles', function ($query) {
                $query->where('name', 'DRIVER');
            });
        })->paginate(20);
            
        return view('pages.driver.index', compact('rows', 'msg'));
    }
    
    public function create(Request $request)
    {   
        $msg        = $request->session()->pull('session_msg', '');

        $id      =      0;
        $d      =      new Driver;
        return view('pages.driver.form', compact('d', 'id', 'msg'));
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
            $d     = Driver::create($request->all());

            $request->session()->put('session_msg', 'Record successfully added.');
        } else {
            $d     = Driver::where('d_id', $id)->first();
            if(!$d ) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('driver.index'));
            }
            
            $request->request->add([
                'updated_at' => Carbon::now(), 
                'updated_by' => Auth::id()
            ]);
            $d->update($request->all());

            $request->session()->put('session_msg', 'Record updated.');
        }

        return redirect(route('driver.index'));
    }

    
    public function edit(Request $request, $id)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $d          = Driver::where('d_id', $id)->first();
        if(!$d) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('driver.index'));
        }
        return view('pages.driver.form', compact('d', 'id', 'msg'));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Request $request, $id)
    {
        $d = Driver::where('d_id', $id)->first();
        if(!$d) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('driver.index'));
        } else {
            $d->deleted_at = Carbon::now();
            $d->update();

            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('driver.index'));
        }        
    }
}
