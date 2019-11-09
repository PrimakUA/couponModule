<?php

namespace Coupon\Target\Service;

use Magento\SalesRule\Model\CouponGenerator;

class GenerateCouponService
{
    protected $couponGenerator;


    public function __construct(CouponGenerator $couponGenerator)
    {
        $this->couponGenerator = $couponGenerator;
    }


    public function execute(int $qty, int $ruleId, array $params = []): void
    {
        if (!$qty || !$ruleId) {
            return;
        }

        $params['rule_id'] = $ruleId;
        $params['qty'] = $qty;

        $this->couponGenerator->generateCodes($params);
    }
}