<?php
namespace Softserve\Seller\Model\Config\Source;

class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory
     */
    private $sellerCollection;

    /**
     * @param \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory $sellerCollection
     */
    public function __construct(
        \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory $sellerCollection
    ) {
        $this->sellerCollection = $sellerCollection;
    }

    /**
    * Get all options for seller tabs
    *
    * @return array
    */
    public function getAllOptions()
    {
        $this->_options = [];
        $collection = $this->sellerCollection->create();
        foreach ($collection as $seller) {
            $this->_options[] = ['value' => $seller->getSellerId(), 'label' => $seller->getName()];
        }
        return $this->_options;
    }
}
