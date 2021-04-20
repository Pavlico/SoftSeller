<?php
namespace Softserve\Seller\Block\Customer;

class Sellers extends \Magento\Framework\View\Element\Template
{
    protected $sellersArray = [];
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    protected $orderConfig;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Softserve\Seller\Api\SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Sales\Model\Order\Config $orderConfig
     * @param \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->customerSession = $customerSession;
        $this->orderConfig = $orderConfig;
        $this->productFactory = $productFactory;
        $this->sellerRepository = $sellerRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Get customer orders
     *
     * @return bool|\Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getOrders($customerId)
    {
        if (!$this->orders) {
            $this->orders = $this->orderCollectionFactory->create($customerId)->addFieldToSelect(
                '*'
            )->addFieldToFilter(
                'status',
                ['in' => $this->orderConfig->getVisibleOnFrontStatuses()]
            )->setOrder(
                'created_at',
                'desc'
            );
        }
        return $this->orders;
    }

    /**
     * Retrive seller
     * @return \Softserve\Seller\Api\Data\SellerInterface/bool
     */
    public function getSellers($orders)
    {
        if (!$orders) {
            return [];
        }
        foreach ($orders as $order) {
            $this->getSellersArray($order->getItems());
        }
        return $this->sellersArray;
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
        foreach ($items as $item) {
            $seller = $this->getSellerByItem($item);
            $this->sellersArray[$seller->getCode()] = [
                'code' => $seller->getCode(),
                'name' => $seller->getName(),
                'count' => array_key_exists($seller->getCode(), $this->sellersArray) ?
                    (int) $this->sellersArray[$seller->getCode()]['count'] + (int) $item->getQtyOrdered() : (int) $item->getQtyOrdered()
            ];
        }
        return $this->sellersArray;
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
