<?php
namespace Softserve\Seller\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;

class ProductAttributePatch implements DataPatchInterface
{
    const SOFTSERVE = 'Softserve';
    /** 
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /** 
     * @var Magento\Eav\Setup\EavSetupFactory 
     */
    private $eavSetupFactory;

    /** 
     * @var Magento\Eav\Model\Entity\Attribute\OptionFactory 
     */
    private $optionFactory;

    /** 
     * @var Magento\Eav\Api\AttributeOptionManagementInterface
     */
    private $attributeOptionManagement;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param \Magento\Eav\Model\Entity\Attribute\OptionFactory $optionFactory
     * @param \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Entity\Attribute\OptionFactory $optionFactory,
        \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->optionFactory = $optionFactory;
        $this->attributeOptionManagement = $attributeOptionManagement;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'seller', [
            'type' => 'varchar',
            'label' => 'Seller',
            'input' => 'select',
            'visible_on_front' => true,
            'user_defined' => true,
            'visible' => true,
            'filterable' => true,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'used_in_product_listing' => true,
            'is_filterable_in_grid' => true,
            'required' => true,
            'group' => 'General',
        ]);
        $option = $this->optionFactory->create();
        $option->setLabel(self::SOFTSERVE);
        $option->setSortOrder(0);
        $option->setIsDefault(true);
        $this->attributeOptionManagement->add(
            \Magento\Catalog\Model\Product::ENTITY,
            'seller',
            $option
        );
        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'seller_description', [
            'type' => 'text',
            'label' => 'Seller Description',
            'input' => 'text',
            'visible_on_front' => true,
            'user_defined' => true,
            'visible' => true,
            'required' => false,
            'group' => 'General'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
