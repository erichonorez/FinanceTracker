<?php
namespace FinanceTracker\Domain\Repositories\Transaction;
/**
 *
 */
interface TransactionSearchCriteriaInterface
{
    /**
     *
     */
    const TRANSACTION_TYPE_EXPENSE = 1;
    /**
     *
     */
    const TRANSACTION_TYPE_INCOME = 2;
    /**
     *
     */
    const TRANSACTION_TYPE_ALL = 3;
    /**
     * @param \DateTime $startDate
     * @return mixed
     */
    public function setStartDate(\DateTime $startDate);

    /**
     * @return mixed
     */
    public function getStartDate();

    /**
     * @param \DateTime $endDate
     * @return mixed
     */
    public function setEndDate(\DateTime $endDate);

    /**
     * @return mixed
     */
    public function getEndDate();

    /**
     * @param array $tags
     * @return mixed
     */
    public function setTags(array $tags);

    /**
     * @return mixed
     */
    public function getTags();

    /**
     * @return mixed
     */
    public function setTransactionType($transactionType);

    /**
     * @return mixed
     */
    public function getTransactionType();
}