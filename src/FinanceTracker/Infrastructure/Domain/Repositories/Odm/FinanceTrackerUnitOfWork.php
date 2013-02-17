<?php
namespace FinanceTracker\Infrastructure\Domain\Repositories\Odm;
use FinanceTracker\Domain\Repositories\FinanceTrackerUnitOfWorkInterface;
use FinanceTracker\Domain\Repositories\TransactionRepositoryInterface;
/**
 * Created by JetBrains PhpStorm.
 * User: Eric
 * Date: 17/02/13
 * Time: 21:14
 * To change this template use File | Settings | File Templates.
 */
class FinanceTrackerUnitOfWork implements FinanceTrackerUnitOfWorkInterface
{
    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $_documentManager;

    /**
     * @var \FinanceTracker\Domain\Repositories\TransactionRepositoryInterface
     */
    protected $_transactionRepository;

    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $documentManager
     */
    public function __construct(
        DocumentManager $documentManager,
        TransactionRepositoryInterface $transactionRepository
    )
    {
        $this->_documentManager = $documentManager;
        $this->_transactionRepository = $transactionRepository;
    }

    /**
     * @return TransactionRepositoryInterface
     */
    public function getTransactionRepository()
    {
        return $this->_transactionRepository;
    }

    /**
     * Save changes in the persistence layer
     *
     * @return UnitOfWorkInterface
     */
    public function commit()
    {
        $this->_documentManager->flush();
        return $this;
    }
}
