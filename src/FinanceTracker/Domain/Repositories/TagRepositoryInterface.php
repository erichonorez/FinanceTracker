<?php
namespace FinanceTracker\Domain\Repositories;
use \Svomz\Domain\Repositories\RepositoryInterface;

/**
 * Defines what a TagRepository has to implement
 */
interface TagRepositoryInterface extends RepositoryInterface
{
    public function findByName($name);
}