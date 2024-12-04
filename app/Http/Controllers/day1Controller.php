<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class day1Controller extends Controller
{
    public function __invoke()
    {
        // Set up some variables
        $leftSet = [];
        $rightSet = [];
        $distance = 0;
        $similarityScore = 0;

        // Load the data from a file
        $data = Storage::get('day1.txt');

        // Split out the lines
        $dataAsArray = explode("\n", $data);

        // Count the number of lines
        $lines = count($dataAsArray);

        // Parse the lines into left and right lists - I am storing them in separate arrays here.
        foreach ($dataAsArray as $line) {
            // Ignore empty lines.
            if($line == "") continue;

            // Whitespace trim, then split into two values.
            $line = trim($line);
            $lineAsArray = explode(" ", $line, 2);

            if(!isset($lineAsArray[0]) || !isset($lineAsArray[1])) {
                // Something else happened with the line parsing, continue.
                continue;
            }

            // Store each value in the proper set.
            $leftSet[] = trim($lineAsArray[0]);
            $rightSet[] = trim($lineAsArray[1]);
        }

        // This is actually part 2 - however, part 1 destroys the array so we're doing this first.
        // Start by counting the values in the right set.
        $rightsetParsed = array_count_values($rightSet);

        // Now, iterate over the left set.  If we find a matching value in the right set, multiply it and add it to the
        // similarity score.
        foreach($leftSet as $line){
            if(array_key_exists($line, $rightsetParsed)){
                $similarityScore += $line * $rightsetParsed[$line];
            }
        }

        // Back to part 1, calculating distance.
        for($i = 0; $i < $lines; $i++){
            // Set up some variables - scoped to this loop.
            $keyLeft = 0;
            $lowestValueLeft = 9999999;
            $keyRight = 0;
            $lowestValueRight = 9999999;

            // Find the lowest number for the left set - ignoring zero.
            foreach($leftSet as $key=>$line){
                if($line == 0) continue;
                if($lowestValueLeft > $line){
                    $keyLeft = $key;
                    $lowestValueLeft = $line;
                }
            }

            // Find the lowest number for the right set - ignoring zero.
            foreach($rightSet as $key=>$line){
                if($line == 0) continue;
                if($lowestValueRight > $line){
                    $keyRight = $key;
                    $lowestValueRight = $line;
                }
            }

            // Add the value to the distance.
            $distance += abs($lowestValueLeft - $lowestValueRight);

            // Null out the lines, so that we don't calculate them again.
            $leftSet[$keyLeft] = 0;
            $rightSet[$keyRight] = 0;
        }

        // Done, send a result back to the frontend.
        return view('day1.index', compact('distance', 'similarityScore'));
    }
}
