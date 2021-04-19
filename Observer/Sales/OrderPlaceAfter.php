<?php
namespace Softserve\Seller\Observer\Sales;

class OrderPlaceAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;

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
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory,
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
     * @param \Magento\Framework\App\Request\Http $request,
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Magento\Framework\App\Request\Http $request,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    ) {
        $this->productFactory = $productFactory;
        $this->productCollection = $productCollection;
        $this->request = $request;
        $this->sellerRepository = $sellerRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }
    /**
     * Execute method.
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return $void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $sellersArray = [];
        foreach ($order->getItems() as $item) {
            $seller = $this->getSellerByItem($item);
            $sellersArray[] = $seller->getCode();
        }
        $sellerCode = implode(',', $sellersArray);
        $order->setSellerCodes($sellerCode);
        $this->orderRepository->save($order);
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
