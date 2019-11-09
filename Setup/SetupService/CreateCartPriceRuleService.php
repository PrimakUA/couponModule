<?php

namespace Coupon\Target\Setup\SetupService;

use Coupon\Target\Service\GenerateCouponService;
use Exception;
use Magento\Backend\App\Area\FrontNameResolver as BackendFrontNameResolver;
use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroupCollection;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as CustomerGroupCollectionFactory;
use Magento\Framework\App\State as AppState;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Api\Data\RuleInterfaceFactory;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;


class CreateCartPriceRuleService
{
    const INITIAL_COUPON_CODES_QTY = 1;

    const LENGTH = 20;

    const PREFIX = 'Primak-';

    protected $generateCouponService;

    protected $ruleRepository;

    protected $storeManager;

    protected $cartPriceRuleFactory;

    protected $customerGroupCollectionFactory;

    protected $appState;

    public function __construct(
        GenerateCouponService $generateCouponService,
        RuleRepositoryInterface $ruleRepository,
        StoreManagerInterface $storeManager,
        AppState $appState,
        RuleInterfaceFactory $cartPriceRuleFactory,
        CustomerGroupCollectionFactory $customerGroupCollectionFactory
    )
    {
        $this->generateCouponService = $generateCouponService;
        $this->ruleRepository = $ruleRepository;
        $this->storeManager = $storeManager;
        $this->appState = $appState;
        $this->cartPriceRuleFactory = $cartPriceRuleFactory;
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
    }


    public function execute()
    {
        $customerGroupIds = $this->getAvailableCustomerGroupIds();
        $websiteIds = $this->getAvailableWebsiteIds();


        $cartPriceRule = $this->cartPriceRuleFactory->create();

        // Set the required parameters.
        $cartPriceRule->setName('Cart Price Rule Target');
        $cartPriceRule->setIsActive(true);
        $cartPriceRule->setCouponType(RuleInterface::COUPON_TYPE_SPECIFIC_COUPON);
        $cartPriceRule->setCustomerGroupIds($customerGroupIds);
        $cartPriceRule->setWebsiteIds($websiteIds);

        // Set the usage limit per customer.
        $cartPriceRule->setUsesPerCustomer(1);

        // Make the multiple coupon codes generation possible.
        $cartPriceRule->setUseAutoGeneration(true);

        // We need to set the area code due to the existent implementation of RuleRepository.
        // The specific area need to be emulated while running the RuleRepository::save method from CLI in order to
        // avoid the corresponding error ("Area code is not set").
        $savedCartPriceRule = $this->appState->emulateAreaCode(
            BackendFrontNameResolver::AREA_CODE,
            [$this->ruleRepository, 'save'],
            [$cartPriceRule]
        );

        // Generate and assign coupon codes to the newly created Cart Price Rule.
        $ruleId = (int)$savedCartPriceRule->getRuleId();
        $params = ['length' => self::LENGTH, 'prefix' => self::PREFIX];
        $this->generateCouponService->execute(self::INITIAL_COUPON_CODES_QTY, $ruleId, $params);
    }


    protected function getAvailableCustomerGroupIds()
    {

        $collection = $this->customerGroupCollectionFactory->create();
        $collection->addFieldToSelect('customer_group_id');
        $customerGroupIds = $collection->getAllIds();

        return $customerGroupIds;
    }


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