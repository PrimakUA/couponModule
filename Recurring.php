<?php


namespace Coupon\Target\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class Recurring implements InstallSchemaInterface

{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
{
    $setup->startSetup();
    $tableName = 'coupon_target_coupons';
    $table = $setup->getConnection()->newTable($setup->getTable($tableName));

    $table->addColumn('id', Table::TYPE_INTEGER, null, [
        'primary' => true,
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
    ]);

    $table->addColumn('coupon_id', Table::TYPE_INTEGER, null, [
        'unsigned' => true,
    ]);
    $table->addForeignKey(
        $setup->getFkName($tableName, 'coupon_id', 'salesrule_coupon', 'coupon_id'),
        'coupon_id',
        'salesrule_coupon',
        'coupon_id',
        AdapterInterface::FK_ACTION_CASCADE
    );

    $table->addColumn('coupon', Table::TYPE_TEXT, 124, [
        'nullable' => false,
    ]);

    $table->addColumn('entity_id', Table::TYPE_INTEGER, 10, [
        'unsigned' => true,
    ]);
    $table->addForeignKey(
        $setup->getFkName($tableName, 'entity_id', 'customer_entity', 'entity_id'),
        'entity_id',
        'customer_entity',
        'entity_id',
        AdapterInterface::FK_ACTION_CASCADE
    );
    $setup->getConnection()->createTable($table);
    $setup->endSetup();
}
}