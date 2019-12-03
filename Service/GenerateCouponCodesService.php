<?php

namespace Coupon\Target\Service;

use Magento\SalesRule\Model\CouponGenerator;
use Coupon\Target\Model\CouponTargetCouponsRepository;
/**
 * Class GenerateCouponListService
 */
class GenerateCouponCodesService
{
    /**
     * Coupon Generator
     *
     * @var CouponGenerator
     */
    protected $couponGenerator;

    public $couponRepository;
    /**
     * GenerateCouponCodesService constructor
     *
     * @param CouponGenerator $couponGenerator
     */

    public function __construct(CouponGenerator $couponGenerator, CouponTargetCouponsRepository $couponRepository)
    {
        $this->couponGenerator = $couponGenerator;
        $this->couponRepository = $couponRepository;
    }
    /**
     * Generate coupon list for specified cart price rule
     *
     * @param int|null $ruleId
     * @param array $params
     *
     * @return void
     */
    public function execute(int $ruleId, array $params = []): void
    {
        if (!$ruleId) {
            return;
        }
        $params['rule_id'] = $ruleId;
        $params['qty'] = 1;
        $this->couponGenerator->generateCodes($params);
//        тут мы достаем из нашей таблицы данные, но надо доставать их из таблиц мадженты сейлзрул купон и кастомер ентити
        $a = $this->couponRepository->getById(1);
        die(var_dump($a));
    }
}