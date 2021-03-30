<?php
namespace Softserve\Seller\Model\SellerReviews\ResourceModel;

class SellerReviews extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'review_id';

    /**
     * @var \Softserve\Seller\Model\SellerReviews\ResourceModel\SellerReviews\CollectionFactory
     */
    protected $sellersCollection;

    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Softserve\Seller\Model\SellerReviews\ResourceModel\SellerReviews\CollectionFactory $sellerReviewsCollection
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Softserve\Seller\Model\SellerReviews\ResourceModel\SellerReviews\CollectionFactory $sellerReviewsCollection,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->sellerReviewsCollection = $sellerReviewsCollection;
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('sellers', 'review_id');
    }
}
