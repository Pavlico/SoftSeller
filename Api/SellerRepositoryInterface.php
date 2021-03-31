<?php
namespace Softserve\Seller\Api;

interface SellerRepositoryInterface
{
    /**
     * Create seller
     *
     * @param \Softserve\Seller\Api\Data\SellerInterface $seller
     * @param bool
     * @return \Softserve\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Softserve\Seller\Api\Data\SellerInterface $seller);

    /**
     * Get seller by code
     *
     * @param string $code
     * @return \Softserve\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($code);

    /**
     * Get info about seller by seller id
     *
     * @param int $sellerId
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \Softserve\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($sellerId);

    /**
     * Delete seller
     *
     * @param \Softserve\Seller\Api\Data\SellerInterface $seller
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Softserve\Seller\Api\Data\SellerInterface $seller);

    /**
     * @param string $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id);

    /**
     * Get seller list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
