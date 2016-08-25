<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\mcUpdateController as mcUpdateController;

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

      $update = new mcUpdateController();


      $data = $update->get_comunities_data( $user );

      $posts = $update->process_comunities_data( $data, $user->id );
      //$update->sendMail( $posts );
      //print_r( $posts );
      //var_dump( $scan_freq );
    }
  }

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
      //$update->sendMail( $posts );
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
     $update = new mcUpdateController();

     //TODO:: Better use join here
     /** Get users, who set scan frequency to 5 minutes in setting */
     $user_ids = mcSettings::where( 'scan_freq', '1' )->get();

     $this->do_user_job( $user_ids );

   }

   public function do_15min_schedule_job()
   {
     $update = new mcUpdateController();

     //TODO:: Better use join here
     /** Get users, who set scan frequency to 15 minute in setting */
     $user_ids = mcSettings::where( 'scan_freq', '2' )->get();
     $this->do_user_job( $user_ids );
     /*
     foreach( $user_ids as $id )
     {

       $user = $id->user;
       $data = $update->get_comunities_data( $user );
       $posts = $update->process_comunities_data( $data, $user );
       $update->sendMail( $posts );
     }
     */
   }

}
