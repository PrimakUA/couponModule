<?php

namespace Coupon\Target\Block;


use Coupon\Target\Block\System\Config;
use Coupon\Target\Service\CouponService;
use Magento\Framework\View\Element\Template;


class Component extends Template
{
    /**
     * @var CouponService
     */
    private $service;
    public $config;

    public function __construct
    (
        Template\Context $context,
        CouponService $couponService,
        Config $config,
        array $data = []
    )

    {
        $this->service = $couponService;
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed|string|null
     */
    public function getCouponCode()
    {
        return $this->service->getCouponCode();
    }
}