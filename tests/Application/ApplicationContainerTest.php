<?php
namespace Tests\Application;
use FinanceTracker\Application\ApplicationContainer;

class ApplicationContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFinanceTrackerUnitOfWorkShouldWork()
    {
        $applicationContainer = new ApplicationContainer();
        $this->assertInstanceOf(
            'FinanceTracker\Domain\Repositories\FinanceTrackerUnitOfWorkInterface',
            $applicationContainer['unitOfWork']
        );
    }

    public function testGetTransactionRepositoryShouldWork()
    {
        $applicationContainer = new ApplicationContainer();
        $this->assertInstanceOf(
            'FinanceTracker\Domain\Repositories\TransactionRepositoryInterface',
            $applicationContainer['transactionRepository']
        );
    }
}