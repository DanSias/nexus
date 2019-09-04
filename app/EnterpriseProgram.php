<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnterpriseProgram extends Model
{
    protected $table = 'enterprise_programs';
    protected $guarded = [];
    public $timestamps = false;

    public function program()
    {
        return $this->belongsTo('App\Program');
    }
}
