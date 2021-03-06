<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Role;
use App\RoleUser;
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
        $user=RoleUser::where('role_id','=',1)->count();
        $formateur=RoleUser::where('role_id','=',2)->count();
        $admin_franchise=RoleUser::where('role_id','=',3)->count();
        $super_admin= RoleUser::where('role_id','=',4)->count();
        $collaborateur_externe= RoleUser::where('role_id','=',5)->count();
        $collaborateur_interne= RoleUser::where('role_id','=',6)->count();
        $partenaire_commercial= RoleUser::where('role_id','=',7)->count();
        $totalUtilisateurs=User::count();
        return view('super_admin',compact('data','roles','super_admin','user','formateur','admin_franchise','collaborateur_externe','collaborateur_interne','partenaire_commercial','totalUtilisateurs'))

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

        // use pour passer l'argu $role à la closure
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
    
    public function vatChecker(Request $request){
        $vat = $request->vat;
        
        $vatCountry = substr($vat, 0, 2); // get country code - first two letters of VAT ID
        $vatNumber = substr($vat, 2);
        $apiURL = "http://ec.europa.eu/taxation_customs/vies/viesquer.do?ms=".$vatCountry."&vat=".$vatNumber;
        $resp = file_get_contents($apiURL);
        if(strpos($resp, '="validStyle"') !== false) return '1';
        else return '0';
    }
    
    public function tousLesUsers(){
        $results =  User::orderBy('id','DESC')->paginate(5);
        $response = [
            'pagination' => [
                'total' => $results->total(),
                'per_page' => $results->perPage(),
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem()
            ],
            'data' => $results
        ];

        return $response;
    }
//  Recherche VUEJS sur touts les USER
    public function rechercheUser(Request $request){
        $results =  User::where("name","LIKE","%{$request->nom}%")->orderBy('id','DESC')->paginate(5);
        $response = [
            'pagination' => [
                'total' => $results->total(),
                'per_page' => $results->perPage(),
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem()
            ],
            'data' => $results
        ];

        return $response;
    }
}
