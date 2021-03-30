<?php
namespace Softserve\Seller\Model\Sellers;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Softserve\Seller\Api\SellersRepositoryInterface;

class SellersRepository implements SellersRepositoryInterface
{
    /**
     * @var \Softserver\Seller\Model\Sellers\SellersFactory 
     */
    protected $sellersFactory;

    /**
     * @var \Softserve\Seller\Model\Sellers\ResourceModel\Sellers\CollectionFactory
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
     * @param \Softserver\Seller\Model\Sellers\SellersFactory $sellersFactory
     * @param \Softserve\Seller\Model\Sellers\ResourceModel\Sellers\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchResultsInterface $searchResults
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Softserve\Seller\Model\Sellers\SellersFactory $sellersFactory,
        \Softserve\Seller\Model\Sellers\ResourceModel\Sellers\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterface $searchResults,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->sellersFactory = $sellersFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResults = $searchResults;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Get code by id
     *
     * @param string $id
     * @return \Softserve\Seller\Model\Codes\Codes
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $sellers = $this->sellersFactory->create();
        $sellers->getResource()->load($sellers, $id);
        if (!$sellers->getId()) {
            throw new NoSuchEntityException(__('Unable to find seller with ID "%1"', $id));
        }
        return $sellers;
    }
    
    /**
     * Get seller by code
     *
     * @param string $sellers
     * @return Softserve\Seller\Model\Codes\Codes
     */
    public function get($code)
    {
        $sellersCollection = $this->collectionFactory->create();
        $sellersCollection->getByCode($code);
        return $sellersCollection;
    }
     
    /**
     * Save Seller
     *
     * @param Softserve\Seller\Api\Data\SellersInterface
     * @return bool Will returned True if saved
     */
    public function save(\Softserve\Seller\Api\Data\SellersInterface $seller)
    {
        $sellers = $this->sellersFactory->create();
        $sellers->getResource()->save($seller);
        if (!$sellers->getSellerId()) {
            throw new CouldNotSaveException(__('Unable to save code'));
        }
        return $sellers;
    }
     
    /**
     * Delete code
     *
     * @param Softserve\Seller\Api\Data\SellersInterface
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Softserve\Seller\Api\Data\SellersInterface $seller)
    {
        $sellers = $this->sellersFactory->create();
        $sellers->getResource()->delete($seller);
        if ($sellers->getSellerId()) {
            throw new StateException(__('Unable to delete code'));
        }
        return true;
    }

    /**
     * @param string $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id)
    {
        $sellers = $this->sellersFactory->create();
        $sellers->getResource()->load($sellers, $id);
        if (!$sellers->getSellerId()) {
            throw new NoSuchEntityException(__('Unable to find seller with ID "%1"', $id));
        }
        $sellers->getResource()->delete($sellers);
        if ($sellers->getSellerId()) {
            throw new StateException(__('Unable to delete seller'));
        }
        return true;
    }

    /**
     * Get sellers list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\BlockSearchResultsInterface $searchResults */
        $this->searchResults->setSearchCriteria($searchCriteria);
        $this->searchResults->setItems($collection->getItems());
        $this->searchResults->setTotalCount($collection->getSize());
        return $this->searchResults;
    }
}
