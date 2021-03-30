<?php
namespace Softserve\Seller\Model\Sellers\ResourceModel;

class Sellers extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'seller_id';

    /**
     * @var \Softserve\Seller\Model\Sellers\ResourceModel\Sellers\CollectionFactory
     */
    protected $sellersCollection;

    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Softserve\Seller\Model\Sellers\ResourceModel\Sellers\CollectionFactory $sellersCollection
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Softserve\Seller\Model\Sellers\ResourceModel\Sellers\CollectionFactory $sellersCollection,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->sellersCollection = $sellersCollection;
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('sellers', 'seller_id');
    }
}
