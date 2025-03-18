<?php
namespace App\Services;

class StudentAgeCounter
{
    private array $students;

    public function __construct(array $students)
    {
        $this->students = $students;
    }

    public function countYoungerThanThreshold(int $thresholdMonths): int
    {
        return count(array_filter($this->students, fn($age) => $age < $thresholdMonths));
    }

    public function countOlderThanThreshold(int $thresholdMonths): int
    {
        return count(array_filter($this->students, fn($age) => $age > $thresholdMonths));
    }

    public static function generateStudents(): array
    {
        $classes = [
            ['count' => 5, 'size' => 35],
            ['count' => 6, 'size' => 45],
            ['count' => 10, 'size' => 30],
            ['count' => 4, 'size' => 40]
        ];

        $students = [];
        $averageAgeMonths = (20 * 12) + 8; // 20 years 8 months -> 248 months

        foreach ($classes as $class) {
            for ($i = 0; $i < $class['count'] * $class['size']; $i++) {
                $students[] = $averageAgeMonths;
            }
        }

        return $students;
    }
}
