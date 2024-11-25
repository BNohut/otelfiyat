<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                "name" => "Türk Lirası",
                "iso" => "TRY",
                "symbol" => "₺",
                "color_hex_code" => "#db8585"
            ],
            [
                "name" => "Amerikan Doları",
                "iso" => "USD",
                "symbol" => "$",
                "color_hex_code" => "#4d896a"
            ],
            [
                "name" => "Avro",
                "iso" => "EUR",
                "symbol" => "€",
                "color_hex_code" => "#748dc8"
            ],
            [
                "name" => "Japon Yeni",
                "iso" => "JPY",
                "symbol" => "¥",
                "color_hex_code" => "#c8a974"
            ],
            [
                "name" => "İngiliz Sterlini",
                "iso" => "GBP",
                "symbol" => "£",
                "color_hex_code" => "#d684d9"
            ],
            [
                "name" => "Çin Yuanı",
                "iso" => "CNY",
                "symbol" => "¥",
                "color_hex_code" => "#f2799d"
            ],
            [
                "name" => "Avustralya Doları",
                "iso" => "AUD",
                "symbol" => "A$",
                "color_hex_code" => "#478039"
            ],
            [
                "name" => "Kanada Doları",
                "iso" => "CAD",
                "symbol" => "C$",
                "color_hex_code" => "#395d80"
            ],
            [
                "name" => "Kuveyt Dinarı",
                "iso" => "KWD",
                "symbol" => "ك",
                "color_hex_code" => "#544b47"
            ],
        ];

        foreach ($currencies as $currency) {
          $currentCurrency = Currency::where('iso', $currency['iso'])->first();
          if (!$currentCurrency) {
            Currency::create($currency);
          }else{
            $currentCurrency->update($currency);
          }
        }
    }
}
