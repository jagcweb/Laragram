<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    
    protected $table = 'images';
    
    //Relacion One to Many // Una imagen tiene muchos comentarios y likes
    
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
    
    public function likes(){
        return $this->hasMany('App\Models\Like');
    }
    
    //Relacion Many to One // Un usuario puede tener muchas imagenes
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
