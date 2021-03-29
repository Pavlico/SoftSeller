<?php
namespace Softserve\Seller\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class SellerIdsPatch implements SchemaPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    public function __construct(
       ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $connection = $this->moduleDataSetup->getConnection();
 
        $connection->addColumn(
            $this->moduleDataSetup->getTable('sales_order'),
            'seller_ids',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'comment'  => 'Seller ids',
            ]
        );

        $connection->addColumn(
            $this->moduleDataSetup->getTable('sales_order_grid'),
            'seller_ids',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'comment'  => 'Seller ids',
            ]
        );
 
        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
