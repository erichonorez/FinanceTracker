<?php
namespace FinanceTracker\Domain\Services;
use FinanceTracker\Domain\Entities\Transaction;
use FinanceTracker\Domain\Entities\Tag;
use FinanceTracker\Domain\Services\TransactionServiceInterface;

class TransactionService implements TransactionServiceInterface
{
    /**
     * @param \FinanceTracker\Domain\Entities\Transaction $persistedTransaction
     * @param \FinanceTracker\Domain\Entities\Transaction $newTransaction
     * @return mixed|void
     */
    public function synchronize(Transaction $persistedTransaction, Transaction $newTransaction)
    {
        if ($persistedTransaction->getDescription() !== $newTransaction->getDescription()) {
            $persistedTransaction->setDescription($newTransaction->getDescription());
        }

        if ($persistedTransaction->getAmount() !== $newTransaction->getAmount()) {
            $persistedTransaction->setAmount($newTransaction->getAmount());
        }

        if ($persistedTransaction->getDate() != $newTransaction->getDate()) {
            $persistedTransaction->setDate($newTransaction->getDate());
        }

        foreach ($persistedTransaction->getTags() as $tag) {
            if (!$newTransaction->isTagged($tag->getName())) {
                $persistedTransaction->untag($tag->getName());
            }
        }

        foreach ($newTransaction->getTags() as $tag) {
            if (!$persistedTransaction->isTagged($tag->getName())) {
                $persistedTransaction->addTag($tag);
            }
        }
        return $persistedTransaction;
    }
}