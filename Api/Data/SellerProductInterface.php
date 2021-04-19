<?php
namespace Softserve\Seller\Api\Data;

interface SellerProductInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Get code
     *
     * @return string
     */
    public function getCode();

    /**
     * Get name
     *
     * @return string
     */
     public function getName();

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get contact info
     *
     * @return string
     */
    public function getContactInfo();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Softserve\Seller\Api\Data\SellerProductExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Softserve\Seller\Api\Data\SellerProductExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Softserve\Seller\Api\Data\SellerProductExtensionInterface $extensionAttributes
    );
}
