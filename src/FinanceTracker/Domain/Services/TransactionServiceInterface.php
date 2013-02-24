<?php
namespace FinanceTracker\Domain\Services;
use FinanceTracker\Domain\Entities\Transaction;
/**
 *
 */
interface TransactionServiceInterface
{
    /**
     * @param Transaction $persistedTransaction
     * @param Transaction $newTransaction
     * @return TransactionServiceInterface
     */
    public function synchronize(Transaction $persistedTransaction, Transaction $newTransaction);
}