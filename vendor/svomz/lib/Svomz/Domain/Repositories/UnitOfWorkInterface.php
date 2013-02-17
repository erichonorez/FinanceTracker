<?php
namespace Svomz\Domain\Repositories;
/**
 * Interface that defines what an unit of work should implement
 * @see Martin Fowler
 */
interface UnitOfWorkInterface
{
    /**
     * Save changes in the persistence layer
     *
     * @return UnitOfWorkInterface
     */
    public function commit();
}