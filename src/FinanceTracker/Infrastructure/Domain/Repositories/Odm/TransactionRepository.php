<?php
namespace FinanceTracker\Infrastructure\Domain\Repositories\Odm;
use FinanceTracker\Domain\Repositories\TransactionRepositoryInterface;
use Svomz\Domain\Repositories\EntityNotFoundException;
/**
 * Created by JetBrains PhpStorm.
 * User: Eric
 * Date: 17/02/13
 * Time: 20:16
 * To change this template use File | Settings | File Templates.
 */
class TransactionRepository extends AbstractOdmRepository implements TransactionRepositoryInterface
{
    public static $repositoryName = 'FinanceTracker\Domain\Entities\Transaction';
    /**
     * @see FinanceTracker\Domain\Repositories\TransactionRepositoryInterface
     */
    public function search(
        $startDate = null, $endDate = null, array $tags = array(), $transactionType = 0)
    {
        if ($endDate && $startDate > $endDate) {
            throw new \Exception();
        }

        $queryBuilder = $this->_getDocumentManager()
            ->createQueryBuilder($this->getRepositoryName());

        if ($startDate) {
            $queryBuilder->field('_date')->gte($startDate);
        }

        if ($endDate) {
            $queryBuilder->fied('_date')->lt($endDate);
        }

        if ($tags) {
            $tagIds = array();
            foreach ($tags as $tag) {
                $tagIds[] = new \MongoId($tag->getTagId());
            }
            $queryBuilder->field('_tags.$id')->all($tagIds);
        }

        switch ($transactionType) {
            case TransactionRepositoryInterface::TRANSACTION_TYPE_EXPENSE:
                $queryBuilder->field('_amount')->lt(0);
                break;
            case TransactionRepositoryInterface::TRANSACTION_TYPE_INCOME:
                $queryBuilder->field('_amount')->gt(0);
                break;
        }

        return $queryBuilder->getQuery()->execute();
    }
}