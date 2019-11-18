<?php


namespace Coupon\Target\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface

{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        echo __METHOD__ .PHP_EOL;
    }
}
