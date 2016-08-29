<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)    {
        $data = User::orderBy('id','DESC')->paginate(5);
        $roles=Role::all();
        return view('super_admin',compact('data','roles'))

            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function edit($id)

    {

        $user = User::find($id);

        $roles = Role::lists('name','id');

        $userRole = $user->roles->lists('id','id')->toArray();


        return view('users.edit',compact('user','roles','userRole'));

    }

    public function update(Request $request, $id)

    {

        $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email,'.$id,

            'password' => 'same:confirm-password',

            'roles' => 'required'

        ]);


        $input = $request->all();

        if(!empty($input['password'])){

            $input['password'] = Hash::make($input['password']);

        }else{

            $input = array_except($input,array('password'));

        }


        $user = User::find($id);

        $user->update($input);

        DB::table('role_user')->where('user_id',$id)->delete();




        foreach ($request->input('roles') as $key => $value) {

            $user->attachRole($value);

        }


        return redirect()->route('super_admin');

    }

    public function destroy($id)

    {

        User::find($id)->delete();

        return redirect()->route('super_admin');

    }

    public function recherche(Request$request, $role){
        $roles=Role::all();

        // use pour passer l'argu à la closure
        $data = User::whereHas('roles', function($q) use ($role)
        {
            $q->where('name', $role);
        })->paginate(5);


        return view('recherche_par_role',compact('data','roles'))

            ->with('i', ($request->input('page', 1) - 1) * 5);

    }
    public function rechercheParNom(Request $request){
        $roles=Role::all();
        $nom = $request->nom;
        $data = User::where('name', $nom)->paginate(5);
        return view('recherche_par_nom',compact('data','roles'))

            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function autocomplete(Request $request){
        $user = User::select("name as name")->where("name","LIKE","%{$request->input('nom')}%")->get();

        return response()->json($user);

    }
}
