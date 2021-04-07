<?php
namespace Softserve\Seller\Model\SellerProduct\ResourceModel;

class SellerProduct extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'seller_id';

    /**
     * @var \Softserve\Seller\Model\SellerProduct\ResourceModel\SellerProduct\CollectionFactory
     */
    protected $sellerCollection;

    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Softserve\Seller\Model\SellerProduct\ResourceModel\SellerProduct\CollectionFactory $sellerCollection
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Softserve\Seller\Model\SellerProduct\ResourceModel\SellerProduct\CollectionFactory $sellerCollection,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->sellerCollection = $sellerCollection;
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('seller', 'seller_id');
    }
}
