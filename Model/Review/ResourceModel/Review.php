<?php
namespace Softserve\Seller\Model\Review\ResourceModel;

class Review extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'review_id';

    /**
     * @var \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory
     */
    protected $sellerCollection;

    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory $reviewCollection
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory $reviewCollection,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->reviewCollection = $reviewCollection;
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('seller_reviews', 'review_id');
    }
}
