<?php

namespace App\Tests\Unit\Common\Domain\Model;

use App\Common\Domain\Model\Currency;
use App\Common\Domain\Model\Money;
use App\Common\Domain\Model\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testOriginalMoneyShouldNotBeModified(): void
    {
        $money = new Money(100, new Currency('USD'));
        $price = new Price($money, new \DateTimeImmutable('2025-09-15'));

        $this->assertEquals(100, $price->money->amount);
        $this->assertEquals('2025-09-15', $price->date->format('Y-m-d'));
    }

    public function testImmutableDates(): void
    {
        $fromDate = new \DateTimeImmutable('2025-01-01');
        $toDate = new \DateTimeImmutable('2025-12-31');

        $fromDateString = $fromDate->format('Y-m-d');
        $selectedDate = $this->searchDate($fromDate, $toDate);
        $this->assertGreaterThanOrEqual($fromDate, $selectedDate);
        $this->assertLessThanOrEqual($toDate, $selectedDate);
        // flush
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