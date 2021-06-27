<?php

use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




/*
Route::get('bookables', function (Request $request) {
    return Bookable::all();
});

Route::get('bookables/{id}', function(Request $request, $bookableId){

    return Bookable::findOrFail($bookableId);

});*/
/*
Route::get('bookables', 'Api\BookableController@index');

Route::get('bookables/{id}', 'Api\BookableController@show');*/

// apiResource sirve para crear por defecto las rutas de un CRUD.
// al concatenarlo con ->only(), se le dice que solo muestre las rutas para esas acciones
// ->except() sirve para ignorar las rutas de las acciones definidas
Route::apiResource('bookables', 'Api\BookableController')->only(['index', 'show']);

// Aquí se hace uso de un controlador de una sola acción (single action controller), el cual, al agregarle la función __Invoke(),
// se convierte a sí mismo en una función, permitiendo así simplemente llamarlo, para que se ejecute su única función.
// Dado que este single action controller tiene definida la función __invoke(), no es necesario definir la función a la que se llamará al hacer referencia a este,
// porque el controlador en sí es la función.
Route::get('bookables/{bookable}/availability', 'Api\BookableAvailabilityController')->name('bookables.availability.show');


Route::get('bookables/{bookable}/reviews', 'Api\BookableReviewController')->name('bookables.reviews.index');

Route::get('bookables/{bookable}/price', 'Api\BookablePriceController')->name('bookables.price,show');





Route::apiResource('reviews', 'Api\ReviewController')->only(['show', 'store']);

Route::get('/booking-by-review/{reviewKey}', 'Api\BookingByReviewController')->name('booking.by.review.show');



Route::post('checkout', 'Api\CheckoutController')->name('checkout');

