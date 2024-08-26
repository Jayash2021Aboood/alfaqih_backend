<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarsController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return response()->json(CarResource::collection($cars));
    }

    public function show($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        return response()->json($car);
    }

    public function store(Request $request)
    {
        $request->validate([
            'img' => 'required|file',
        ]);


        $car = new Car();
        $car->name = $request->input('name');
        $car->price = $request->input('price');
        $car->status = $request->input('status');
        $car->type = $request->input('type');
        $car->shipping_cost = $request->input('shipping_cost');
        $car->commission = $request->input('commission');

        // Handling single image
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('car_images', 'public');
            $car->img = $imgPath;
        }

        // Handling multiple images
        if ($request->hasFile('imgs')) {
            $imgPaths = [];
            foreach ($request->file('imgs') as $img) {
                $imgPath = $img->store('car_images', 'public');
                $imgPaths[] = $imgPath;
            }
            $car->imgs = implode("|", $imgPaths);
        }

        $car->specs = $request->input('specs');
        $car->des = $request->input('des');
        $car->save();

        return response()->json(new CarResource($car), 201);
    }

    public function update(Request $request, $id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }
        
        // Update only if the field is present in the request
        if ($request->has('name')) {
            $car->name = $request->input('name');
        }

        if ($request->has('price')) {
            $car->price = $request->input('price');
        }

        if ($request->has('status')) {
            $car->status = $request->input('status');
        }

        if ($request->has('type')) {
            $car->type = $request->input('type');
        }

        if ($request->has('shipping_cost')) {
            $car->shipping_cost = $request->input('shipping_cost');
        }

        if ($request->has('commission')) {
            $car->commission = $request->input('commission');
        }

        // Handling single image update
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('car_images', 'public');
            $car->img = $imgPath;
        }

        // Handling multiple images update
        if ($request->hasFile('imgs')) {
            $imgPaths = [];
            foreach ($request->file('imgs') as $img) {
                $imgPath = $img->store('car_images', 'public');
                $imgPaths[] = $imgPath;
            }
            $car->imgs = implode("|", $imgPaths);
        }

        if ($request->has('specs')) {
            $car->specs = $request->input('specs');
        }

        if ($request->has('des')) {
            $car->des = $request->input('des');
        }

        $car->save();

        return response()->json(new CarResource($car));
    }

    public function destroy($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        $car->delete();

        return response()->json(['message' => 'Car deleted'], 204);
    }

    public function SayHi(){
        Log::info('I am Say Hi Method  ' . now());
        return "Hi Was Loged  " . now();
    }

    public function GetAllDatabaseFiles() : array{
        $allfiles = array();

        $cars = Car::all();
        $parts = Part::all();

        foreach ($cars as $car) {
            $registeredImages = explode('|', $car->imgs);
            $registeredImages[] = $car->img;

            $allfiles = array_merge($allfiles, $registeredImages);
        }

        foreach ($parts as $part) {
            $registeredImages = explode('|', $part->imgs);
            $registeredImages[] = $part->img;

            $allfiles = array_merge($allfiles, $registeredImages);
        }

        return $allfiles;
    }

    public function GetAllFilesFromStorage() : array{
        $allfiles = array();
        $cars = Storage::disk('public')->files('car_images');
        $parts = Storage::disk('public')->files('part_images');
        $allfiles = array_merge($cars, $parts);
        return $allfiles;
    }


    public function CleanUnusedCarImages(Request $request){

        $registeredImages = $this->GetAllDatabaseFiles();
        $files = $this->GetAllFilesFromStorage();
        echo 'All Registered Images '.count($registeredImages)  .' <br>';
        // var_dump($registeredImages);
        foreach ($registeredImages as $file ) {
            echo $file . "<br>";
        }


        echo '<br>All Images Files '.count($files)  .' <br>';

        // var_dump($files);
        foreach ($files as $file ) {
            echo $file . "<br>";
        }

        foreach ($files as $file) {
            //$filePath = $directory . '/' . $file;

            // Check if the file exists in the database
            if (!in_array($file, $registeredImages)) {
                // Remove the file
                Storage::disk('public')->delete($file);
            }
        }


        // var_dump($this->GetAllDatabaseFiles());
        return;


        $cars = Car::all();
        $parts = Part::all();

        foreach ($cars as $car) {
            $registeredImages = explode('|', $car->imgs);
            $registeredImages[] = $car->img;
            // Get the directory path where the images are stored
            $directory = 'car_images';
    
            // Get all files in the directory
            $files = Storage::disk('public')->files($directory);
    

            echo 'All Registered Images '.count($registeredImages)  .' <br>';
            // var_dump($registeredImages);
            foreach ($registeredImages as $file ) {
                echo $file . "<br>";
            }


            echo '<br>All Images Files '.count($files)  .' <br>';

            // var_dump($files);
            foreach ($files as $file ) {
                echo $file . "<br>";
            }
            return;


            foreach ($files as $file) {
                $filePath = $directory . '/' . $file;
    
                // Check if the file exists in the database
                if (!in_array($file, $registeredImages)) {
                    // Remove the file
                    Storage::disk('public')->delete($filePath);
                }
            }
        }
    

        // $cars = Car::all();

        // foreach ($cars as $car) {
        //     $registeredImages = explode('|', $car->imgs);
    
            
        //     // Get the directory path where the images are stored
        //     $directory = public_path('car_images');
    
        //     // Get all files in the directory
        //     $files = scandir($directory);
    

        //     echo 'All Registered Images';
        //     var_dump($registeredImages);

        //     echo 'All Images Files';

        //     var_dump($registeredImages);
        //     return;
        //     foreach ($files as $file) {
        //         $filePath = $directory . '/' . $file;
    
        //         // Check if the file exists in the database
        //         if (!in_array($file, $registeredImages) && is_file($filePath)) {
        //             // Remove the file
        //             unlink($filePath);
        //         }
        //     }
        // }
        
    }

}