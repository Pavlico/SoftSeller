<?php
namespace Softserve\Seller\Api\Data;

interface SellerReviewsInterface
{
    /**
     * Review id
     *
     * @return int|null
     */
    public function getReviewId();

    /**
     * Set review id
     *
     * @param int $id
     * @return $this
     */
    public function setReviewId($id);

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
     * Get rate
     *
     * @return string
     */
    public function getRate();

    /**
     * Set rate
     *
     * @param string $rate
     * @return $this
     */
    public function setRate($rate);

    /**
     * Get title
     *
     * @return string
     */
     public function getTitle();

     /**
      * Set title
      *
      * @param string $title
      * @return $this
      */
     public function setTitle($title);

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);

    /**
     * Get is confirmed
     *
     * @return boolean
     */
    public function getIsConfirmed();

    /**
     * Set is confirmed
     *
     * @param string $isConfirmed
     * @return $this
     */
    public function setIsConfirmed($isConfirmed);

    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
