<?php
namespace FinanceTracker\Domain\Repositories\Transaction;
/**
 *
 */
interface TransactionFinderInterface
{
    /**
     * @param TransactionSearchCriteriaInterface $criteria
     * @return mixed
     */
    public function find(TransactionSearchCriteriaInterface $criteria);
}