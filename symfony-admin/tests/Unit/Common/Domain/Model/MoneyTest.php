<?php

namespace App\Tests\Unit\Common\Domain\Model;

use App\Common\Domain\Model\Currency;
use App\Common\Domain\Model\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testMoneyShouldByAdded(): void
    {
        $money = new Money(100, new Currency('USD'));
        $newMoney = $money->add(20);

        $this->assertEquals(120, $newMoney->amount);
    }

    public function testOriginalMoneyShouldNotBeModified(): void
    {
        $money = new Money(100, new Currency('USD'));
        $money->add(20);

        $this->assertEquals(100, $money->amount);
    }
}