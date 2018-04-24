<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Job extends Model
{   

    // Laravel Scout Driver
    //use Searchable;
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'position_tags' => 'array',
        'remote_tags' => 'array',
        'tech_tags' => 'array',
        'emails' => 'array'
    ];
}
