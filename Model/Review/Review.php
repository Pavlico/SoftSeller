<?php
namespace Softserve\Seller\Model\Review;

use Softserve\Seller\Api\Data\ReviewInterface;

class Review extends \Magento\Framework\Model\AbstractModel implements ReviewInterface
{
    const REVIEW_ID = 'review_id';
    const SELLER_ID = 'seller_id';
    const RATE = 'rate';
    const TITLE = 'title';
    const MESSAGE = 'message';
    const IS_CONFIRMED = 'is_confirmed';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @var string
     */
    protected $_cacheTag = 'Review';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'Review';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Softserve\Seller\Model\Review\ResourceModel\Review');
    }

    /**
     * Review id
     *
     * @return int|null
     */
    public function getReviewId()
    {
        return $this->getData(self::REVIEW_ID);
    }

    /**
     * Set review id
     *
     * @param int $id
     * @return $this
     */
    public function setReviewId($reviewId)
    {
        return $this->setData(self::REVIEW_ID, $reviewId);
    }

    /**
     * Seller id
     *
     * @return int|null
     */
    public function getSellerId()
    {
        return $this->getData(self::REVIEW_ID);
    }

    /**
     * Set seller id
     *
     * @param int $id
     * @return $this
     */
    public function setSellerId($sellerId)
    {
        return $this->setData(self::REVIEW_ID, $sellerId);
    }

    /**
     * Get rate
     *
     * @return string
     */
    public function getRate()
    {
        return $this->getData(self::RATE);
    }

    /**
     * Set rate
     *
     * @param string $rate
     * @return $this
     */
    public function setRate($rate)
    {
        return $this->setData(self::RATE, $rate);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }
     /**
      * Set title
      *
      * @param string $title
      * @return $this
      */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * Set message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * Get is confirmed
     *
     * @return boolean
     */
    public function getIsConfirmed()
    {
        return $this->getData(self::IS_CONFIRMED);
    }

    /**
     * Set isConfirmed
     *
     * @param string $isConfirmed
     * @return $this
     */
    public function setIsConfirmed($isConfirmed)
    {
        return $this->setData(self::IS_CONFIRMED, $isConfirmed);
    }

    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
