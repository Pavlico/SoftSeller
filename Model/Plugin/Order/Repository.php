<?php
namespace Softserve\Seller\Model\Plugin\Order;

class Repository
{
    /** 
     * @var Magento\Sales\Api\Data\OrderExtensionFactory
     */
    protected $orderExtensionFactory;

    /** 
     * @var Softserve\Seller\Api\SellerProductRepositoryInterface
     */
    protected $sellerProductInterface;

    /**
     * @param \Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory
     * @param \Softserve\Seller\Api\SellerProductRepositoryInterface $sellerProductInterface
     */
    public function __construct(
        \Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory,
        \Softserve\Seller\Api\SellerProductRepositoryInterface $sellerProductInterface
    ) {
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->sellerProductInterface = $sellerProductInterface;
    }

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $subject
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function afterGet(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderInterface $order
    ) {

        $this->addSellerData($order);
        return $order;
    }
    
    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return self
     */
    private function addSellerData(\Magento\Sales\Api\Data\OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes(); 
        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        }
        $productAttrSeller = $order->getSellerCodes();
        if ($productAttrSeller) {
            foreach(explode(',', $order->getSellerCodes()) as $code) {
                $sellers[] = $this->sellerProductInterface->get($code);

            }
            $extensionAttributes->setSeller($sellers);
            $order->setExtensionAttributes($extensionAttributes);
        }
        return $this;
    }
}
