<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

use App\Http\Requests;

use App\Models\mcSettings as mcSettings;
use App\Models\mcUsers as mcUser;

class mcBaseController extends Controller
{
/** @var Sentinel $user */
    protected $user;

/** @var \App\Models\mcSettings $settings */
    protected $settings;

    public function __construct()
    {
        $this->user = Sentinel::getUser();
        if ( $this->user )
        {
            $this->settings = mcUser::find( $this->user->id )->settings;

            if ( !isset( $this->settings ) )
            {
                $this->settings = new mcSettings();
                $this->settings->owner_id = $this->user->id;
                $this->settings->save();
            }

        }
    }
}
