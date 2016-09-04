<?php

namespace App\Http\Controllers;

use App\Post;
use App\Produit;
use App\Role;
use App\Tag;
use Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\ProduitsController;
use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    public function destructionsession(){
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts= Post::laSelectionPerso()->isLive()->get();
        $roles=Role::all();
        $tags=Tag::all();
        $produits=App::call('App\Http\Controllers\ProduitsController@index');
        return view('welcome')->withPosts($posts)->withRoles($roles)->withProduits($produits)->withTags($tags);
    }

    public function postsParTag(Tag $tag){
        return view('posts.par_tag')->with([
            'posts'=>$tag->posts()->isLive()->get()
        ]);

    }

    public function lePost(Request $request){
        $lePost=Post::laSelectionPerso()->where('slug' ,$request->slug)->isLive()->get();
        return view('posts.le_post')->withLepost($lePost);

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
