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
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollection;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Softserve\Seller\Api\SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Magento\Framework\App\Request\Http $request,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->productFactory = $productFactory;
        $this->productCollection = $productCollection;
        $this->request = $request;
        $this->sellerRepository = $sellerRepository;
        $this->productRepository = $productRepository;
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

    /**
     * Retrive seller
     * @return \Softserve\Seller\Api\Data\SellerInterface/bool
     */
    public function getSellerByItem($item)
    {
        $product = $this->productRepository->getById($item->getProductId());
        return $this->getSeller($product);
    }

    /**
     * Get Sellers array
     * @return array
     */
    public function getSellersArray($items)
    {
        $sellersArray = [];
        foreach ($items as $item) {
            $seller = $this->getSellerByItem($item);
            $sellersArray[$seller->getCode()] = [
                'code' => $seller->getCode(),
                'name' => $seller->getName(),
                'logo' => $seller->getLogo()
            ];
        }
        return $sellersArray;
    }
}
