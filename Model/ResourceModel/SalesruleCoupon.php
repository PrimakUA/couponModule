<?php

namespace Coupon\Target\Model\ResourceModel;
//тут ресурс модель для доставания из таблицы купонов. нужна ещё одна  модель для таблицы customer entity чтобы доставать из неё entity_id
class SalesruleCoupon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('salesrule_coupon', 'coupon_id');
    }

}
