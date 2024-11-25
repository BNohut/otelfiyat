<?php

namespace Database\Seeders;

use App\Models\Concept;
use Illuminate\Database\Seeder;

class ConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $concepts = [
            [
                'title' => 'Bed & Breakfast',
                'description' => 'A basic accommodation plan that includes breakfast in the room rate. The guest is responsible for lunch and dinner.'
            ],
            [
                'title' => 'Half Board',
                'description' => 'An accommodation plan that includes breakfast and dinner. Guests are responsible for lunch.'
            ],
            [
                'title' => 'Full Board',
                'description' => 'An accommodation plan that includes breakfast, lunch, and dinner. It does not typically include drinks.'
            ],
            [
                'title' => 'All Inclusive',
                'description' => 'A comprehensive plan where guests pay a single price for their stay, which includes all meals, drinks, snacks, and various activities offered by the hotel.'
            ],
            [
                'title' => 'Ultra All Inclusive',
                'description' => 'An upgraded version of the all-inclusive plan, offering additional luxury services like premium drinks, special restaurant options, and activities.'
            ]
        ];

        foreach ($concepts as $concept) {
            $currentConcept = Concept::where('title', $concept['title'])->first();
            if (!$currentConcept) {
                Concept::create($concept);
            } else {
                $currentConcept->update($concept);
            }
        }
    }
}
