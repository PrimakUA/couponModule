<?php

namespace Coupon\Target\Setup;

use Coupon\Target\Setup\SetupService\CreateCartPriceRuleService;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 */
class InstallData implements InstallDataInterface
{
    /**
     * Create Cart Price Rule Service
     *
     * @var CreateCartPriceRuleService
     */
    protected $createCartPriceRuleService;

    /**
     * InstallData constructor
     *
     * @param CreateCartPriceRuleService $createCartPriceRuleService
     */

    public function __construct(CreateCartPriceRuleService $createCartPriceRuleService)
    {
        $this->createCartPriceRuleService = $createCartPriceRuleService;
    }

    /**
     * @inheritdoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createCartPriceRuleService->execute('five', 5, '5% for All customers');
        $this->createCartPriceRuleService->execute('twenty', 20, '20% for register User who send link');
    }
}