<?php
namespace FinanceTracker\Domain\Factories;
use FinanceTracker\Domain\Factories\TransactionFactoryInterface;
use FinanceTracker\Domain\Entities\Transaction;
use FinanceTracker\Domain\Entities\Tag;
use FinanceTracker\Domain\Repositories\FinanceTrackerUnitOfWorkInterface;
use Svomz\Domain\Repositories\EntityNotFoundException;

class TransactionFactory implements TransactionFactoryInterface
{
    /**
     * @var \FinanceTracker\Domain\Repositories\FinanceTrackerUnitOfWorkInterface
     */
    protected $_financeTrackerUnitOfwork;

    /**
     * @param \FinanceTracker\Domain\Repositories\FinanceTrackerUnitOfWorkInterface $unitOfWork
     */
    public function __construct(FinanceTrackerUnitOfWorkInterface $unitOfWork)
    {
        $this->_financeTrackerUnitOfwork = $unitOfWork;
    }

    /**
     * @param StdObject $object
     * @return Transaction|mixed
     */
    public function fromObject(\stdClass $object)
    {
        $transaction = new Transaction();

        if (isset($object->description)) {
            $transaction->setDescription($object->description);
        }

        if (isset($object->date)) {
            $transaction->setDate($object->date);
        }

        if (isset($object->amount)) {
            $transaction->setAmount($object->amount);
        }

        if (!isset($object->tags)) {
            return $transaction;
        }

        foreach ($object->tags as $tagName) {
            try {
                $tag = $this->_getUnitOfWork()->getTagRepository()
                    ->findByName($tagName);
                $transaction->addTag($tag);
            } catch (EntityNotFoundException $exception) {
                $tag = new Tag();
                $tag->setName($tagName);
                $transaction->addTag($tag);
            }
        }
        return $transaction;
    }

    /**
     * @return \FinanceTracker\Domain\Repositories\FinanceTrackerUnitOfWorkInterface
     */
    protected function _getUnitOfWork()
    {
        return $this->_financeTrackerUnitOfwork;
    }
}