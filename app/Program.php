<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';
    protected $guarded = [];
    public $timestamps = false;

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }

    public function enterprise()
    {
        return $this->hasOne('App\EnterpriseProgram');
    }

    public function requirements()
    {
        return $this->hasOne('App\ProgramRequirement');
    }
}
