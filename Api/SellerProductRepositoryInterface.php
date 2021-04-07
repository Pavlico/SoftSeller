<?php
namespace Softserve\Seller\Api;

interface SellerProductRepositoryInterface
{
    /**
     * Get seller by code
     *
     * @param string $code
     * @return \Softserve\Seller\Api\Data\SellerProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($code);
}
