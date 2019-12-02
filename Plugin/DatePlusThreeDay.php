<?php


namespace Coupon\Target\Plugin;


use Coupon\Target\Block\System\Config;

class DatePlusThreeDay
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function afterGetToDate(\Magento\SalesRule\Model\Rule $subject, $result)
    {
        $result = $subject->getData();

        if ($subject->getId() == $this->config->getRuleId('five') || $subject->getId() == $this->config->getRuleId('twenty')) {
            if ($subject->getId() == $this->config->getRuleId('five')) {
                $thre = $this->config->getDate(1);
                $date = strtotime("+$thre day");
                $dat = date("Y-m-d H:i:s", $date);
                return $dat;
            } else {
                $one = $this->config->getDate(2);
                $date = strtotime("+$one day");
                $dat = date("Y-m-d H:i:s", $date);
                return $dat;
            }
        } else
            return $result['to_date'];
    }
}