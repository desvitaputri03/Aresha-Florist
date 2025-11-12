<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseAdminController extends Controller
{
    public function __construct()
    {
        // Simple guard: redirect to home if not admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            redirect('/')->send();
            exit;
        }
    }
}
