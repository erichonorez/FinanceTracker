<?php
namespace FinanceTracker\Domain\Repositories;
use \Svomz\Domain\Repositories\RepositoryInterface;

/**
 * Defines what a TransactionRepository has to implement
 */
interface TransactionRepositoryInterface extends RepositoryInterface
{
    const TRANSACTION_TYPE_EXPENSE = 1;
    const TRANSACTION_TYPE_INCOME = 2;
    /**
     * Get transactions according to parameters
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param array $tags
     * @param int transaction type
     * @return ArrayCollection
     */
    public function search(
        $startDate = null, $endDate = null, array $tags = array(), $transactionType = 0);
}