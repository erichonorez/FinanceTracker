<?php
namespace Tests\Domain\Entities;
use FinanceTracker\Domain\Entities\Transaction;

class TransactionTest extends \PHPUnit_Framework_TestCase
{
    public function testContructorMustWork()
    {
        $transaction = new Transaction();
        $this->assertInstanceOf('FinanceTracker\Domain\Entities\Transaction', $transaction);
    }

    public function testAddTagShouldWork()
    {
        $transaction = new Transaction();
        $tag1 = new \FinanceTracker\Domain\Entities\Tag("tag1");
        $tag2 = new \FinanceTracker\Domain\Entities\Tag("tag2");
        $this->assertInstanceOf('FinanceTracker\Domain\Entities\Transaction', $transaction->addTag($tag1));
        $this->assertTrue($transaction->getTags()->contains($tag1));
        $this->assertFalse($transaction->getTags()->contains($tag2));
    }

    public function testIsExpenseShouldWork()
    {
        $transaction = new Transaction();
        $this->assertInstanceOf('FinanceTracker\Domain\Entities\Transaction', $transaction->setAmount(-100));
        $this->assertTrue($transaction->isExpense());
        $this->assertFalse($transaction->isIncome());
    }

    public function testIsIncomeShouldWork()
    {
        $transaction = new Transaction();
        $this->assertInstanceOf('FinanceTracker\Domain\Entities\Transaction', $transaction->setAmount(100));
        $this->assertTrue($transaction->isIncome());
        $this->assertFalse($transaction->isExpense());
    }
}