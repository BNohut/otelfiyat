<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethods = [
            [
                'title' => 'Credit Card',
                'description' => 'Pay with your credit card',
                'icon' => 'fa-solid fa-credit-card',
            ],
            [
                'title' => 'Bank Transfer',
                'description' => 'Transfer money from your bank account',
                'icon' => 'fa-solid fa-university',
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::updateOrCreate(
                ['title' => $method['title']], // Arama kriteri
                ['description' => $method['description'], 'icon' => $method['icon']] // Güncellenecek veya oluşturulacak alanlar
            );
        }
    }
}
