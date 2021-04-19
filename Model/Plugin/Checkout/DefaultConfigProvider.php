<?php
namespace Softserve\Seller\Model\Plugin\Checkout;

class DefaultConfigProvider
{
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
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
     * @param \Magento\Catalog\Model\ResourceModel\Product $productResource
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Magento\Catalog\Model\ResourceModel\Product $productResource,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->sellerRepository = $sellerRepository;
        $this->productResource = $productResource;
        $this->productRepository = $productRepository;
    }

    public function afterGetConfig(
        \Magento\Checkout\Model\DefaultConfigProvider $subject,
        array $result
    ) {
        $items = $result['totalsData']['items'];
        foreach ($items as $index => $item) {
            $quoteItem = $this->checkoutSession->getQuote()->getItemById($item['item_id']);
            $productId = $quoteItem->getProduct()->getId();
            $product = $this->productRepository->getById($productId);
            $attribute = $this->productResource->getAttribute('seller');
            $productAttrSeller = $product->getCustomAttribute('seller');
            if ($productAttrSeller) {
                $optionId = $productAttrSeller->getValue();
                try {
                    $seller = $this->sellerRepository->get($attribute->getSource()->getOptionText($optionId));
                } catch (\Exception $e) {
                    return $result;
                }
                $result['quoteItemData'][$index]['seller'] = $seller->getName() . ' (' . $seller->getCode() . ')';
            }
        }
        return $result;
    }
}
