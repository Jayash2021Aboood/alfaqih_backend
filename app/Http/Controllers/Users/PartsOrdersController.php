<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\PartsOrder;
use Illuminate\Http\Request;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class PartsOrdersController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'part_id' => 'required',
        ]);

        // $previousPartsOrder = PartsOrder::where('user_id', $request->user_id)
        //     ->where('part_id', $request->part_id)
        //     ->first();

        // if ($previousPartsOrder) {
        //     return response()->json([
        //         'message' => 'You already ordered this part'
        //     ], 400);
        // }

        $partsorder = new PartsOrder();
        $partsorder->user_id = $request->user_id;
        $partsorder->part_id = $request->part_id;
        $partsorder->code = $request->code;
        $partsorder->count = $request->count;
        $partsorder->done = false;
        $partsorder->save();
        // Mail::raw(' admin.alfaqihcars.com/partsorders هناك طلب جديد على الموقع. تحقق الآن', function (Message $message) {
        //     $message->to('admin@alfaqihcars.com')->subject('طلب جديد');
        // });

        return response()->json($partsorder);
    }
}