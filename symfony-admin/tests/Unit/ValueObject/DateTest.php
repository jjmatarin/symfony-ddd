<?php

namespace App\Tests\Unit\ValueObject;

use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testDates()
    {
        $fromDate = new \DateTimeImmutable('2025-01-01');
        $toDate = new \DateTimeImmutable('2025-12-31');

        $fromDateString = $fromDate->format('Y-m-d');

        $selectedDate = $this->searchDate($fromDate, $toDate);
        $this->assertGreaterThanOrEqual($fromDate, $selectedDate);
        $this->assertLessThanOrEqual($toDate, $selectedDate);

        $this->assertEquals($fromDateString, $fromDate->format('Y-m-d'));
    }

    private function searchDate(\DateTimeImmutable $fromDate, \DateTimeImmutable $toDate): ?\DateTimeImmutable
    {
        $currentDate = $fromDate;
        while ($currentDate <= $toDate) {
            if (random_int(0, 1000) > 900) {
                return $currentDate;
            }
            $currentDate = $currentDate->modify('+1 day');
        }
        return null;
    }

}
