<?php


namespace Coupon\Target\Plugin;


class DatePlusThreeDay
{
    public function afterGetToDate(\Magento\SalesRule\Model\Rule $rule)
    {
        $date = strtotime("+3 day");
        $dat = date("Y-m-d H:i:s", $date);

        return $dat;

    }
}