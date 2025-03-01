<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // Ensure only authenticated users can submit
    }

    public function rules(): array
{
    return [
        // Customer Type
        'customerType' => 'required|in:individual,company',

        // Sender Information
        'senderFirstName' => 'required|string|max:255',
        'senderLastName' => 'required|string|max:255',
        'senderCompanyName' => 'required_if:customerType,company|string|max:255|nullable',
        'senderMobile' => 'required|string|max:15',
        'dropOffBranch' => 'required|string|in:Naga,Malabon,Legazpi',

        // Sender Address (Flat structure)
        'senderStreet' => 'required|string|max:255',
        'senderCity' => 'required|string|max:255',
        'senderProvince' => 'required|string|max:255',
        'senderZip' => 'required|string|max:10',

        // Receiver Information
        'receiverFirstName' => 'required|string|max:255',
        'receiverLastName' => 'required|string|max:255',
        'receiverMobile' => 'required|string|max:15',
        'pickUpBranch' => 'required|string|in:Naga,Malabon,Legazpi',

        // Receiver Address (Flat structure)
        'receiverStreet' => 'required|string|max:255',
        'receiverCity' => 'required|string|max:255',
        'receiverProvince' => 'required|string|max:255',
        'receiverZip' => 'required|string|max:10',

        // Package Details
        'itemDescription' => 'required|string|max:1000',
        'itemHeight' => 'required|numeric|min:0.01',
        'itemWidth' => 'required|numeric|min:0.01',
        'itemLength' => 'required|numeric|min:0.01',
        'itemWeight' => 'required|numeric|min:0.01',
        'itemQuantity' => 'required|integer|min:1',
    ];
}

public function messages(): array
{
    return [
        'senderFirstName.required' => 'Sender first name is required.',
        'senderLastName.required' => 'Sender last name is required.',
        'senderMobile.required' => 'Sender mobile number is required.',
        'senderStreet.required' => 'Sender street is required.',
        'senderCity.required' => 'Sender city is required.',
        'senderProvince.required' => 'Sender province is required.',
        'senderZip.required' => 'Sender ZIP code is required.',
        'receiverFirstName.required' => 'Receiver first name is required.',
        'receiverLastName.required' => 'Receiver last name is required.',
        'receiverMobile.required' => 'Receiver mobile number is required.',
        'receiverStreet.required' => 'Receiver street is required.',
        'receiverCity.required' => 'Receiver city is required.',
        'receiverProvince.required' => 'Receiver province is required.',
        'receiverZip.required' => 'Receiver ZIP code is required.',
        'itemDescription.required' => 'Package description is required.',
        'itemHeight.required' => 'Package height is required.',
        'itemWidth.required' => 'Package width is required.',
        'itemLength.required' => 'Package length is required.',
        'itemWeight.required' => 'Package weight is required.',
        'itemQuantity.required' => 'Package quantity is required.',
    ];
}
}
