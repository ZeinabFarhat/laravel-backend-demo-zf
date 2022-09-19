<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm( Request $request, $token = null ) {
        $email = $request->email;

        return view( 'login.reset', compact( 'token', 'email' ) );
    }


    /**
     * Reset the given user's password.
     *
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function reset( Request $request ) {
        $request->validate( $this->rules(), $this->validationErrorMessages() );

        $user           = User::where( 'email', '=', $request->get( 'email' ) )->first();
        $user->password = $request->get( 'password' );

        $user->setRememberToken( Str::random( 60 ) );

        $user->save();

        event( new PasswordReset( $user ) );

        $this->guard()->login( $user );

        return redirect( '/' );
    }
}
