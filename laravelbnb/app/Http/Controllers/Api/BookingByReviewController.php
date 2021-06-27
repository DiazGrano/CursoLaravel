<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewShowResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($reviewKey, Request $request)
    {
        /*
        // Se retorna el modelo de la reviewKey, pero si es nulo, se aborta con el error 404
        $booking = Booking::findByReviewKey($reviewKey);
        return $booking ? new BookingByReviewShowResource($booking) : abort(404);
        */
        // Se retorna el modelo de la reviewKey, pero si es nulo, se aborta con el error 404
        return new BookingByReviewShowResource(Booking::findByReviewKey($reviewKey)) ?? abort(404);
    }
}
