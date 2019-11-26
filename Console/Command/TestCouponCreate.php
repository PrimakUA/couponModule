<?php


namespace Coupon\Target\Console\Command;

use Coupon\Target\Service\GenerateCouponCodesService;
use Coupon\Target\Setup\SetupService\CreateCartPriceRuleService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class TestCouponCreate extends Command
{
    private $generateCouponCodes;

    public function __construct(GenerateCouponCodesService $generateCouponCodes, string $name = null)
    {
        parent::__construct($name);
        $this->generateCouponCodes = $generateCouponCodes;
    }

    protected function configure()
    {
        $this->setName('coupon:create')->setDescription('Test coupon Create');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = ['length' => 10, 'prefix' => 'COMMAND-'];
        $this->generateCouponCodes->execute(10, $params);
        $output->writeln("Done!");

    }
}