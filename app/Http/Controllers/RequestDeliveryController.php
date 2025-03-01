<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeliveryRequest;
use App\Models\DeliveryRequest;
use App\Models\DeliveryAddress;
use App\Models\DeliveryPackage;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class RequestDeliveryController extends Controller
{
    // Show the form
    public function create()
    {
        return Inertia::render('Customer/RequestDelivery');
    }

    // Store the delivery request
    public function store(StoreDeliveryRequest $request)
{
    // Create the delivery request
    $deliveryRequest = DeliveryRequest::create([
        'user_id' => auth()->id(),
        'customer_type' => $request->customerType,
        'drop_off_branch' => $request->dropOffBranch,
        'pick_up_branch' => $request->pickUpBranch,
        'status' => 'pending',
    ]);

    // Create sender address
    $deliveryRequest->senderAddress()->create([
        'type' => 'sender',
        'first_name' => $request->senderFirstName,
        'last_name' => $request->senderLastName,
        'company_name' => $request->senderCompanyName,
        'mobile' => $request->senderMobile,
        'street' => $request->senderStreet,
        'city' => $request->senderCity,
        'province' => $request->senderProvince,
        'zip' => $request->senderZip,
    ]);

    // Create receiver address
    $deliveryRequest->receiverAddress()->create([
        'type' => 'receiver',
        'first_name' => $request->receiverFirstName,
        'last_name' => $request->receiverLastName,
        'mobile' => $request->receiverMobile,
        'street' => $request->receiverStreet,
        'city' => $request->receiverCity,
        'province' => $request->receiverProvince,
        'zip' => $request->receiverZip,
    ]);

    // Create package details
    $deliveryRequest->package()->create([
        'description' => $request->itemDescription,
        'height' => $request->itemHeight,
        'width' => $request->itemWidth,
        'length' => $request->itemLength,
        'weight' => $request->itemWeight,
        'quantity' => $request->itemQuantity,
        'volume' => $request->itemHeight * $request->itemWidth * $request->itemLength,
    ]);

    return redirect()->route('request-delivery.create')->with('success', 'Delivery request submitted successfully!');
}

    /**
     * Create sender/receiver addresses.
     */
    private function createAddress($deliveryRequest, $validated, $type)
    {
        $address = $validated["{$type}Address"]; // ✅ Access nested address data

        DeliveryAddress::create([
            'delivery_request_id' => $deliveryRequest->id,
            'type' => $type,
            'first_name' => $validated["{$type}FirstName"],
            'last_name' => $validated["{$type}LastName"],
            'company_name' => ($type === 'sender' && $validated['customer_type'] === 'company')
                ? $validated['senderCompanyName']
                : null,
            'mobile' => $validated["{$type}Mobile"],
            'street' => $address['street'], // ✅ Fixed to use nested address
            'city' => $address['city'],
            'province' => $address['province'],
            'zip' => $address['zip'],
        ]);
    }
}
