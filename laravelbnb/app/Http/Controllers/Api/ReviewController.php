<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id){
        return new ReviewResource(Review::findOrFail($id));
    }

    public function store(Request $request){
        $data = $request->validate([
            // El tamaño de una UUID es de 36 caracteres y tiene que ser única en la tabla reviews
            'id' => 'required|size:36|unique:reviews',
            'content' => 'required|min:3',
            // Es requerido y es necesario que sea alguno de esos valores
            'rating' => 'required|in:1,2,3,4,5',
        ]);
        // Se revisa que exista la review_key, o sea, que el booking todavía no tenga una review
        $booking = Booking::findByReviewKey($data['id']);

        if($booking === null){
            return abort(404);
        }
        // Esta id es la id que identifica la posible review de un booking
        // Una vez que la review es hecha, ya no se podrá agregar una nueva, editar o eliminar
        // por lo que la key debe ser eliminada, para evitar que se encuentre
        $booking->review_key = '';
        $booking->save();

        // para poder agregar datos a la base de datos, es necesario definir el fillable en el modelo
        $review = Review::make($data);

        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();

        return new ReviewResource($review);
    }
}
