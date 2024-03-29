<?php

namespace Coupon\Target\Setup\SetupService;

use Coupon\Target\Block\System\Config;
use Exception;
use Magento\Backend\App\Area\FrontNameResolver as BackendFrontNameResolver;
use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroupCollection;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as CustomerGroupCollectionFactory;
use Magento\Framework\App\State as AppState;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Api\Data\RuleInterfaceFactory;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CreateCartPriceRuleService
 */
class CreateCartPriceRuleService
{
    /**
     * Rule Repository
     *
     * @var RuleRepositoryInterface
     */
    protected $ruleRepository;
    /**
     * Store Manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * Catalog Price Rule Factory
     *
     * @var RuleInterfaceFactory
     */
    protected $cartPriceRuleFactory;
    /**
     * Customer Group Collection Factory
     *
     * @var CustomerGroupCollectionFactory
     */
    protected $customerGroupCollectionFactory;
    /**
     * App State
     *
     * @var AppState
     */
    protected $appState;

    protected $config;

    /**
     * CreateCartPriceRuleService constructor
     *
     * @param RuleRepositoryInterface $ruleRepository
     * @param StoreManagerInterface $storeManager
     * @param AppState $appState
     * @param RuleInterfaceFactory $cartPriceRuleFactory
     * @param CustomerGroupCollectionFactory $customerGroupCollectionFactory
     * @param Config $config
     */
    public function __construct(
        RuleRepositoryInterface $ruleRepository,
        StoreManagerInterface $storeManager,
        AppState $appState,
        RuleInterfaceFactory $cartPriceRuleFactory,
        CustomerGroupCollectionFactory $customerGroupCollectionFactory,
        Config $config
    )
    {
        $this->ruleRepository = $ruleRepository;
        $this->storeManager = $storeManager;
        $this->appState = $appState;
        $this->cartPriceRuleFactory = $cartPriceRuleFactory;
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
        $this->config = $config;
    }

    /**
     * Create cart price rule and generate coupon codes
     *
     * @return void
     *
     * @throws Exception
     */
    public function execute($name, $discountAmount, $description)
    {
        $customerGroupIds = $this->getAvailableCustomerGroupIds();
        $websiteIds = $this->getAvailableWebsiteIds();
        /** @var RuleInterface $cartPriceRule */
        $cartPriceRule = $this->cartPriceRuleFactory->create();
        $cartPriceRule->setName($name);
        $cartPriceRule->setDescription($description);
        $cartPriceRule->setIsActive(true);
        $cartPriceRule->setCouponType(RuleInterface::COUPON_TYPE_SPECIFIC_COUPON);
        $cartPriceRule->setCustomerGroupIds($customerGroupIds);
        $cartPriceRule->setWebsiteIds($websiteIds);
        $cartPriceRule->setUsesPerCustomer(1);
        $cartPriceRule->setUsesPerCoupon(1);
        $cartPriceRule->setDiscountAmount($discountAmount);
        $cartPriceRule->setSimpleAction(RuleInterface::DISCOUNT_ACTION_BY_PERCENT);
        $cartPriceRule->setUseAutoGeneration(true);
        $savedCartPriceRule = $this->appState->emulateAreaCode(
            BackendFrontNameResolver::AREA_CODE,
            [$this->ruleRepository, 'save'],
            [$cartPriceRule]
        );
        $ruleId = (int)$savedCartPriceRule->getRuleId();
        $this->config->saveRuleId($name, $ruleId);
        $this->config->saveDate($name);
        $this->config->saveValue($name, $discountAmount);

    }

    /**
     * Get all available customer group IDs
     *
     * @return int[]
     */
    protected function getAvailableCustomerGroupIds()
    {
        /** @var CustomerGroupCollection $collection */
        $collection = $this->customerGroupCollectionFactory->create();
        $collection->addFieldToSelect('customer_group_id');
        $customerGroupIds = $collection->getAllIds();
        return $customerGroupIds;
    }

    /**
     * Get all available website IDs
     *
     * @return int[]
     */
    protected function getAvailableWebsiteIds()
    {
        $websiteIds = [];
        $websites = $this->storeManager->getWebsites();
        foreach ($websites as $website) {
            $websiteIds[] = $website->getId();
        }
        return $websiteIds;
    }
}