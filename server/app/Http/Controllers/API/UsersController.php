<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $users = User::all();
        $user = [...$users->where('email_address', $request->input('email_address'))];
        $db_password = $user[0]->password;
        $hashCheck = Hash::check($request->input('password'), $db_password);

        if ($hashCheck) {
            return response()->json(['status' => 200, 'access'=>$user[0]->status, 'userID' => $user[0]->id]);
        }
        else if(!$hashCheck) {
            return response()->json(['status' => 401, 'message' => 'Your password is incorrect.']);
        }
        else {
            return response()->json(['status' => 404, 'message' => 'No account found.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $hashed = Hash::make($request->input('password'));

        $user = new User();
        $user->first_name = $request->input('first_name', '');
        $user->last_name = $request->input('last_name', '');
        $user->email_address = $request->input('email_address');
        $user->mobile_number = $request->input('mobile_number');
        $user->address = $request->input('address');
        $user->status = $request->input('status');
        $user->password = $hashed;

        $user->save();

        return response()->json(['status' => 200, 'message' => 'Account successfully created.']);
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
