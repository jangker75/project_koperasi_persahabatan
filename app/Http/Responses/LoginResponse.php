<?php
 
namespace App\Http\Responses;

use App\Helper\LogActivity;
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
                    : redirect()->intended(Fortify::redirects('login'));
    }
}