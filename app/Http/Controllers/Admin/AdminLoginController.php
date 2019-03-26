<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminLoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login ()
    {
        $user = Auth::user();

        if ($user instanceof User) {
                 return redirect(route('receipts.index'));
         }

        return view('admin.login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginSubmit (Request $request)
    {
        $request->only('email', 'password');

        if(Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->filled('remember'))){
            Auth::user();

            return redirect(route('receipts.index'));
        }

        return redirect(route('adminLogin'))->with('loginerror', __('lagarto.wrong_login_data'));
    }

    public function logout()
    {
        if(Auth::check()) {
            Auth::logout();
        }

        return redirect(route('adminLogin'));
    }
}
