<?php
namespace FinanceTracker\Domain\Repositories;
use Svomz\Domain\Repositories\UnitOfWorkInterface;

/**
 * Defines what a FinanceTracker unit of work has to implement
 */
interface FinanceTrackerUnitOfWorkInterface extends UnitOfWorkInterface
{
    /**
     * @return TransactionRepositoryInterface
     */
    public function getTransactionRepository();
    /**
     * @return TagRepositoryInterface;
     */
    public function getTagRepository();
}