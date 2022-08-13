<?php
 
namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;
class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        // LogActivity::addToLog(__('log.user_login', ['user' => auth()->user()->name]));
        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect('admin');
                    // : redirect()->intended(Fortify::redirects('login'));
    }
}