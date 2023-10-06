<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartResource;
use App\Models\Part;
use Illuminate\Http\Request;

class PartsController extends Controller
{
    public function get() {
        $parts = Part::all();
        $parts->makeHidden(['imgs','des']);

        return response()->json($parts);
    }

    public function show(Part $part) {
        return response()->json(new PartResource($part));
    }
}