<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public function get() {
        $cars = Car::all();

        //remove unwanted column with its value from cars array object
        $cars->makeHidden(['imgs','des','commission','shipping_cost','created_at','updated_at']);

        $result = $cars->map(function ($car) {
            $car->specs = json_decode($car->specs);

            //remove unwanted column with its value from specs object
            unset($car->specs->check);
            unset($car->specs->color);
            unset($car->specs->insideColor);

            return $car;
        });

        return response()->json($result);
    }

    public function show(Car $car) {
        return response()->json(new CarResource($car));
    }
}