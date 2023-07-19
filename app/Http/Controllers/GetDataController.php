<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetDataController extends Controller
{
    public function getData(Request $request)
    {
        $numPeople = $request->numberofpeople;

        //Check if the input value is valid
        if ($numPeople === null || !is_numeric($numPeople) || $numPeople < 1) {

          $data['error'] = true;
          $data['output'] = 'Input value does not exist or value is invalid';

            return response()->json($data, 400);
        }

        // Create an array of cards
        $cards = [];
        $suits = ['S', 'H', 'D', 'C'];
        $ranks = ['A', '2', '3', '4', '5', '6', '7', '8', '9', 'X', 'J', 'Q', 'K'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $cards[] = $suit . '-' . $rank;
            }
        }


        // Shuffle the cards randomly
        shuffle($cards);

        //Get the number of cards to split according to the number of people
        $even_distribute_card = count($cards)/$numPeople;

        //Distribute the cards evenly
        $distribute = array_chunk($cards, $even_distribute_card);

        //Set the array
        $formattedDistribution = [];

        foreach ($distribute as $index => $personCards) {

          //Check if number of distributed cards is more than number of people
          if($index >= $numPeople){
            $formattedDistribution[] = 'Extra Card(s) ' . ($index + 1) . ': ' . implode(',', $personCards);
          }else{
            $formattedDistribution[] = 'Player ' . ($index + 1) . ': ' . implode(',', $personCards);
          }

        }


        $data['error'] = false;
        $data['output'] = $formattedDistribution;

        //return response
        return response()->json($data, 200);


    }
}
