<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $table = 'comments';
    
    //Relacion Many to One
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function image(){
        return $this->belongsTo('App\Models\Imagen', 'image_id');
    }
}
