<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {

    $this->middleware('auth');
    $this->enableEmailVerify();

  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {

    $total_users        = User::all()->count();
    $bannedUser         = User::get()->where('activated', 0)->count();
    $newUserCount       = User::whereMonth('created_at', date('m'))->count();
    $unconfirmmedUser   = User::get()->where('email_verified_at', null)->count();
    $newRegisteredUsers = User::get()->sortByDesc('created_at')->take(6);

    $data  = DB::table('users')->select(DB::raw('count(id) as `data`,
                                    DATE_FORMAT(created_at, "%Y %m") monthyear'))
                               ->groupBy('monthyear')
                               ->orderBy('monthyear', 'asc')
                               ->get()
                               ->pluck('data');

    $date  = DB::table('users')->select(DB::raw('count(id) as `data`,
                                    DATE_FORMAT(created_at, "%Y %m") monthyear'))
                               ->groupBy('monthyear')
                               ->orderBy('monthyear', 'asc')
                               ->get()
                               ->pluck('monthyear');

    return view('home', compact('total_users',
                        'newRegisteredUsers',
                        'newUserCount',
                        'bannedUser',
                        'unconfirmmedUser',
                        'data',
                        'date'
                    ));

  }

  public function enableEmailVerify() {

    $reg_email_confirmation = config("site_settings.reg_email_confirmation");

    if ($reg_email_confirmation == 1){
        $this->middleware('verified');

        return true;

    }

    return false;

  }

}
