<?php
namespace Softserve\Seller\ViewModel;

class SellerSuccess implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const CODE = 'code';

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Softserve\Seller\Api\SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    protected $productResource;

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
     * @param \Magento\Catalog\Model\ResourceModel\Product $productResource
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Magento\Catalog\Model\ResourceModel\Product $productResource
    ) {
        $this->productRepository = $productRepository;
        $this->checkoutSession = $checkoutSession;
        $this->sellerRepository = $sellerRepository;
        $this->productResource = $productResource;
    }

    /**
     * Retrieve all sellers
     * @return array
     */
    public function getSellers()
    {
        $orderItems = $this->getOrderItems();
        $sellers = [];
        $i = 0;
        foreach ($orderItems as $item) {
            $productId = $item->getProduct()->getId();
            $product = $this->productRepository->getById($productId);
            $attribute = $this->productResource->getAttribute('seller');
            $productAttrSeller = $product->getCustomAttribute('seller');
            if ($productAttrSeller) {
                $optionId = $productAttrSeller->getValue();
                try {
                    $sellers[$i] = $this->sellerRepository->get($attribute->getSource()->getOptionText($optionId));
                } catch (\Exception $e) {
                }
            }
            $i++;
        }
        return $sellers;
    }

    /**
     * Retrieve all items from last order
     * @return array
     */
    public function getOrderItems() 
    {
        $order = $this->checkoutSession->getLastRealOrder();
        return $order->getAllItems();
    }
}
