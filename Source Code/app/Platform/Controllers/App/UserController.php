<?php

namespace Platform\Controllers\App;

use App\User;
use App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends \App\Http\Controllers\Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling user features which are
    | not authorization-related.
    | It's designed for /api/ use with JSON responses.
    |
    */

    /**
     * Get user stats.
     *
     * @return \Symfony\Component\HttpFoundation\Response 
     */
    public function getStats(Request $request) {
      $stats = auth()->user()->getUserStats();
      return response()->json($stats, 200);
    }
}