<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramRequirement extends Model
{
    protected $table = 'program_requirements';
    protected $guarded = [];
    public $timestamps = false;

    public function program()
    {
        return $this->belongsTo('App\Program');
    }
}
