<?php

use App\Http\Classes\OAuth as OAuth;
use Illuminate\Support\Facades\Route;

namespace App\Http\Controllers;

class mcOAuth extends \App\Http\Classes\Oauth
{
    public function __construct()
    {
        $this->vkontakte['client_id'] = 5609301;
        $this->vkontakte['redirect'] = route('oauth');
        $this->vkontakte['secret'] = 'J90a3fjG24iIa4vhNgco';


        $this->facebook['client_id'] = 333796500296648;
        $this->facebook['redirect'] = route('oauth');
        $this->facebook['secret'] = '76cdefdc9c010f5d99ff0808ebbfcc75';
    }

}
