<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\UserPassword;

class UserPasswordController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'clearance']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $user_id = Auth::id();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
        //dd($userpassword);
        if($userpassword){
            $data['user'] = $userpassword->user;
            $data['password'] = $userpassword->password;
        }
        
        return view('sian.user-sian', compact('user_id', 'data'));
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
        $user_id = Auth::id();
        $data = $request->all();
        $userpassword = UserPassword::where('user_id', $user_id)->first();
        if(!$userpassword){
            $userpassword = new UserPassword();
        }
        $userpassword->user = $data['user'];
        $userpassword->password = $data['password'];
        $userpassword->user_id = $user_id;
        $userpassword->save();
        return view('sian.user-sian', compact('user_id', 'data'));
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
