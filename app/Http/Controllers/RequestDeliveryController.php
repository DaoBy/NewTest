<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DeliveryRequest;
use Illuminate\Http\Request;

class RequestDeliveryController extends Controller
{
    /**
     * Store a new delivery request.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'senderType' => 'required|string',
            'senderFullName' => 'required|string|max:255',
            'senderCompanyName' => 'nullable|string|max:255',
            'senderMobile' => 'required|string|max:15',
            'senderEmail' => 'required|email|max:255',
            'senderStreet' => 'required|string|max:255',
            'senderCity' => 'required|string|max:255',
            'senderProvince' => 'required|string|max:255',
            'senderZip' => 'required|string|max:10',
            'dropOffBranch' => 'required|string|max:255',
            'receiverType' => 'required|string',
            'receiverFullName' => 'required|string|max:255',
            'receiverCompanyName' => 'nullable|string|max:255',
            'receiverMobile' => 'required|string|max:15',
            'receiverEmail' => 'required|email|max:255',
            'receiverStreet' => 'required|string|max:255',
            'receiverCity' => 'required|string|max:255',
            'receiverProvince' => 'required|string|max:255',
            'receiverZip' => 'required|string|max:10',
            'pickUpBranch' => 'required|string|max:255',
            'packages' => 'required|array|min:1',
            'packages.*.description' => 'required|string',
            'packages.*.height' => 'required|numeric|min:0',
            'packages.*.width' => 'required|numeric|min:0',
            'packages.*.length' => 'required|numeric|min:0',
            'packages.*.weight' => 'required|numeric|min:0',
            'packages.*.quantity' => 'required|integer|min:1',
            'packages.*.value' => 'required|numeric|min:0',
            'paymentMethod' => 'required|string|in:cash,card',
            'totalPrice' => 'required|numeric|min:0',

        ]);

        // Helper function to find or update a customer
        $sender = $this->findOrCreateCustomer([
            'type' => $validated['senderType'],
            'name' => $validated['senderFullName'],
            'company_name' => $validated['senderCompanyName'],
            'mobile' => $validated['senderMobile'],
            'email' => $validated['senderEmail'],
            'street' => $validated['senderStreet'],
            'city' => $validated['senderCity'],
            'province' => $validated['senderProvince'],
            'zip' => $validated['senderZip'],
        ]);

        $receiver = $this->findOrCreateCustomer([
            'type' => $validated['receiverType'],
            'name' => $validated['receiverFullName'],
            'company_name' => $validated['receiverCompanyName'],
            'mobile' => $validated['receiverMobile'],
            'email' => $validated['receiverEmail'],
            'street' => $validated['receiverStreet'],
            'city' => $validated['receiverCity'],
            'province' => $validated['receiverProvince'],
            'zip' => $validated['receiverZip'],
        ]);

        // Create Delivery Request linked to customers
$deliveryRequest = DeliveryRequest::create([
    'sender_id' => $sender->id,
    'receiver_id' => $receiver->id,

    // Sender Information
    'sender_type' => $validated['senderType'],
    'sender_name' => $validated['senderFullName'],
    'sender_company_name' => $validated['senderCompanyName'],
    'sender_mobile' => $validated['senderMobile'],
    'sender_email' => $validated['senderEmail'],
    'sender_street' => $validated['senderStreet'],
    'sender_city' => $validated['senderCity'],
    'sender_province' => $validated['senderProvince'],
    'sender_zip' => $validated['senderZip'],
    'drop_off_branch' => $validated['dropOffBranch'],

    // Receiver Information
    'receiver_type' => $validated['receiverType'],
    'receiver_name' => $validated['receiverFullName'],
    'receiver_company_name' => $validated['receiverCompanyName'],
    'receiver_mobile' => $validated['receiverMobile'],
    'receiver_email' => $validated['receiverEmail'],
    'receiver_street' => $validated['receiverStreet'],
    'receiver_city' => $validated['receiverCity'],
    'receiver_province' => $validated['receiverProvince'],
    'receiver_zip' => $validated['receiverZip'],
    'pick_up_branch' => $validated['pickUpBranch'],

    // Package and Payment Details
    'packages' => json_encode($validated['packages']),
    'payment_method' => $validated['paymentMethod'],
    'total_price' => $validated['totalPrice'],

    'status' => 'pending', // Initial status
]);
    }

    /**
     * Find an existing customer by email and mobile or create a new one.
     */
    private function findOrCreateCustomer(array $data)
    {
        return Customer::updateOrCreate(
            [
                'email' => $data['email'],
                'mobile' => $data['mobile'],
            ],
            $data
        );
    }
}
