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
    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct(
            $context,
            $data
        );
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