<?php
namespace FinanceTracker\Infrastructure\Domain\Repositories\Odm\Transaction;
use Doctrine\ODM\MongoDB\DocumentManager;
use FinanceTracker\Domain\Repositories\Transaction\TransactionFinderInterface;
use FinanceTracker\Domain\Repositories\Transaction\TransactionSearchCriteriaInterface;

/**
 *
 */
class TransactionFinder implements TransactionFinderInterface
{
    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $_documentManager;

    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->_documentManager = $documentManager;
    }

    /**
     * @param \FinanceTracker\Domain\Repositories\Transaction\TransactionSearchCriteriaInterface $criteria
     * @return mixed
     * @throws \Exception
     */
    public function find(TransactionSearchCriteriaInterface $criteria)
    {
        if ($criteria->getStartDate() > $criteria->getEndDate()) {
            throw new \Exception();
        }
        $queryBuilder = $this->_documentManager
            ->createQueryBuilder('FinanceTracker\Domain\Entities\Transaction');

        $queryBuilder->field('_date')->gte($criteria->getStartDate());
        //$queryBuilder->field('_date')->lt($criteria->getEndDate());

        if (count($criteria->getTags()) > 0) {
            $queryBuilder->field('_tags.$id')->all($criteria->getTags());
        }

        switch ($criteria->getTransactionType()) {
            case TransactionSearchCriteriaInterface::TRANSACTION_TYPE_EXPENSE:
                $queryBuilder->field('_amount')->lt(0);
                break;
            case TransactionSearchCriteriaInterface::TRANSACTION_TYPE_INCOME:
                $queryBuilder->field('_amount')->gt(0);
                break;
        }
        return $queryBuilder->getQuery()->execute();
    }
}