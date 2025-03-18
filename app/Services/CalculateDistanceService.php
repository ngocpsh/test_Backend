<?php

namespace App\Services;

class CalculateDistanceService
{
    function squaredDistance($p1, $p2) {
        return pow(($p1[0] - $p2[0]), 2) + pow(($p1[1] - $p2[1]), 2);
    }

    function calculateDistance(array $positions): array
    {
        $totalPeople = count($positions);
        $k = ceil(0.1 * $totalPeople);
        if ($k == 0) return [];

        $minDistances = [];
        for ($i = 0; $i < $totalPeople; $i++) {
            $minDist = INF; // Giá trị vô cùng lớn
            for ($j = 0; $j < $totalPeople; $j++) {
                if ($i != $j) {
                    $dist = $this->squaredDistance($positions[$i], $positions[$j]);
                    if ($dist < $minDist) {
                        $minDist = $dist;
                    }
                }
            }
            $minDistances[] = [$minDist, $i];
        }

        usort($minDistances, function($a, $b) {
            return $b[0] <=> $a[0];
        });
        $selected = array_slice($minDistances, 0, $k);

        return array_map(function ($item) use ($positions) {
            return $positions[$item[1]];
        }, $selected);
    }
}
