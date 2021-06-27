<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'content', 'rating'];
    
    public function bookable(){
        return $this->belongsTo(Bookable::class);
    }


    public function booking(){
        return $this->belongsTo(booking::class);
    }


    // Para indicarle a Laravel que la propiedad ID en la base de datos no hace uso de autoincrementar
    public function getIncrementing()
    {
        return false;
    }

    // Para indicarle a Laravel que la propiedad ID es string
    public function getKeyType()
    {
        return 'string';
    }
}
