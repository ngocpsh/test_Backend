<?php

namespace App\Services;

class AgeDifferenceService
{
    public function findTopAgeDifference(array $peoples): array
    {
        $n = count($peoples);
        if ($n == 0) {
            return [];
        }

        // Sort people by age
        usort($peoples, function($a, $b) {
            return $a['age'] - $b['age'];
        });
        // Compute prefix sums
        $prefixSum[] = 0;
        for ($i = 0; $i < $n; $i++) {
            $prefixSum[$i+1] = $prefixSum[$i] + $peoples[$i]['age'];
        }

        // Calculate sum of age differences for each person
        $peopleWithSumDiff = [];
        for ($k = 0; $k < $n; $k++) {
            $person = $peoples[$k];
            $sumDiff = $k * $person['age'] - $prefixSum[$k] + ($prefixSum[$n] - $prefixSum[$k+1]) - ( $n - $k - 1 ) * $person['age'];
            $peopleWithSumDiff[] = ['age' => $person['age'], 'sumDiff' => $sumDiff];
        }

        // Sort by sum_diff descending
        usort($peopleWithSumDiff, function($a, $b) {
            return $b['sumDiff'] - $a['sumDiff'];
        });

        // Calculate number of people to select (top 20%)
        $m = round($n * 0.2);
        if ($m == 0) {
            return [];
        }
        // Select top m people
        $topPeople = array_slice($peopleWithSumDiff, 0, $m);

        // Return their ids
        return array_map(function ($person) {
            return ['age' => $person['age']];
        }, $topPeople);
    }
}
