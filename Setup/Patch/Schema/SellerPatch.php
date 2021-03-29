<?php
namespace Softserve\Seller\Setup\Patch\Schema;

use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class SellerPatch implements SchemaPatchInterface
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

    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();
        $data[] = [
            'code' => 'softserve',
            'name' => 'Soft serve',
            'link' => 'Link',
            'logo' => 'softserve.jpg',
            'description' => 'Description for seller',
            'contact info' => 'Phone number',
        ];

         $this->moduleDataSetup->getConnection()->insertArray(
            $this->moduleDataSetup->getTable('seller'),
            ['code', 'name', 'link', 'logo', 'description', 'contact_info'],
            $data
        );     
        $this->moduleDataSetup->endSetup();
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}
