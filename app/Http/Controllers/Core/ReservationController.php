<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'hotel_room_id' => 'required|exists:hotel_rooms,id',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date',
                'note' => 'string',
                'users' => 'required|array',
                'payment' => 'required|array',
            ]);

            $users = $request->users;

            // Users array has to have at least one user
            if (count($users) < 1) {
                return response()->json([
                    'message' => 'At least one user is required'
                ], 422);
            }

            // Check each user for required fields
            $hasValidContact = false; // To check if at least one user has email or phone_number
            $validContact = null; // To store payment information
            foreach ($users as $user) {
                // Check if user has required fields: name, age, identity_number
                if (!isset($user['name']) || !isset($user['age']) || !isset($user['identity_number'])) {
                    return response([
                        'message' => 'Each user must have name, age, and identity_number'
                    ], 422);
                }

                // Check if at least one user has email or phone_number
                if (isset($user['phone']) || isset($user['email'])) {
                    $hasValidContact = true; // Mark that we found at least one valid contact
                    $validContact = $user; // Store the valid contact
                }
            }

            // Ensure that at least one user has a valid phone number or email
            if (!$hasValidContact) {
                return response()->json([
                    'message' => 'At least one user must have a phone_number or email'
                ], 422);
            }

            // Fetch the hotel room and hotel details
            $hotelRoom = DB::select('SELECT * FROM hotel_rooms WHERE id = ?', [$request->hotel_room_id])[0];
            $hotel = DB::select('SELECT * FROM hotels WHERE id = ?', [$hotelRoom->hotel_id])[0];

            $minChildAge = $hotel->min_child_age;  // Minimum age for a child to be considered for child price
            $maxChildAge = $hotel->max_child_age;  // Maximum age for a child to get child pricing

            $totalAmount = 0;

            // Loop through each user and calculate the total amount
            foreach ($users as $user) {
                $age = $user['age'];

                if ($age < $minChildAge) {
                    // If the user is younger than the min_child_age, the child is free
                    $totalAmount += 0;
                } elseif ($age >= $minChildAge && $age <= $maxChildAge) {
                    // If the user is a child, apply child pricing
                    $totalAmount += $hotelRoom->child_unit_price;
                    $totalAmount += $hotelRoom->extra_concept_price_child;
                } else {
                    // If the user is an adult, apply adult pricing
                    $totalAmount += $hotelRoom->adult_unit_price;
                    $totalAmount += $hotelRoom->extra_concept_price_adult;
                }
            }

            // Create reservation entry (assuming you have a reservations table)
            $reservationInsertResult = DB::insert('INSERT INTO reservations (hotel_room_id, check_in_date, check_out_date, amount, note, reservation_number) VALUES (?, ?, ?, ?, ?, ?)', [
                $request->hotel_room_id,
                $request->check_in_date,
                $request->check_out_date,
                $totalAmount,
                $request->note,
                'RES' . time(),  // Generate unique reservation number
            ]);

            if ($reservationInsertResult) {
                $reservation = DB::select('SELECT * FROM reservations WHERE id = ?', [DB::getPdo()->lastInsertId()])[0];
            }

            // Create users and link them to the reservation
            foreach ($users as $userData) {
                $userExists = DB::select('SELECT * FROM users WHERE identity_number = ?', [$userData['identity_number']]);
                if (!$userExists) {
                    // Create the user and get the user instance
                    $userInsertResult = DB::insert('INSERT INTO users (name, age, identity_number, phone, email) VALUES (?, ?, ?, ?, ?)', [
                        $userData['name'],
                        $userData['age'],
                        $userData['identity_number'],
                        $userData['phone'] ?? null,
                        $userData['email'] ?? null,
                    ]);
                    $user = DB::select('SELECT * FROM users WHERE id = ?', [DB::getPdo()->lastInsertId()])[0];
                } else {
                    $user = $userExists[0];
                }

                // Associate the user with the reservation through the pivot table
                DB::insert('INSERT INTO reservation_users (reservation_id, user_id) VALUES (?, ?)', [
                    $reservation->id,
                    $user->id,
                ]);
            }

            // Find the user with valid contact information
            $validContactUser = DB::select('SELECT * FROM users WHERE identity_number = ?', [$validContact['identity_number']])[0];

            $paymentData = [
                'user_id' => $validContactUser->id,
                'reservation_id' => $reservation->id,
                'payment_method_id' => $request->payment[0]["payment_method_id"],
                'transaction_info' => json_encode($request->payment[0]['transaction_info']),
                'installments' => $request->payment[0]['installment'],
            ];

            // Create payment entry
            $paymentInsertResult = DB::insert('INSERT INTO payments (user_id, reservation_id, payment_method_id, transaction_info, installments) VALUES (?, ?, ?, ?, ?)', [
                $paymentData['user_id'],
                $paymentData['reservation_id'],
                $paymentData['payment_method_id'],
                $paymentData['transaction_info'],
                $paymentData['installments'],
            ]);


            // Return a success response
            return response()->json([
                'message' => 'Reservation created successfully',
                'reservation_number' => $reservation->reservation_number,
            ], 201);
        } catch (\Exception $err) {
            return response([
                'status' => 'false',
                'message' => 'Something went wrong',
                'error' => $err->getMessage() . ' ' . $err->getLine() . ' ' . $err->getFile()
            ], 500);
        }
    }
}
