<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class ManagementController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        $users = User::all();

        return view('admin.superadmin.management', compact('users'));
    }

    public function edit($id){

    	$user = User::where('id',$id)->first();

    	return view('admin.superadmin.edit', compact('user'));
    }

    public function update(Request $request, $id){

    	$this->validate($request, [
    		
    		'name' => 'required|string',
    		'organization' => 'required|string',
    		'email' => 'required|email|string',
    	]);

    	$user = User::find($id);

    	$user->name = $request->name;
    	$user->organization = $request->organization;
    	$user->email = $request->email;
        $user->role_id = $request->role;
    	$user->updated_at = date('Y-m-d H:i:s');
    	$user->save();

    	return redirect(route('management'));
    }

    public function destroy($id){

    	User::where('id',$id)->delete();

    	return redirect()->back();
    }
}
