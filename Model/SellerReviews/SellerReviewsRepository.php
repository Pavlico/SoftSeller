<?php
namespace Softserve\Seller\Model\SellerReviews;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Softserve\Seller\Api\SellerReviewsRepositoryInterface;

class SellerReviewsRepository implements SellerReviewsRepositoryInterface
{
    /**
     * @var \Softserver\Seller\Model\SellerReviews\SellerReviewsFactory 
     */
    protected $sellerReviewsFactory;

    /**
     * @var \Softserve\Seller\Model\SellerReviews\ResourceModel\SellerReviews\CollectionFactory
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
     * @param \Softserver\Seller\Model\SellerReviews\SellerReviewsFactory $sellerReviewsFactory
     * @param \Softserve\Seller\Model\SellerReviews\ResourceModel\SellerReviews\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchResultsInterface $searchResults
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Softserve\Seller\Model\SellerReviews\SellerReviewsFactory $sellerReviewsFactory,
        \Softserve\Seller\Model\SellerReviews\ResourceModel\SellerReviews\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterface $searchResults,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->sellerReviewsFactory = $sellerReviewsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResults = $searchResults;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Get review by id
     *
     * @param string $id
     * @return \Softserve\Seller\Model\SellerReviews\SellerReviews
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $sellerReviews = $this->sellerReviewsFactory->create();
        $sellerReviews->getResource()->load($sellerReviews, $id);
        if (!$sellerReviews->getId()) {
            throw new NoSuchEntityException(__('Unable to find seller with ID "%1"', $id));
        }
        return $sellerReviews;
    }
     
    /**
     * Save Seller
     *
     * @param Softserve\Seller\Api\Data\SellerReviewsInterface
     * @return bool Will returned True if saved
     */
    public function save(\Softserve\Seller\Api\Data\SellerReviewsInterface $review)
    {
        $sellerReviews = $this->sellerReviewsFactory->create();
        $sellerReviews->getResource()->save($review);
        if (!$sellerReviews->getSellerId()) {
            throw new CouldNotSaveException(__('Unable to save code'));
        }
        return $sellerReviews;
    }
     
    /**
     * Delete code
     *
     * @param Softserve\Seller\Api\Data\SellerReviewsInterface
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Softserve\Seller\Api\Data\SellerReviewsInterface $review)
    {
        $sellerReviews = $this->sellerReviewsFactory->create();
        $sellerReviews->getResource()->delete($review);
        if ($sellerReviews->getReviewId()) {
            throw new StateException(__('Unable to delete review'));
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
        $sellerReviews = $this->sellerReviewsFactory->create();
        $sellerReviews->getResource()->load($sellerReviews, $id);
        if (!$sellerReviews->getReviewId()) {
            throw new NoSuchEntityException(__('Unable to find review with ID "%1"', $id));
        }
        $sellerReviews->getResource()->delete($sellerReviews);
        if ($sellerReviews->getReviewId()) {
            throw new StateException(__('Unable to delete review'));
        }
        return true;
    }

    /**
     * Get seller reviews list
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
