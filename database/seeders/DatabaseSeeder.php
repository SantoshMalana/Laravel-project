<?php

namespace Database\Seeders;

use App\Models\ExportRequest;
use App\Models\ShipmentTracking;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin — Dak Ghar',
            'email' => 'admin@dakghar.in',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+91-11-2345-6789',
            'address' => 'Head Post Office, Sansad Marg, New Delhi - 110001',
        ]);

        // Staff
        $staff = User::create([
            'name' => 'Ramesh Kumar',
            'email' => 'staff@dakghar.in',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '+91-98765-43210',
            'address' => 'GPO, Mumbai - 400001',
        ]);

        // Customers
        $customer1 = User::create([
            'name' => 'Priya Sharma',
            'email' => 'customer@dakghar.in',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+91-99887-76655',
            'address' => '14, MG Road, Bengaluru - 560001',
        ]);

        $customer2 = User::create([
            'name' => 'Arjun Mehta',
            'email' => 'arjun@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+91-88776-65544',
            'address' => '7, Park Street, Kolkata - 700016',
        ]);

        // Sample export requests
        $req1 = ExportRequest::create([
            'user_id' => $customer1->id,
            'tracking_no' => 'DGEX2024ABC12345',
            'origin' => 'India',
            'destination_country' => 'United Kingdom',
            'destination_city' => 'London',
            'recipient_name' => 'John Smith',
            'recipient_address' => '221B Baker Street, London, W1A 1AA',
            'recipient_phone' => '+44-20-7946-0958',
            'goods_description' => 'Handloom sarees and traditional handicrafts',
            'goods_category' => 'handicrafts',
            'weight_kg' => 3.500,
            'declared_value' => 12500.00,
            'currency' => 'INR',
            'service_type' => 'express',
            'status' => 'in_transit',
            'notes' => 'Fragile items, handle with care.',
            'approved_at' => now()->subDays(3),
            'dispatched_at' => now()->subDays(2),
        ]);

        ShipmentTracking::create(['export_request_id' => $req1->id, 'status' => 'pending', 'location' => 'Bengaluru GPO', 'description' => 'Shipment received at origin post office.', 'updated_by' => $staff->id, 'created_at' => now()->subDays(5)]);
        ShipmentTracking::create(['export_request_id' => $req1->id, 'status' => 'approved', 'location' => 'Bengaluru GPO', 'description' => 'Shipment approved and customs clearance initiated.', 'updated_by' => $staff->id, 'created_at' => now()->subDays(3)]);
        ShipmentTracking::create(['export_request_id' => $req1->id, 'status' => 'in_transit', 'location' => 'Mumbai International Airport', 'description' => 'Shipment dispatched. In transit via air freight.', 'updated_by' => $staff->id, 'created_at' => now()->subDays(2)]);

        $req2 = ExportRequest::create([
            'user_id' => $customer2->id,
            'tracking_no' => 'DGEX2024DEF67890',
            'origin' => 'India',
            'destination_country' => 'United States',
            'destination_city' => 'New York',
            'recipient_name' => 'Emily Davis',
            'recipient_address' => '500 5th Avenue, New York, NY 10110',
            'recipient_phone' => '+1-212-555-0147',
            'goods_description' => 'Ayurvedic medicines and herbal supplements',
            'goods_category' => 'medicine',
            'weight_kg' => 1.200,
            'declared_value' => 4500.00,
            'currency' => 'INR',
            'service_type' => 'standard',
            'status' => 'pending',
            'notes' => 'FDA compliant packaging. Invoices attached.',
        ]);

        ShipmentTracking::create(['export_request_id' => $req2->id, 'status' => 'pending', 'location' => 'Kolkata GPO', 'description' => 'Export request submitted. Awaiting staff review.', 'updated_by' => null, 'created_at' => now()->subDay()]);
    }
}
