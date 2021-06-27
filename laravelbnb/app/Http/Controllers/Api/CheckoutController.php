<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date_format:Y-m-d|after_or_equal:today',
            'bookings.*.to' => 'required|date_format:Y-m-d|after_or_equal:from', 

            'customer.first_names' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.street' => 'required|min:1',
            'customer.city' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.country' => 'required|min:2',
            'customer.state' => 'required|min:2',
            'customer.zip' => 'required|min:1'
        ]);
        
        // array_merge combina dos arrays dentro de un array, uniendo así bookings y customer. Porque sin esto, la validación de bookings también afectaría a customer,
        // provocando que este último no se muestre, al ser desechado por laravel.
        
        // Closures
        // Son usadas cuando se necesita funcionalidad y validación de una regla personalizada.
        // Los closures reciben el nombre del atributo, los valores del atributo y un callback 'fail', el cual es llamado si la validación falla
        $data = array_merge($data, $request->validate([
            'bookings.*' => ['required', function($attribute, $value, $fail){
                $bookable = Bookable::findOrFail($value['bookable_id']);

                if(!$bookable->availableFor($value['from'], $value['to'])){
                    $fail("The object is not available in the given dates!");
                }
            }]
        ]));
        
        $bookingsData = $data['bookings'];
        $addressData = $data['customer'];

        $bookings = collect($bookingsData)->map(function($bookingData) use ($addressData){
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($booking->from, $booking->to)['total'];
            //$booking->bookable_id = $bookingData['bookable_id'];
            //Se asocia el booking con el bookable al que pertenece
            $booking->bookable()->associate($bookable);
            
            

            $booking->address()->associate(Address::create($addressData));

            $booking->save();

            return $booking;
        });

        return $bookings;
    }
}
