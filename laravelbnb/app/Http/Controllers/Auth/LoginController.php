<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Si la petición es de tipo xml http, entonces retorna una respuesta sin contenido, pero con el código 204, para indicar que fue exitosa
        if ($request->isXmlHttpRequest()) {
            return response(null, 204);
        }
    }

    protected function loggedOut(Request $request)
    {
        // Si la petición es de tipo xml http, entonces retorna una respuesta sin contenido, pero con el código 204, para indicar que fue exitosa
        if ($request->isXmlHttpRequest()) {
            return response(null, 204);
        }
    }
}