<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  Request  $request
     * @return void
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            $this->username() => ['required', 'string'],
            'password' => ['required', 'string'],
            'receipts.*.hash' => ['required_with:receipts.*.time', 'string'],
            'receipts.*.time' => ['required_with:receipts.*.hash', 'date'],
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return void
     */
    protected function authenticated(Request $request, User $user): void
    {
        $receipts = $request->input('receipts');
        if (is_array($receipts)) {
            $user->assignReceipts($receipts);
        }
    }
}
