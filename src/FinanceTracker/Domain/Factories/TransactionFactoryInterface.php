<?php
namespace FinanceTracker\Domain\Factories;
/**
 *
 */
interface TransactionFactoryInterface
{
    /**
     * @param StdObject $object
     * @return mixed
     */
    public function fromObject(\stdClass $object);
}