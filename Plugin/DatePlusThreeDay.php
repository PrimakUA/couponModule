<?php


namespace Coupon\Target\Plugin;


class DatePlusThreeDay
{
    public function afterGetToDate(\Magento\SalesRule\Model\Rule $subject, $result)
    {
        $result = $subject->getData();
        if ($subject->getName() == 'five' || $subject->getName() == 'twenty') {
            if ($subject->getName() == 'five') {
                $date = strtotime("+3 day");
                $dat = date("Y-m-d H:i:s", $date);
                return $dat;
            } else {
                $date = strtotime("+1 day");
                $dat = date("Y-m-d H:i:s", $date);
                return $dat;
            }
        } else
            return $result['to_date'];
    }
}