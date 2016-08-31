<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mcUsers extends Model
{
    protected $table = 'users';

    public function settings()
    {
        return $this->hasOne( '\App\Models\mcSettings', 'owner_id', 'id' );
    }

    public function comunities()
    {
        return $this->hasMany( 'App\Models\mcComunities', 'owner_id', 'id' );
        # code...
    }

    public function keywords()
    {
        return $this->hasMany( 'App\Models\mcKeywords', 'owner_id', 'id' );
    }

    public function posts()
    {
        return $this->hasMany( 'App\Models\mcPosts', 'user_id', 'id' );
    }

    public function proposals()
    {
        return $this->hasMany( 'App\Models\mcProposals', 'owner_id', 'id' );
    }

    public function invites()
    {
        return $this->hasMany( 'App\Models\mcInvites', 'owner_id', 'id' );
    }
}
