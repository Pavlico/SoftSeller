<?php
namespace Softserve\Seller\Api\Data;

interface SellerInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Get code
     *
     * @return string
     */
    public function getCode();

    /**
     * Set code
     *
     * @param string $code
     * @return $this
     */
    public function setCode($code);

    /**
     * Get name
     *
     * @return string
     */
     public function getName();

     /**
      * Set name
      *
      * @param string $name
      * @return $this
      */
     public function setName($name);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Get contact info
     *
     * @return string
     */
    public function getContactInfo();

    /**
     * Set contact info
     *
     * @param string $contactInfo
     * @return $this
     */
    public function setContactInfo($contactInfo);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Softserve\Seller\Api\Data\SellerExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Softserve\Seller\Api\Data\SellerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Softserve\Seller\Api\Data\SellerExtensionInterface $extensionAttributes
    );
}
