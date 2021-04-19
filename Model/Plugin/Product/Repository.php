<?php
namespace Softserve\Seller\Model\Plugin\Product;

class Repository
{
    /** 
     * @var Magento\Catalog\Api\Data\ProductExtensionFactory 
     */
    private $productExtensionFactory;

    /** 
     * @var Softserve\Seller\Api\SellerProductRepositoryInterface
     */
    private $sellerProductInterface;

    /** 
     * @var Softserve\Seller\Helper\Configuration 
     */
    private $configuration;

    /** 
     * @var Magento\Catalog\Model\ResourceModel\ProductFactory
     */
    private $productFactory;

    /**
     * @param \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory
     * @param \Softserve\Seller\Api\SellerProductRepositoryInterface $sellerProductInterface
     * @param \Softserve\Seller\Helper\Configuration $configuration
     * @param \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory
     */
    public function __construct(
        \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory,
        \Softserve\Seller\Api\SellerProductRepositoryInterface $sellerProductInterface,
        \Softserve\Seller\Helper\Configuration $configuration,
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory
    ) {
        $this->productExtensionFactory = $productExtensionFactory;
        $this->sellerProductInterface = $sellerProductInterface;
        $this->configuration = $configuration;
        $this->productFactory = $productFactory;
    }

    /**
     * Add Social Links to product extension attributes
     *
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function afterGetList(
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Framework\Api\SearchResults $searchResult
    ) {
        if (!$this->configuration->getApiEnabled()) {
            return $searchResult;
        }
        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        foreach ($searchResult->getItems() as $product) {
            $this->addSellerData($product);
        }

        return $searchResult;
    }

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function afterGet(
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Catalog\Api\Data\ProductInterface $product
    ) {
        if (!$this->configuration->getApiEnabled()) {
            return $product;
        }
        $this->addSellerData($product);
        return $product;
    }
    
    /**
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return self
     */
    private function addSellerData(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        $extensionAttributes = $product->getExtensionAttributes(); 
        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->productExtensionFactory->create();
        }
        $poductReource = $this->productFactory->create();
        $attribute = $poductReource->getAttribute('seller');
        $productAttrSeller = $product->getCustomAttribute('seller');
        if ($productAttrSeller) {
            $optionId = $productAttrSeller->getValue();
            $seller = $this->sellerProductInterface->get($attribute->getSource()->getOptionText($optionId));
            $extensionAttributes->setSeller($seller);
            $product->setExtensionAttributes($extensionAttributes);
        }
        return $this;
    }
}
