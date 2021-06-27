<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     // Este controlador está siendo llamado desde api.php
     // Este es un controlador de una sola acción (single action controller), el cual, al agregarle la función __Invoke(),
    // se convierte a sí mismo en una función, permitiendo así simplemente llamarlo, para que se ejecute su única función.
    // Aquí se está haciendo uso de la validación de datos de Laravel. 

    // El nombre del parámetro que se define aquí no importa, solo el orden. Los parámetros que se reciben son asignados por orden, por lo que el nombre
    // que se les dé no importa. En este caso, se recibe de api.php la variable 'bookable', la cual se asigna a $id, por el orden que está definido
    public function __invoke($id, Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);
        $bookable = Bookable::findOrFail($id);
        return $bookable->availableFor($data['from'], $data['to']) 
        ? response()->json([]) 
        : response()->json([], 404);
    }
}
