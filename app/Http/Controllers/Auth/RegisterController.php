<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // $data['date_of_birth'] = str_replace("/", "-", $data['date_of_birth']);
        $date = $data['date_of_birth'];
        $date = explode("/", $date);
        $date = $date[2]."-".$date[1]."-".$date[0];
        $data['date_of_birth'] = $date;
        // $date = new DateTime($date);

        // $data['date_of_birth'] = dateformat($data['date_of_birth'], "d-m-Y");
        // $data
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'name_complete' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $date = $data['date_of_birth'];
        $date = explode("/", $date);
        $date = $date[2]."-".$date[1]."-".$date[0];
        $data['date_of_birth'] = $date;

        return User::create([
            'name' => $data['name'],
            'name_complete' => $data['name_complete'],
            'date_of_birth' => $data['date_of_birth'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
