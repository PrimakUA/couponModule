<?php

namespace Coupon\Target\Setup;

use Coupon\Target\Setup\SetupService\CreateCartPriceRuleService;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class InstallData implements InstallDataInterface
{

    protected $createCartPriceRuleService;


    public function __construct(CreateCartPriceRuleService $createCartPriceRuleService)
    {
        $this->createCartPriceRuleService = $createCartPriceRuleService;
    }


    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createCartPriceRuleService->execute();
    }
}
