<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'login' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required_with:password|same:password',
                'email' => 'unique:users',
                'email' => 'required',
                'email' => 'email:rfc',
                'last_name' => 'required',
                'first_name' => 'required',
                'role_id' => 'required',
                'role_id' => 'in:1,2'
            ]);

            if($validator->fails())
            {
                abort(INVALID_DATA, 'Invalid data');
            }

            $user = User::create([
                'login' => $request->login,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'role_id' => $request->role_id]);
                
            
            if(
                !Auth::attempt([
                    'login' => $request->login,
                    'password' => $request->password,
                    'email' => $request->email,
                    'last_name' => $request->last_name,
                    'first_name' => $request->first_name,
                    'role_id' => $request->role_id
                ]))
                {
                    abort(500, 'error');
                }
            

            $token = $user->createToken('userToken');
            return response()->json(['userToken' => $token->plainTextToken])->setStatusCode(CREATED);
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }   
    }

    public function login(Request $request)
    {       
        try
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required',                
                'password' => 'required'
            ]);

            if($validator->fails())
            {
                abort(INVALID_DATA, 'Invalid data');
            }
            
            if(Auth::attempt([
                    'email' => $request->email,
                    'password' => $request->password
                ]))
                {
                    $user = Auth::User();
                    $token = $user->createToken('userToken');
                    return response()->json(['userToken' => $token->plainTextToken])->setStatusCode(OK);
                }
                else
                {
                    abort(UNAUTHORIZED, 'Unauthorized');
                }
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }   
    }

    public function logout()
    {     
        try
        {
            if(Auth::Check())
            {
                $user = Auth::User();
                foreach($user->tokens as $token)
                {
                    $token->delete();
                }
                return response(null, NO_CONTENT);
            }
        }  
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
        
    }
}
