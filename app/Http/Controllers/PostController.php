<?php

namespace App\Http\Controllers;

use App\Post;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\ProduitsController;
use App\Http\Requests;
use Illuminate\Support\Facades\App;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locale= app()->getLocale();
        $posts= Post::select('titre_'.$locale.' as titre',
                            'contenu_'.$locale.' as contenu',
                            'user_id','uuid','created_at as datecreation','image as image')->get();
        $roles=Role::all();
        $produits=App::call('App\Http\Controllers\ProduitsController@index');
        return view('welcome')->withPosts($posts)->withRoles($roles)->withProduits($produits);
    }

    public function lePost(Request $request){
        dd($request->uuid);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
