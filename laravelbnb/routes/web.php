<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});



// Definir una fallback route
// Define como válida cualquier ruta que cumpla con la condición especificada, para que el frontend se sobreponga al routing de Laravel.
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');
// Se usa el "->where()", para acceder a la ruta solo si se cumple la condición
// En este caso, la condición (?!api\/) dice que la ruta no contenga "api/"
// Y la condición [\/\w\.\,-]*
// \/ dice que contenga  "/"
// \w dice que contenga  cualquier caracter
// \. dice que contenga puntos
// \, dice que contenga comas
// - dice que contenga guiones
// O sea, que contenga cualquier cosa que no sea "api/"
// * es el cuantificador, el cual indica que las condiciones se deben cumplir una o inlimitadas veces



