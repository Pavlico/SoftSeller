<?php
namespace Softserve\Seller\Api;

interface SellersRepositoryInterface
{
    /**
     * Create seller
     *
     * @param \Softserve\Seller\Api\Data\SellersInterface $seller
     * @param bool
     * @return \Softserve\Seller\Api\Data\SellersInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Softserve\Seller\Api\Data\SellersInterface $seller);

    /**
     * Get seller by code
     *
     * @param string $code
     * @return \Softserve\Seller\Api\Data\SellersInterface
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
     * @return \Softserve\Seller\Api\Data\SellersInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($sellerId);

    /**
     * Delete sellers
     *
     * @param \Softserve\Seller\Api\Data\SellersInterface $sellers
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Softserve\Seller\Api\Data\SellersInterface $sellers);

    /**
     * @param string $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id);

    /**
     * Get sellers list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
