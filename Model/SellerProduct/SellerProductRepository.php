<?php
namespace Softserve\Seller\Model\SellerProduct;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Softserve\Seller\Api\SellerProductRepositoryInterface;

class SellerProductRepository implements SellerProductRepositoryInterface
{
    /**
     * @var \Softserver\Seller\Model\SellerProduct\SellerProductFactory 
     */
    protected $sellerFactory;

    /**
     * @var \Softserve\Seller\Model\SellerProduct\ResourceModel\SellerProduct\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchResultsInterface
     */
    protected $searchResults;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @param \Softserver\Seller\Model\SellerProduct\SellerProductFactory $sellerFactory
     * @param \Softserve\Seller\Model\SellerProduct\ResourceModel\SellerProduct\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Softserve\Seller\Model\SellerProduct\SellerProductFactory $sellerProductFactory,
        \Softserve\Seller\Model\SellerProduct\ResourceModel\SellerProduct\CollectionFactory $collectionFactory
    ) {
        $this->sellerProductFactory = $sellerProductFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get seller by code
     *
     * @param string $seller
     * @return \Softserve\Seller\Api\Data\SellerProductInterface
     */
    public function get($code)
    {
        $sellerCollection = $this->collectionFactory->create();
        $sellerCollection->getByCode($code);
        if (!$sellerCollection->getSize()) {
            throw new NoSuchEntityException(__('Unable to find seller with code "%1"', $code));
        }
        return $sellerCollection->getFirstItem();
    }
}
