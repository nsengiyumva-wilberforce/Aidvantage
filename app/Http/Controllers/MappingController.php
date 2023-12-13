<?php
namespace App\Http\Controllers;

use App\Models\ItemOfInterest;
use App\Models\ProductOfInterest;
use Illuminate\Http\Request;
use App\Models\Mapping; // Assuming Mapping is your model

class MappingController extends Controller
{
    public function index()
    {
        $mappings = Mapping::where('user_id', auth()->user()->id)->get();

        return response()->json([
            "message" => "Mappings retrieved successfully",
            'data' => $mappings
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string',
            'business_telephone_contact' => 'required|string',
            'business_email_contact' => 'required|email',
            'business_location' => 'required|string',
            'physical_address' => 'required|string',
            'contact_person_name' => 'required|string',
            'contact_person_telephone' => 'required|string',
            'contact_person_email' => 'required|email',
            'contact_person_gender' => 'required|string',
            'pitch_interest' => 'required|string',
            'notes' => 'required|string',
        ]);

        $mapping = new Mapping();
        $mapping->business_name = $request->input('business_name');
        $mapping->business_telephone_contact = $request->input('business_telephone_contact');
        $mapping->business_email_contact = $request->input('business_email_contact');
        $mapping->business_location = $request->input('business_location');
        $mapping->physical_address = $request->input('physical_address');
        $mapping->contact_person_name = $request->input('contact_person_name');
        $mapping->contact_person_telephone = $request->input('contact_person_telephone');
        $mapping->contact_person_email = $request->input('contact_person_email');
        $mapping->contact_person_gender = $request->input('contact_person_gender');
        $mapping->pitch_interest = $request->input('pitch_interest');
        $mapping->notes = $request->input('notes');

        $mapping->user_id = auth()->user()->id;

        $mapping->save();

        //save the products of interest
        $products_of_interest = $request->input('products_of_interest');

        //check if the products of interest is not empty
        if (!empty($products_of_interest)) {
            foreach ($products_of_interest as $product_of_interest) {
                $product = new ProductOfInterest();

                $product->business_id = $mapping->id;
                $product->product_id = $product_of_interest['product_id'];
                $product->save();
            }
        }
        //save the Item of interest
        $items_of_interest = $request->input('items_of_interest');

        //check if the items of interest is not empty
        if (!empty($items_of_interest)) {
            foreach ($items_of_interest as $item_of_interest) {
                $item = new ItemOfInterest();

                $item->business_id = $mapping->id;

                $item->product_id = $item_of_interest['product_id'];

                $item->quantity = $item_of_interest['quantity'];

                $item->save();
            }

        }
        //show the message of success and the data
        return response()->json([
            'message' => 'Mapping created successfully',
            'data' => $mapping
        ], 201);

    }

    public function contacts()
    {
        $mappings = Mapping::where('user_id', auth()->user()->id)->get();

        // You can loop through each Mapping instance to access tel_no and email
        foreach ($mappings as $mapping) {
            $businessId = $mapping->id;
            $businessName = $mapping->business_name;
            $telNo = $mapping->business_telephone_contact;
            $email = $mapping->business_email_contact;

            $contactInfo[] = [
                'business_id' => $businessId,
                'business_name' => $businessName,
                'business_telephone_contact' => $telNo,
                'business_email_contact' => $email,
            ];
        }

        // You can return the contact information as needed
        return response()->json([
            'message' => 'Contact information retrieved successfully',
            'contacts' => $contactInfo
        ], 200);
    }

}
