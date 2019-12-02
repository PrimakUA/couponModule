<?php

namespace Coupon\Target\Block\System;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 * @package Coupon\Target\Block\System
 */
class Config extends Template
{
    /**
     * Config constructor.
     *
     * @param Context $context
     * @param array $data
     */

    protected $configWriter;

    public function __construct(
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        Context $context,
        array $data = []
    )
    {

        parent::__construct(
            $context,
            $data
        );
        $this->configWriter = $configWriter;
    }

    public function saveRuleId($name, $value)
    {

        $this->configWriter->save("sale/rule/$name", $value,
            $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }

    public function getRuleId($value)
    {
        return $this->_scopeConfig->getValue(
            "sale/rule/$value",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function saveValue($name, $value)
    {
        if ($name == 'five'){
            $num = 1;
        }else {
            $num = 2;
        }

        $this->configWriter->save("target/general/value$num", $value,
            $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }

    public function saveDate($name)
    {
        if ($name == 'five'){
            $num = 1;
            $value = 3;
        }else {
            $num = 2;
            $value = 1;
        }
        $this->configWriter->save("target/general/time$num", $value,
            $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }

    public function getDate($number)
    {
        return $this->_scopeConfig->getValue(
            "target/general/time$number",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getValue($number)
    {
        return $this->_scopeConfig->getValue(
            "target/general/value$number",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}