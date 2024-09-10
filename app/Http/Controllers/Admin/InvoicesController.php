<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use misterspelik\LaravelPdf\Facades\Pdf as PDF;
// use PDF;


class InvoicesController extends Controller
{
    public function index() {
        // $invoices = Invoice::with('order', 'car', 'user')->get();
        $invoices = Invoice::get();
        return response()->json($invoices);
    }

    public function show($id) {
        // $invoice = Invoice::with('order', 'car', 'user')->findOrFail($id);
        $invoice = Invoice::findOrFail($id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        return response()->json($invoice);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0.01', // Ensure amount is greater than zero
        ]);

        // Check if an invoice already exists for the given order_id
        if (Invoice::where('order_id', $request->order_id)->exists()) {
            return response()->json(['error' => 'This order already has an invoice.'], 400);
        }
        
        // Fetch the order based on order_id
        $order = Order::findOrFail($request->order_id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Fetch the user based on user_id from the order
        $user = User::findOrFail($order->user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        // Fetch the car based on car_id from the order
        $car = Car::findOrFail($order->car_id);

        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        // Decode the specs JSON to extract values
        $specs = json_decode($car->specs, true);
        $car_company = $specs['company'] ?? 'Unknown';
        $car_year = $specs['year'] ?? 'Unknown';
        $car_color = $specs['color'] ?? 'Unknown';
        $car_base_number = $specs['number'] ?? 'Unknown';
    
        // Create the invoice with the necessary details
        $invoice = Invoice::create([
            'order_id'        => $order->id,
            'user_id'         => $user->id,
            'user_name'       => $user->name, // Use the name from the request
            'national_id'     => $user->national_id, // Assuming the User model has a 'national_id' field
            'amount'          => $request->amount, // Use the validated amount from the request
            'car_id'          => $car->id,
            'car_company'     => $car->name, // Assuming the Car model has a 'model' field
            'car_model'       => $car_year, // Assuming the Car model has a 'model' field
            'car_color'       => $car_color, //$car->color,   // Assuming the Car model has a 'color' field
            'car_base_number' => $car_base_number,// $car->base_number,  // Assuming the Car model has a 'base_number' field
            //'invoice_file'    => $pdfFilePath, // Store the path to the PDF
        ]);

        // Generate PDF with the created invoice object
        $pdf = PDF::loadView('invoice_pdf', ['invoice' => $invoice]);

        // Define filename
        $filename = 'invoice_' . $invoice->order_id . '.pdf';

        // Save the PDF to storage
        // $pdf->save(storage_path('app/public/invoices/' . $filename));
        $pdf->save(storage_path('app/public/invoice_files/' . $filename));

        // Update the invoice with the filename
        $invoice->update(['invoice_file' => $filename]);

        // $invoice->invoice_file = "HolaHope";
        // $invoice->save();

        return response()->json($invoice, 201);

    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }
        // Check if the invoice_file exists
        // if ($invoice->invoice_file) {
            $filePath = 'public/invoice_files/' . $invoice->invoice_file;
            // Delete the file from storage
            Storage::delete($filePath);
        // }
        $invoice->delete();
        
        return response()->json(['message' => 'Invoice deleted'], 204);
    }

}