<?php
namespace Softserve\Seller\ViewModel;

class SellerProducts implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const CODE = 'code';
    /**
     * @var \Magento\Catalog\Model\ResourceModel\ProductFactory
     */
    protected $productFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Magento\Framework\App\Request\Http $request,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
    ) {
        $this->productFactory = $productFactory;
        $this->productCollection = $productCollection;
        $this->request = $request;
        $this->sellerRepository = $sellerRepository;
    }

    /**
     * Retrieve products
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getSellerProducts()
    {
        $productResource = $this->productFactory->create();
        $attribute = $productResource->getAttribute('seller');
        $optionId = $attribute->getSource()->getOptionId($this->request->getParam(self::CODE));
        $collection = $this->productCollection->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('seller', $optionId);
        $collection->setPageSize(10);
        $collection->setCurPage(1);
        return $collection;
    }

    /**
     * Retrive seller
     * @return \Softserve\Seller\Api\Data\SellerInterface/bool
     */
    public function getSeller($product)
    {
        $productResource = $this->productFactory->create();
        $attribute = $productResource->getAttribute('seller');
        $productAttrSeller = $product->getCustomAttribute('seller');
        if ($productAttrSeller) {
            $optionId = $productAttrSeller->getValue();
            try {
                $seller = $this->sellerRepository->get($attribute->getSource()->getOptionText($optionId));
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                return false;
            }
            return $seller;
        }
        return false;
    }
}
