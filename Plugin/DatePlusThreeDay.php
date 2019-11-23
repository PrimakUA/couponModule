<?php


namespace Coupon\Target\Plugin;


class DatePlusThreeDay
{
    public function afterGetToDate(\Magento\SalesRule\Model\Rule $rule)
    {

        if ($rule->getName() == 'five')
        {
            $date = strtotime("+3 day");
            $dat = date("Y-m-d H:i:s", $date);
            return $dat;
        }
        elseif ($rule->getName() == 'twenty')
        {
            $date = strtotime("+1 day");
            $dat = date("Y-m-d H:i:s", $date);
            return $dat;
        }
        else
            $ret = $rule->getData();
            return $ret['to_date'];
    }

}