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
        $cars->makeHidden(['imgs','des']);

        $result = $cars->map(function ($car) {
            $car->specs = json_decode($car->specs);
            return $car;
        });

        return response()->json($result);
    }

    public function show(Car $car) {
        return response()->json(new CarResource($car));
    }
}