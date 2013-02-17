<?php
namespace FinanceTracker\Infrastructure\Domain\Repositories\Odm;
use Svomz\Domain\Repositories\RepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
/**
 * Created by JetBrains PhpStorm.
 * User: Eric
 * Date: 17/02/13
 * Time: 20:18
 * To change this template use File | Settings | File Templates.
 */
abstract class AbstractOdmRepository implements RepositoryInterface
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
     * @param $id
     * @return mixed
     * @throw EntityNotFoundException
     */
    public function find($id)
    {
        $transaction = $this->_getDocumentManager()
            ->getRepository(static::$repositoryName)
            ->find($id);
        if (!$transaction) {
            throw new EntityNotFoundException();
        }
        return $transaction;
    }

    /**
     * @param $entity
     * @return RepositoryInterface
     */
    public function add($entity)
    {
        $this->_documentManager->persist($entity);
        return $this;
    }

    /**
     * @param $entity
     * @return RepositoryInterface
     */
    public function remove($entity)
    {
        $this->_documentManager->remove($entity);
        return $this;
    }

    /**
     * @return Iterator
     */
    public function findAll()
    {
        return $this->_documentManager
            ->getRepository(static::$repositoryName)
            ->findAll();
    }

    /**
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected function _getDocumentManager()
    {
        return $this->_documentManager;
    }
}
