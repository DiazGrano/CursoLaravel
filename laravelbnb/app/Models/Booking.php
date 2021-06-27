<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to'];

    public function bookable(){
        return $this->belongsTo(Bookable::class);
    }

    public function review(){
        return $this->hasOne(Review::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }


    // Query scope
    // Para definir una query scope, es necesario poner 'scope' en minúsculas como prefijo
    // Las query scope sirven para agregar limitaciones a todas las consultas de un modelo dado.
    // En este caso, las limitaciones son que la propiedad 'to' del registro sea mayor a 'from', y 'from' sea menor que 'to',
    // para comprobar si el bookable tiene bookings ya registrados que interfieran con la fecha dada
    public function scopeBetweenDates(Builder $query, $from, $to){
        return $query->where('to', '>=', $from)
        ->where('from', '<=', $to);

        //return $query->where(['to', '>=', $from], ['to', '<=', $to])->orWhere(['from', '>=', $from], ['from', '<=', $to])->orWhere(['to', '>=', $from], 'from', '<=', $to);

    }


    // A partir de php 7.1, se puede definir el tipo de dato de retorno de una función, de la siguiente manera ": Tipo", si se le agrega un signo de interrogación,
    // se espera que retorne el tipo de dato o null ": ? Tipo".
    public static function findByReviewKey(string $reviewKey): ? Booking{
        // Se obtiene el modelo junto a su relación, haciendo uso de "with()"
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
    }



    // Inicializa el cómo el modelo eloquent debería comportarse. Este método es definido en la clase padre, el modelo.
    // Se necesario llamar al método padre
    protected static function boot(){
        parent::boot();

        // Registrar evento 
        // Para registrar un evento es necesario llamarlo estático, para de esta forma hacer referencia a esta clase de forma estática.
        // El método estático "creating", permite registrar un 'eventHandler'. En el event handler permitirá definir código que se ejecutará
        // cada que el método sea creado (gracias a que el método que definimos es creating).
        static::creating(function($booking){
            // Esto hace que se le asigne una review_key al booking recién creado, esta review_key es del tipo uuid (universally unique identifier (es un número
            // basado en 128-bits, usado para identificar información))
            $booking->review_key = Str::uuid();
        });
    }
}
