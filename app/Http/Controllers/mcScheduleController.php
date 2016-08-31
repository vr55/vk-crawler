<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\mcUpdateController as mcUpdateController;

use \App\Models\mcComunities as mcComunities;
use \App\Models\mcKeywords as mcKeywords;
use \App\Models\mcSettings as mcSettings;
use \App\Models\mcUsers as mcUser;

use Mail;

class mcScheduleController extends mcBaseController
{

  /**
   *
   *
   * @param $users_settings array \App\Models\mcSettings
   *
   *
   */
  private function do_user_job( $users_settings )
  {
    $update = new mcUpdateController();

    foreach( $users_settings as $settings )
    {
      $user = $settings->user;
      $data = $update->get_comunities_data( $user );
      $posts = $update->process_comunities_data( $data, $user );
      $update->sendMail( $posts, $user );
    }

  }
  
  /**
   *
   *
   *
   *
   *
   */
   public function do_5min_schedule_job()
   {
     //TODO:: Better use join here
     /** Get users, who set scan frequency to 5 minutes in setting */
    $user_ids = mcSettings::where( 'scan_freq', '1' )->get();
    $this->do_user_job( $user_ids );
   }

   public function do_15min_schedule_job()
   {
     $user_ids = mcSettings::where( 'scan_freq', '2' )->get();
     $this->do_user_job( $user_ids );

   }
   
   public function do_hour_schedule_job()
   {
     $user_ids = mcSettings::where( 'scan_freq', '3' )->get();
     $this->do_user_job( $user_ids );

   }
   
   public function do_daily_schedule_job()
   {
     $user_ids = mcSettings::where( 'scan_freq', '4' )->get();
     $this->do_user_job( $user_ids );

   }

}
