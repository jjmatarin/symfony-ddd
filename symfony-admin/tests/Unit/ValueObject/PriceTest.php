<?php

namespace App\Tests\Unit\ValueObject;

use App\Common\Domain\Model\Currency;
use App\Common\Domain\Model\Money;
use App\Common\Domain\Model\WrongMoney;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testClonedMoneyShouldRepresentSameValue(): void
    {
        $money = new Money(100, new Currency('USD'));
        $clonedMoney = Money::clone($money);

        $this->assertEquals($money->amount, $clonedMoney->amount);
        $this->assertTrue($money->equals($clonedMoney));
    }

    public function testOriginalMoneyShouldNotBeModifiedOnAddition(): void
    {
        $money = new Money(100, new Currency('USD'));
        $money->add(new Money(20, new Currency('USD')));

        $this->assertEquals(100, $money->amount);
    }

    public function testMoneyShouldBeAdded(): void
    {
        $money = new Money(100, new Currency('USD'));
        $newMoney = $money->add(new Money(20, new Currency('USD')));

        $this->assertEquals(120, $newMoney->amount);
    }

    public function testWrongMoneyCanModifyOnAddition(): void
    {
        $money = new WrongMoney(100, new Currency('USD'));
        $money->add(new WrongMoney(20, new Currency('USD')));

        $this->assertEquals(120, $money->amount);
    }
}
