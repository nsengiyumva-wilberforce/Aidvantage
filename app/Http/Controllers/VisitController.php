<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Delivery;
use App\Models\DeliveryProduct;
use App\Models\Demo;
use App\Models\Maintenance;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use App\Models\Visit; // Import the Visit model

class VisitController extends Controller
{
    public function index()
    {
        // Get all the visits for the authenticated user
        $visits = Visit::where('user_id', auth()->user()->id)->get();

        // Return a collection of visits
        return response()->json(['data' => $visits], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:mappings,id',
            'visit_notes' => 'required|string',
            'visit_purpose' => 'required|string',
        ]);

        $visit = new Visit();
        $visit_purpose_flag = 0;

        $visit->business_id = $request->input('business_id');
        $visit->visit_notes = $request->input('visit_notes');
        $visit->visit_purpose = $request->input('visit_purpose');
        $visit->user_id = auth()->user()->id;
        $visit->save();

        if ($request->input('visit_purpose') == "Maintenance") {
            $request->validate([
                'product_id' => 'required|exists:mappings,id',
                'date_of_maintenance' => 'required|string',
                'comment' => 'required|string',
                'business_id' => 'required|exists:mappings,id',
            ]);

            $maintenance = new Maintenance();

            $maintenance->product_id = $request->input('product_id');
            $maintenance->date_of_maintenance = $request->input('date_of_maintenance');
            $maintenance->comment = $request->input('comment');
            $maintenance->user_id = auth()->user()->id;
            $maintenance->business_id = $request->input('business_id');
            $maintenance->visit_id = $visit->id;

            if ($maintenance->save()) {
                $visit_purpose_flag = 1;
            }
        } else if ($request->input('visit_purpose') == "Delivery") {
            $request->validate([
                'business_id' => 'required|exists:mappings,id',
            ]);

            $delivery = new Delivery();

            $delivery->user_id = auth()->user()->id;
            $delivery->business_id = $request->input('business_id');
            $delivery->visit_id = $visit->id;
            if ($delivery->save()) {
                //save the delivery product
                $delivery_products = $request->input('delivery_products');

                foreach ($delivery_products as $delivery_product) {
                    $product = new DeliveryProduct();

                    $product->delivery_id = $delivery->id;

                    $product->product_id = $delivery_product['product_id'];

                    $product->quantity = $delivery_product['quantity'];

                    $product->save();
                }

                $visit_purpose_flag = 1;
            }
        } else if ($request->input('visit_purpose') == "Appointment") {
            $request->validate([
                'meeting_date' => 'required|string',
                'meeting_start_time' => 'required|string',
                'meeting_end_time' => 'required|string',
                'meeting_notes' => 'required|string',
                'business_id' => 'required|exists:mappings,id'
            ]);

            $appointment = new Appointment();

            $appointment->meeting_date = $request->input('meeting_date');
            $appointment->meeting_start_time = $request->input('meeting_start_time');
            $appointment->meeting_end_time = $request->input('meeting_end_time');
            $appointment->meeting_notes = $request->input('meeting_notes');
            $appointment->user_id = auth()->user()->id;
            $appointment->business_id = $request->input('business_id');
            $appointment->visit_id = $visit->id;

            if ($appointment->save()) {
                $visit_purpose_flag = 1;
            }
        } else if ($request->input('visit_purpose') == "Sale") {
            $request->validate([
                'business_id' => 'required|exists:mappings,id'
            ]);

            $sale = new Sale();

            $sale->user_id = auth()->user()->id;
            $sale->business_id = $request->input('business_id');
            $sale->visit_id = $visit->id;

            if ($sale->save()) {
                $visit_purpose_flag = 1;

                //save the sale product
                $sale_products = $request->input('sale_products');

                foreach ($sale_products as $sale_product) {
                    $product = new SaleProduct();

                    $product->sale_id = $sale->id;

                    $product->product_id = $sale_product['product_id'];

                    $product->quantity = $sale_product['quantity'];

                    $product->save();
                }
            }
        } else if ($request->input('visit_purpose') == "Demo") {
            $request->validate([
                'demo_date' => 'required|string',
                'demo_notes' => 'required|string',
                'business_id' => 'required|exists:mappings,id'
            ]);

            $demo = new Demo();
            $demo->demo_date = $request->input('demo_date');
            $demo->demo_notes = $request->input('demo_notes');
            $demo->user_id = auth()->user()->id;
            $demo->business_id = $request->input('business_id');
            $demo->visit_id = $visit->id;

            if ($demo->save()) {
                $visit_purpose_flag = 1;
            }
        }
        if ($visit_purpose_flag == 1) {

            return response()->json(['message' => 'Visit created successfully'], 201);

        } else {

            return response()->json(['message' => 'Visit has not been added, try again'], 500);

        }

    }
}
