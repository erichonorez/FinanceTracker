<?php
namespace Svomz\Domain\Repositories;
/**
 * Interface defining what a repository should implement.
 * According to the Domain Driven Design a repository contains logic to
 * retrieve and add domain entities from the persistence layer.
 */
interface RepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     * @throw EntityNotFoundException
     */
    public function find($id);

    /**
     * @param $entity
     * @return RepositoryInterface
     */
    public function add($entity);

    /**
     * @param $entity
     * @return RepositoryInterface
     */
    public function remove($entity);

    /**
     * @return Iterator
     */
    public function findAll();
}