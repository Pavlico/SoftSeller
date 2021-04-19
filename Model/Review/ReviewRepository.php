<?php
namespace Softserve\Seller\Model\Review;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Softserve\Seller\Api\ReviewRepositoryInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * @var \Softserver\Seller\Model\Review\ReviewFactory 
     */
    protected $reviewFactory;

    /**
     * @var \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory
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
     * @param \Softserver\Seller\Model\Review\ReviewFactory $reviewFactory
     * @param \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchResultsInterface $searchResults
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Softserve\Seller\Model\Review\ReviewFactory $reviewFactory,
        \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterface $searchResults,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResults = $searchResults;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Get review by id
     *
     * @param string $id
     * @return \Softserve\Seller\Model\Review\Review
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $review = $this->reviewFactory->create();
        $review->getResource()->load($review, $id);
        if (!$review->getId()) {
            throw new NoSuchEntityException(__('Unable to find seller with ID "%1"', $id));
        }
        return $review;
    }
     
    /**
     * Save Seller
     *
     * @param Softserve\Seller\Api\Data\ReviewInterface
     * @return bool Will returned True if saved
     */
    public function save(\Softserve\Seller\Api\Data\ReviewInterface $review)
    {
        $review = $this->reviewFactory->create();
        $review->getResource()->save($review);
        if (!$review->getSellerId()) {
            throw new CouldNotSaveException(__('Unable to save code'));
        }
        return $review;
    }
     
    /**
     * Delete code
     *
     * @param Softserve\Seller\Api\Data\ReviewInterface
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Softserve\Seller\Api\Data\ReviewInterface $review)
    {
        $review = $this->reviewFactory->create();
        $review->getResource()->delete($review);
        if ($review->getReviewId()) {
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
        $review = $this->reviewFactory->create();
        $review->getResource()->load($review, $id);
        if (!$review->getReviewId()) {
            throw new NoSuchEntityException(__('Unable to find review with ID "%1"', $id));
        }
        $review->getResource()->delete($review);
        if ($review->getReviewId()) {
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
