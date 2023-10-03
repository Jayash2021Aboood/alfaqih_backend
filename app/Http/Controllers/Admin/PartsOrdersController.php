<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartsOrder;
use Illuminate\Http\Request;

class PartsOrdersController extends Controller
{
    public function index() {
        $partsorders = PartsOrder::with('part', 'user')->get();
        return response()->json($partsorders);
    }

    public function show($id) {
        $partsorder = PartsOrder::with('part', 'user')->findOrFail($id);
        return response()->json($partsorder);
    }

    public function update(Request $request, $id) {
        $partsorder = PartsOrder::findOrFail($id);
        $partsorder->done = $request->done;
        //$partsorder->code = $request->code;
        $partsorder->save();
        return response()->json($partsorder);
    }

    public function destroy($id)
    {
        $part = PartsOrder::find($id);

        if (!$part) {
            return response()->json(['error' => 'PartsOrder not found'], 404);
        }

        $part->delete();
        
        return response()->json(['message' => 'PartsOrder deleted'], 204);
    }
}