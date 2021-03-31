<?php
namespace Softserve\Seller\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;

class NewSellerPatch implements DataPatchInterface
{
    /**
     * @var Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
       \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Add softserve seller to db
     */
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
