<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookableShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */


    // Las API resources se encuentran entre los modelos y la respuesta (en json) que se le manda al usuario.
    // Puede servir para solo mostrar los campos que se necesiten e ignorar otros campos vitales de no ser necesario (como mostrar el nombre
    // del usuario al realizar una consulta de este, pero ocultar su contraseña)
    // Para crear un recurso, se usa el comando php artisan make:resource NombreRecurso
    // Los API resources se crean en la carpeta App\Http\Resources\

     // Este recurso retorna solo la id, el título del item y su descripción.
     // Se puede acceder a las propiedades usando $this
     // Se le pueden agregar más propiedades de ser necesario, o modificarlas.
     
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
    ];
    }
}
