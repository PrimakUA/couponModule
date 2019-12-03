<?php

namespace Coupon\Target\Block;


use Coupon\Target\Service\CouponService;
use Magento\Framework\View\Element\Template;


class Component extends Template
{
    /**
     * @var CouponService
     */
    private $service;

    public function __construct
    (
        Template\Context $context,
        CouponService $couponService,
        array $data = []
    )

    {
        $this->service = $couponService;
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