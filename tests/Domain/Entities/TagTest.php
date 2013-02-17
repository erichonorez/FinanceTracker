<?php
namespace Tests\Domain\Entities;
use FinanceTracker\Domain\Entities\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testContructorMustWork()
    {
        $transaction = new Tag();
        $this->assertInstanceOf('FinanceTracker\Domain\Entities\Tag', $transaction);
    }

    public function testSetNameShouldWork()
    {
        $tag = new Tag();
        $this->assertInstanceOf('FinanceTracker\Domain\Entities\Tag', $tag->setName("Hello, World!"));
        $this->assertEquals('hello-world', $tag->getName());

        $tag2 = new Tag("Hello, World!");
        $this->assertEquals('hello-world', $tag2->getName());
    }
}