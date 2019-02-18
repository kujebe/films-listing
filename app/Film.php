<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ]; 

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
