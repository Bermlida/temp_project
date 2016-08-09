<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Keychain;

use App\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $user->api_key = Crypt::encrypt(str_random(60));
        $user->api_token = Hash::make($user->api_key);
        $user->save();   
        return $user;
    }

    public function authorization()
    {
        $user = Auth::user();
        $signer = new Sha256();
        $token = (new Builder())
                            ->setIssuer('laravel_framework') // Configures the issuer (iss claim)
                            ->setAudience($user->name) // Configures the audience (aud claim)
                            ->setSubject('access_token') //sub
                            ->setIssuedAt(\time()) // Configures the time that the token was issue (iat claim)
                            ->setExpiration(\time() + 3600) // Configures the expiration time of the token (nbf claim)
                            ->setNotBefore(\time() + 60) // Configures the time that the token can be used (nbf claim)
                            ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                            ->set('uid', 1) // Configures a new claim, called "uid"
                            ->sign($signer, $user->api_key) // creates a signature using "testing" as key
                            ->getToken(); // Retrieves the generated token

        return response()->json(['name' => $user->name, 'token' => $token], 200);
    }
}
