<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    // Table
    protected $table = 'partners';
    protected $guarded = [];
    public $timestamps = false;

    public function programs()
    {
        return $this->hasMany('App\Program');
    }
}
