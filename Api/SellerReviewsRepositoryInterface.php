<?php
namespace Softserve\Seller\Api;

interface SellerReviewsRepositoryInterface
{
    /**
     * Create seller
     *
     * @param \Softserve\Seller\Api\Data\SellerReviewsInterface $seller
     * @param bool
     * @return \Softserve\Seller\Api\Data\SellerReviewsInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Softserve\Seller\Api\Data\SellerReviewsInterface $seller);

    /**
     * Get info about review by review id
     *
     * @param int $sellerId
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \Softserve\Seller\Api\Data\SellerReviewsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($reviewId);

    /**
     * Delete sellerReviews
     *
     * @param \Softserve\Seller\Api\Data\SellerReviewsInterface $sellerReviews
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Softserve\Seller\Api\Data\SellerReviewsInterface $sellerReviews);

    /**
     * @param string $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id);

    /**
     * Get sellerReviews list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
