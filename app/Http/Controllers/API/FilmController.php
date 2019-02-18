<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\FilmCollection;
use App\Http\Resources\FilmResource;

//Request validation class
use App\Http\Requests\FilmStoreRequest; 

use App\Film;

class FilmController extends Controller
{
    public function __construct(){

        $this->middleware('auth:api', ['only' => ['store', 'update', 'desctroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        FilmResource::withoutWrapping();
        //return new FilmCollection(Film::with('comments')->orderBy('created_at', 'desc')->withCount('comments')->paginate(10));  
        
        return FilmResource::collection(Film::orderBy('created_at', 'desc')->withCount('comments')->paginate(12));
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilmStoreRequest $filmRequest)
    {  
        //return $filmRequest;
        
        if(Film::where('name', $filmRequest['name'])->first()){
            return response()->json(['errors'=>'Film with same name exist'], 409);
        } 
        
        //FilmResource::withoutWrapping();  
        $image = $filmRequest['film_photo']; 
        $img_name = time().'.' . explode('/', explode(':', substr( $image, 0, strpos( $image, ';')))[1])[1];
        \Image::make($image)->save(public_path('images/').$img_name);  

        if(Film::create([
            'name' => $filmRequest['name'],
            'description' => $filmRequest['description'],
            'slug' => $filmRequest['slug'],
            'release_date' => $filmRequest['release_date'],
            'rating' => $filmRequest['rating'],
            'ticket_price' => $filmRequest['ticket_price'],
            'country' => $filmRequest['country'],
            'genre' => $filmRequest['genre'],
            'film_photo' => $img_name
        ])){ 

            return new FilmResource($filmRequest);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {   
        return new FilmResource(Film::where('slug', $slug)->with('comments.user:id,name')->first());
        //return new FilmResource(Film::where('slug', $slug)->first());
        //return new FilmResource($film);
    } 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(FilmStoreRequest $filmRequest, Film $film)
    {   

        $image = $filmRequest['film_photo']; 
        $img_name = time().'.' . explode('/', explode(':', substr( $image, 0, strpos( $image, ';')))[1])[1];
        \Image::make($image)->resize(null, 450)->save(public_path('images/').$img_name);  

        $film->name = $filmRequest['name'];
        $film->description = $filmRequest['description'];
        $film->slug = $filmRequest['slug'];
        $film->release_date = $filmRequest['release_date'];
        $film->rating = $filmRequest['rating'];
        $film->ticket_price = $filmRequest['ticket_price'];
        $film->country = $filmRequest['country'];
        $film->genre = $filmRequest['genre']; 
        $film->film_photo = $img_name; 
         
        if($film->save()){  
            return new FilmResource($film);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy(Film $film)
    {  
        if($film->delete()){
            return new FilmResource($film);
        }
    }
}
