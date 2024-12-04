<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class day3Controller extends Controller
{
    public function __invoke()
    {
        // Start with some variables
        $multipliedValue = 0;
        $multipliedValueWithEnabled = 0;

        // Load the data
        $data = Storage::get("day3.txt");

        // Start by just pulling the mul instructions
        preg_match_all("/mul\(\d+,\d+\)/m", $data, $matches);

        // Iterate over the instructions, extracting the numbers and multiplying
        foreach($matches[0] as $match){
            preg_match("/(\d+),(\d+)/m", $match, $multiplicands);
            $multipliedValue += $multiplicands[1] * $multiplicands[2];
        }

        // Now, part 2

        // Flag variable, used in the loop below.
        $multiplicationEnabled = true;

        // Updated regex, pulls mul, do, and don't instructions
        preg_match_all("/(do\(\)|don't\(\)|mul\(\d+,\d+\))?/", $data, $matches);

        // Iterate over the matches
        foreach($matches[0] as $match){
            // Ignore blank results.
            if($match == "") continue;

            // Handle the instructions.
            // Do and Don't set the variable, otherwise we extract the numbers and multiply again.
            if($match == "do()") {
                $multiplicationEnabled = true;
            }
            elseif($match == "don't()") {
                $multiplicationEnabled = false;
            }
            else {
                if($multiplicationEnabled) {
                    preg_match("/(\d+),(\d+)/m", $match, $multiplicands);
                    $multipliedValueWithEnabled += $multiplicands[1] * $multiplicands[2];
                }
            }
        }

        // Show the user.
        return view('day3.index', compact('multipliedValue', 'multipliedValueWithEnabled'));
    }
}
