<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\DeliveryRequest;
use Illuminate\Support\Facades\Hash;

class DeliveryRequestSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Create a User (Authentication Record)
        $user = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'is_active' => true,
            ]
        );

        // 2️⃣ Create or Update the Sender (Customer Record)
        $sender = Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'mobile' => '1234567890',
                'email' => $user->email,
                'street' => '123 Elm Street',
                'city' => 'Metro City',
                'province' => 'Central Province',
                'zip_code' => '12345',
                'company_name' => 'Doe Inc.',
                'is_system' => false,
            ]
        );

        // 3️⃣ Create or Update the Receiver (Walk-In Customer Record)
        $receiver = Customer::updateOrCreate(
            ['email' => 'jane@example.com'],
            [
                'name' => 'Jane Smith',
                'mobile' => '0987654321',
                'street' => '456 Oak Avenue',
                'city' => 'Suburbia',
                'province' => 'West Province',
                'zip_code' => '54321',
                'company_name' => 'Smith Ltd.',
                'is_system' => true, // Indicates this is a walk-in customer
            ]
        );

        // 4️⃣ Create a Delivery Request (Linked to Sender and Receiver)
        DeliveryRequest::create([
            'user_id' => $user->id,
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,

            // Sender Info (Redundant for record-keeping in case of updates)
            'sender_type' => 'individual',
            'sender_name' => $sender->name,
            'sender_company_name' => $sender->company_name,
            'sender_mobile' => $sender->mobile,
            'sender_email' => $sender->email,
            'sender_street' => $sender->street,
            'sender_city' => $sender->city,
            'sender_province' => $sender->province,
            'sender_zip' => $sender->zip_code,
            'drop_off_branch' => 'Metro Branch',

            // Receiver Info
            'receiver_type' => 'company',
            'receiver_name' => $receiver->name,
            'receiver_company_name' => $receiver->company_name,
            'receiver_mobile' => $receiver->mobile,
            'receiver_email' => $receiver->email,
            'receiver_street' => $receiver->street,
            'receiver_city' => $receiver->city,
            'receiver_province' => $receiver->province,
            'receiver_zip' => $receiver->zip_code,
            'pick_up_branch' => 'Suburbia Branch',

            // Package & Payment Details
            'packages' => json_encode([
                [
                    'description' => 'Electronics',
                    'height' => '0.5',
                    'width' => '0.4',
                    'length' => '0.6',
                    'weight' => '2.5',
                    'quantity' => 2,
                    'value' => '1500',
                ],
                [
                    'description' => 'Clothes',
                    'height' => '0.3',
                    'width' => '0.3',
                    'length' => '0.4',
                    'weight' => '1.2',
                    'quantity' => 1,
                    'value' => '500',
                ],
            ]),
            'payment_method' => 'cash',
            'total_price' => 2000,

            // Status of the delivery
            'status' => 'pending',
        ]);

        $this->command->info('✅ Delivery request seeder completed successfully!');
    }
}
