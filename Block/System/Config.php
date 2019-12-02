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

    public function saveCfg($name, $value)
    {

        $this->configWriter->save("sale/rule/$name", $value,
            $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }

    public function getCustomConfigValueForGuest()
    {
        return $this->_scopeConfig->getValue(
            'target/general/value',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getCustomConfigValueForRegistered()
    {
        return $this->_scopeConfig->getValue(
            'target/general/value2',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}