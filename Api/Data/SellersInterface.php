<?php
namespace Softserve\Seller\Api\Data;

interface SellersInterface
{
    /**
     * Seller id
     *
     * @return int|null
     */
    public function getSellerId();

    /**
     * Set seller id
     *
     * @param int $id
     * @return $this
     */
    public function setSellerId($id);

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
     * Get link
     *
     * @return string
     */
    public function getLink();

    /**
     * Set link
     *
     * @param string $link
     * @return $this
     */
    public function setLink($link);

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo();

    /**
     * Set logo
     *
     * @param string $logo
     * @return $this
     */
    public function setLogo($logo);

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
     * Get is enabled
     *
     * @return boolean
     */
    public function getIsEnabled();

    /**
     * Set is enabled
     *
     * @param string $isEnabled
     * @return $this
     */
    public function setIsEnabled($isEnabled);
}
