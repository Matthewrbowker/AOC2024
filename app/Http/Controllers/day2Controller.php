<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class day2Controller extends Controller
{

    /**
     * Method to check if the data is safe
     *
     * @param array $levels List of levels to check
     *
     * @return bool
     */
    private function checkSafe(array $levels) : bool {
        // Because we're using nested arrays - add a flag variable.
        $safe = true;

        // Checking for values that are too big or too small
        $i = 0;
        while(isset($levels[$i+1])) {
            $difference = abs($levels[$i] - $levels[$i + 1]);
            if ($difference == 0 || $difference > 3) {
                $safe = false;
            }
            $i++;
        }

        // Finally, checking to see if we're all increasing or decreasing.
        $i = 0;
        if($levels[0] < $levels[1]){
            // Increasing
            while(isset($levels[$i+1])) {
                if($levels[$i] > $levels[$i + 1]){
                    $safe = false;
                }
                $i++;
            }
        }
        else {
            while(isset($levels[$i+1])) {
                if($levels[$i] < $levels[$i + 1]){
                    $safe = false;
                }
                $i++;
            }
        }

        // Return the value
        return $safe;
    }

    public function __invoke()
    {
        // Set some variables
        $numberSafe = 0;
        $numberSafeWithDampener = 0;

        // Load the file
        $data = Storage::get("day2.txt");

        // Split the file into lines
        $dataAsArray = explode("\n", $data);

        // Iterate over each line
        foreach($dataAsArray as $line){
            if($line == "") continue;

            // Split out the data points
            $levels = explode(" ", $line);

            // Check safe values
            if($this->checkSafe($levels)){
                $numberSafe++;
            }

            // Calculate dampener
            // To do so, we remove one value at a time and calculate safety.
            // If it's safe, then stop processing.
            for($i = 0; $i < count($levels); $i++){
                // Duplicate the array so we aren't modifying the original.
                $slicedLevelArray = $levels;
                // splice one data point.
                array_splice($slicedLevelArray, $i, 1);

                // Check it
                if($this->checkSafe($slicedLevelArray)){
                    $numberSafeWithDampener++;
                    // We only want one safe value to get added - no more checking!
                    break;
                }
            }
        }

        // Send back the data
        return view("day2.index", compact("numberSafe", "numberSafeWithDampener"));
    }
}
