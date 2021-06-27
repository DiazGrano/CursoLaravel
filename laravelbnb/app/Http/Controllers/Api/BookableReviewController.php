<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $bookable = Bookable::findOrFail($id);

    // Aquí se está haciendo uso de las API resources.
    // Las API resources se encuentran entre los modelos y la respuesta (en json) que se le manda al usuario.
    // Puede servir para solo mostrar los campos que se necesiten e ignorar otros campos vitales de no ser necesario (como mostrar el nombre
    // del usuario al realizar una consulta de este, pero ocultar su contraseña)
    // Para crear un recurso, se usa el comando php artisan make:resource NombreRecurso
    // Los API resources se crean en la carpeta App\Http\Resources\

        return BookableReviewIndexResource::collection($bookable->reviews()->latest()->get());
        
    }
}
