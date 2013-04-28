<?php
namespace FinanceTracker\Domain\Repositories\Transaction;

class TransactionSearchCriteria implements TransactionSearchCriteriaInterface
{
    /**
     *
     */
    const DATE_FORMAT = 'd-m-Y';
    /**
     *
     */
    const START_DATE = '01-01-1978';
    /**
     *
     */
    const END_DATE = '01-01-2200';
    /**
     * @var
     */
    protected $_startDate;
    /**
     * @var
     */
    protected $_endDate;
    /**
     * @var
     */
    protected $_tags;
    /**
     * @var
     */
    protected $_transactionType;
    /**
     * @var array
     */
    private $_validTransactionTypes = array(
        TransactionSearchCriteriaInterface::TRANSACTION_TYPE_ALL,
        TransactionSearchCriteriaInterface::TRANSACTION_TYPE_EXPENSE,
        TransactionSearchCriteriaInterface::TRANSACTION_TYPE_INCOME
    );

    /**
     *
     */
    private function _init()
    {
        $this->_startDate = \DateTime::createFromFormat(
            self::DATE_FORMAT, self::START_DATE
        );
        $this->_endDate = \DateTime::createFromFormat(
            self::DATE_FORMAT, self::END_DATE
        );
        $this->_tags = array();
        $this->_transactionType = self::TRANSACTION_TYPE_ALL;
    }

    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->_init();

        if (array_key_exists('startDate', $params) && $params['startDate']) {
            try {
                $this->_startDate  = \DateTime::createFromFormat(
                    self::DATE_FORMAT, $params['startDate']
                );
            } catch (Exception $ex) {
                $this->_startDate = \DateTime::createFromFormat(
                    self::DATE_FORMAT, self::START_DATE
                );
            }
        }

        if (array_key_exists('endDate', $params) && $params['endDate']) {
            try {
                $this->_endDate  = \DateTime::createFromFormat(
                    self::DATE_FORMAT, $params['endDate']
                );
            } catch (Exception $ex) {
                $this->_endDate = \DateTime::createFromFormat(
                    self::DATE_FORMAT, self::END_DATE
                );
            }
        }
        if (array_key_exists('tags', $params)
            && is_array($params['tags'])) {
            $this->_tags = $params['tags'];
        }

        if (array_key_exists('transactionType', $params)
            && in_array($params['transactionType'], $this->_validTransactionTypes)
        ) {
            $this->_transactionType = $params['transactionType'];
        }
    }
    /**
     * @param \DateTime $startDate
     * @return mixed
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->_startDate = $startDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->_startDate;
    }

    /**
     * @param \DateTime $endDate
     * @return mixed
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->_endDate = $endDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->_endDate;
    }

    /**
     * @param array $tags
     * @return mixed
     */
    public function setTags(array $tags)
    {
        $this->_tags = $tags;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->_tags;
    }

    /**
     * @return mixed
     */
    public function setTransactionType($transactionType)
    {
        if (in_array($transactionType, $this->_validTransactionTypes)) {
            $this->_transactionType = $transactionType;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionType()
    {
        return $this->_transactionType;
    }
}