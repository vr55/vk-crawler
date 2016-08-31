<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mcSettings extends Model
{
    protected $table = 'mcSettings';
    protected $fillable = ['client_id', 'secret_key', 'access_token', 'admin_email', 'scan_depth', 'send_proposal', 'xmpp', 'xmpp2', 'xmpp3', 'scan_freq', 'send_email', 'send_xmpp' ];

    public function user()
    {
      return $this->hasOne( 'App\Models\mcUsers', 'id', 'owner_id' );
    }
}
