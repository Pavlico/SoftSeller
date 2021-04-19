<?php
namespace Softserve\Seller\Api;

interface ReviewRepositoryInterface
{
    /**
     * Create review
     *
     * @param \Softserve\Seller\Api\Data\ReviewInterface $review
     * @param bool
     * @return \Softserve\Seller\Api\Data\ReviewInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Softserve\Seller\Api\Data\ReviewInterface $review);

    /**
     * Get info about review by review id
     *
     * @param int $sellerId
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \Softserve\Seller\Api\Data\ReviewInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($reviewId);

    /**
     * Delete review
     *
     * @param \Softserve\Seller\Api\Data\ReviewInterface $review
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Softserve\Seller\Api\Data\ReviewInterface $review);

    /**
     * @param string $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id);

    /**
     * Get review list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
