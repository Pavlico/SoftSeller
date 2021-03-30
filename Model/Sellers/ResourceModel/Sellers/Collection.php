<?php
namespace Softserve\Seller\Model\Codes\ResourceModel\Sellers;

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
    protected $_eventPrefix = 'seller_collection';

    /**
     * Event object
     * @var string
     */
    protected $_eventObject = 'seller_collection';

    /**
     * @var string
     */
    protected $_idFieldName = 'seller_id';

    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Softserve\Seller\Model\Sellers\Sellers', 'Softserve\Seller\Model\Sellers\ResourceModel\Sellers');
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

    /**
     * Get collection filtered by code
     *
     * @param int $prodId
     * @return $this 
     */
    public function getByCode($code)
    {
        $this->addFilter('code', $code);
        return $this;
    }
}   
