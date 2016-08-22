<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//use App\Http\Controllers\Controller;

use \App\Models\mcComunities as mcComunities;
use \App\Models\mcKeywords as mcKeywords;
use \App\Models\mcSettings as mcSettings;
use \App\Models\mcUsers as mcUser;

class mcScheduleController extends mcBaseController
{
  /**
  *
  *
  *
  */
  public function do_schedule_job()
  {

    /** Get all users */
    $users = mcUser::all();

    foreach ( $users as $key => $user )
    {
      $settings = $user->settings;
      $comunities = $user->comunities;
      $keywords = $user->keywords;

      $scan_depth = $settings->scan_depth;
      $scan_freq = $settings->scan_freq;

      var_dump( $scan_freq );
    }
  }
}
