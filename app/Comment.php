<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ]; 

    public function user()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function film()
    {
        return $this->belongsTo('App\Film', 'film_id');
    }
}
