<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke()
    {

        if (!auth('web')->check()) {
            return redirect()->route('login');
        }

        if (auth('web')->user()->role == \App\Models\User::ADMIN_ROLE) {
            return redirect()->route('admin.index');
        }

        if (auth('web')->user()->role == \App\Models\Customer::CUSTOMER_ROLE) {
            return 'customer panel coming soon';
            //return redirect()->route('admin.index');
        }

        abort(401);
    }
}
