<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartResource;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PartsController extends Controller
{
    public function index()
    {
        $parts = Part::all();
        return response()->json(PartResource::collection($parts));
    }

    public function show($id)
    {
        $part = Part::find($id);

        if (!$part) {
            return response()->json(['error' => 'Part not found'], 404);
        }

        return response()->json($part);
    }

    public function store(Request $request)
    {
        $request->validate([
            'img' => 'required|file',
            'cars' => 'required|string',
        ]);


        $part = new Part();
        $part->name = $request->input('name');
        $part->price = $request->input('price');

        // Handling single image
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('part_images', 'public');
            $part->img = $imgPath;
        }

        // Handling multiple images
        if ($request->hasFile('imgs')) {
            $imgPaths = [];
            foreach ($request->file('imgs') as $img) {
                $imgPath = $img->store('part_images', 'public');
                $imgPaths[] = $imgPath;
            }
            $part->imgs = implode("|", $imgPaths);
        }

        $part->cars = $request->input('cars');
        $part->des = $request->input('des');
        $part->save();

        return response()->json(new PartResource($part), 201);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'cars' => 'required|string',
        ]);

        $part = Part::find($id);

        if (!$part) {
            return response()->json(['error' => 'Part not found'], 404);
        }
        
        // Update only if the field is present in the request
        if ($request->has('name')) {
            $part->name = $request->input('name');
        }

        if ($request->has('price')) {
            $part->price = $request->input('price');
        }

        // Handling single image update
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('part_images', 'public');
            $part->img = $imgPath;
        }

        // Handling multiple images update
        if ($request->hasFile('imgs')) {
            $imgPaths = [];
            foreach ($request->file('imgs') as $img) {
                $imgPath = $img->store('part_images', 'public');
                $imgPaths[] = $imgPath;
            }
            $part->imgs = implode("|", $imgPaths);
        }

        if ($request->has('cars')) {
            $part->cars = $request->input('cars');
        }

        if ($request->has('des')) {
            $part->des = $request->input('des');
        }

        $part->save();

        return response()->json(new PartResource($part));
    }

    public function destroy($id)
    {
        $part = Part::find($id);

        if (!$part) {
            return response()->json(['error' => 'Part not found'], 404);
        }

        $part->delete();

        return response()->json(['message' => 'Part deleted'], 204);
    }
}