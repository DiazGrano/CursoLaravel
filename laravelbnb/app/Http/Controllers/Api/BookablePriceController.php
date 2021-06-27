<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        // Se encuentra el objeto del bookable con la id dada
        $bookable = Bookable::findOrFail($id);

        // Se agregan restricciones al formato que debe llegar
        // Los dos tienen que ser diferente de null, tienen que seguir el formato año-mes-día, y 'from' tiene que ser igual o mayor a la fecha de ahora
        // y 'to' tiene que ser igual o mayor a 'from'
        $data =  $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);
        // ########### se refactorizó el código. La parte para calcular el precio se movió al modelo Bookable.php
        // Se calculan la cantidad de días en total que duraría la estancia
        // Carbon se usa para manejar fechas, cuenta con bastantes funciones últiles para trabajar con estas.
        // se usa diffInDays para obtener la diferencia de días entre dos fechas, pero se le agregará +1, por si se elije un solo día, para que no salga 0
        //$days = ((new Carbon($data['from']))->diffInDays(new Carbon($data['to'])) + 1);
       // $price = $days * $bookable->price;
        
        // Se retorna una respuesta con formato json, el cual encapsulará los datos 
        /*return response()->json([
            'data' => [
                'total' => $price,
                'breakdown' => [
                    $bookable->price => $days
                ]
            ]
        ]);*/
        return response()->json([
            'data' => $bookable->priceFor($data['from'], $data['to'])
        ]);
    }
}
