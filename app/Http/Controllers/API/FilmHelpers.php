<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilmHelpers extends Controller
{
    
    
    public function slugify(){ 
        return str_slug(request('name'));
    }
}
