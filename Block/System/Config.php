<?php

namespace Coupon\Target\Block\System;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @package Coupon\Target\Block\System
 */
class Config extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     *
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        parent::__construct(
            $context,
            $data
        );
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param string|null $storeId
     *
     * @return mixed
     */
    public function getCustomConfig(?string $storeId = null)
    {
        return $this->scopeConfig->getValue(
            'coupon/target/value',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

}