<?php
namespace FinanceTracker\Infrastructure\Domain\Repositories\Odm;
use FinanceTracker\Domain\Repositories\TagRepositoryInterface;
use Svomz\Domain\Repositories\EntityNotFoundException;
/**
 * Created by JetBrains PhpStorm.
 * User: Eric
 * Date: 17/02/13
 * Time: 20:16
 * To change this template use File | Settings | File Templates.
 */
class TagRepository extends AbstractOdmRepository implements TagRepositoryInterface
{
    public static $repositoryName = 'FinanceTracker\Domain\Entities\Tag';
    /**
     * @see FinanceTracker\Domain\Repositories\TransactionRepositoryInterface
     */
    public function findByName($name)
    {
        $entity = $this->_getDocumentManager()
            ->getRepository($this->getRepositoryName())
            ->findOneBy(array('_name' => $name));

        if (!$entity) {
            throw new EntityNotFoundException();
        }
        return $entity;
    }
}