<?php
namespace FinanceTracker\Domain\Entities;
/**
 * Created by JetBrains PhpStorm.
 * User: Eric
 * Date: 17/02/13
 * Time: 18:19
 * To change this template use File | Settings | File Templates.
 */
class Tag
{
    /**
     * @var
     */
    protected $_name;

    /**
     * @param string $name
     */
    public function __construct($name = "")
    {
        if ($name) {
            $this->setName($name);
        }
    }

    /**
     * @param $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->_name = $this->_slugify($name);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param $value
     */
    private function _slugify($value)
    {
        // replace non letter or digits by -
        $value = preg_replace('~[^\\pL\d]+~u', '-', $value);

        // trim
        $value = trim($value, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $value = iconv('utf-8', 'us-ascii//TRANSLIT', $value);
        }

        // lowercase
        $value = strtolower($value);

        // remove unwanted characters
        $value = preg_replace('~[^-\w]+~', '', $value);

        if (empty($value))
        {
            return 'n-a';
        }

        return $value;
    }
}
