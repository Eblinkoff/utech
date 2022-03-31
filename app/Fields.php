<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    protected $fillable = [
        'date', 'value',
    ];
	
	public $timestamps = false;
	
}
