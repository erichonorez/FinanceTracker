<?php
namespace FinanceTracker\Domain\Entities;
use \Doctrine\Common\Collections\ArrayCollection;
/**
 * Created by JetBrains PhpStorm.
 * User: Eric
 * Date: 17/02/13
 * Time: 17:58
 * To change this template use File | Settings | File Templates.
 */
class Transaction implements \JsonSerializable
{
    /**
     * @var int
     */
    protected $_transactionId;
    /**
     * @var string
     */
    protected $_description;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $_tags;
    /**
     * @var \DateTime
     */
    protected $_date;
    /**
     * @var int
     */
    protected $_amount;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_date = new \DateTime();
        $this->_tags = new ArrayCollection();
    }

    /**
     * @param $date
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->_date = $date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * @param $description
     * @return Transaction
     */
    public function setDescription($description)
    {
        $this->_description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->_transactionId;
    }

    /**
     * @param $tag
     * @return Transaction
     */
    public function addTag(Tag $tag)
    {
        if (!$this->_tags->contains($tag)) {
            $this->_tags->add($tag);
        }
        return $this;
    }

    /**
     * @param $tag
     * @return Transaction
     */
    public function removeTag(Tag $tag)
    {
        $this->_tags->removeElement($tag);
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTags()
    {
        return $this->_tags;
    }

    /**
     * @return boolean
     */
    public function isTagged($tagName)
    {
        foreach ($this->_tags as $tag) {
            if ($tag->getName() == $tagName) {
                return true;
            }
        }
        return false;
    }

    /**
     */
    public function untag($tagName)
    {
        $tagToRemove = null;
        foreach ($this->_tags as $tag) {
            if ($tag->getName() == $tagName) {
                $tagToRemove = $tag;
                break;
            }
        }
        if ($tagToRemove) {
            $this->removeTag($tagToRemove);
        }
        return $this;
    }

    /**
     * @param  $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @return bool
     */
    public function isExpense()
    {
        return $this->getAmount() < 0;
    }

    /**
     * @return bool
     */
    public function isIncome()
    {
        return $this->getAmount() > 0;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "transactionId" => $this->getTransactionId(),
            "description" => $this->getDescription(),
            "amount" => $this->getAmount(),
            "date" => $this->_date->format('d-m-Y'),
            "tags" => $this->getTags()->toArray()
        ];
    }
}