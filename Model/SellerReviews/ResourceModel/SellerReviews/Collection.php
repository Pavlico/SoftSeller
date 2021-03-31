<?php
namespace Softserve\Seller\Model\SellerReviews\ResourceModel\SellerReviews;

use Magento\Cms\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Event previewFlag
     */
    protected $_previewFlag;
    /**
     * Event prefix
     * @var string
     */
    protected $_eventPrefix = 'seller_reviews_collection';

    /**
     * Event object
     * @var string
     */
    protected $_eventObject = 'seller_reviews_collection';

    /**
     * @var string
     */
    protected $_idFieldName = 'review_id';

    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Softserve\Seller\Model\SellerReviews\SellerReviews', 'Softserve\Seller\Model\SellerReviews\ResourceModel\SellerReviews');
    }
    /**
     * Set first store flag
     *
     * @param bool $flag
     * @return $this
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }
    
    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }
}   
