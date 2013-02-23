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
}