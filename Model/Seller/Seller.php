<?php
namespace Softserve\Seller\Model\Codes;

use Softserve\Seller\Api\Data\SellersInterface;

class Sellers extends \Magento\Framework\Model\AbstractModel implements SellersInterface
{
    const SELLER_ID = 'seller_id';
    const CODE = 'code';
    const NAME = 'name';
    const LINK = 'link';
    const LOGO = 'logo';
    const DESCRIPTION = 'description';
    const CONTANCT_INFO = 'contact_info';
    const IS_ENABLED = 'is_enabled';

    /**
     * @var string
     */
    protected $_cacheTag = 'Sellers';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'Sellers';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Softserve\Seller\Model\Sellers\ResourceModel\Sellers');
    }

    /**
     * Seller id
     *
     * @return int|null
     */
    public function getSellerId()
    {
        return $this->getData(self::SELLER_ID);
    }

    /**
     * Set seller id
     *
     * @param int $sellerId
     * @return $this
     */
    public function setSellerId($sellerId)
    {
        return $this->setData(self::SELLER_ID, $sellerId);
    }

    /**
     * Get Code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->getData(self::CODE);
    }

    /**
     * Set code
     *
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }
     /**
      * Set Name
      *
      * @param string $name
      * @return $this
      */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->getData(self::LINK);
    }

    /**
     * Set link
     *
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        return $this->setData(self::LINK, $link);
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->getData(self::LOGO);
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        return $this->setData(self::LOGO, $logo);
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Get contactInfo
     *
     * @return string
     */
    public function getContactInfo()
    {
        return $this->getData(self::CONTANCT_INFO);
    }

    /**
     * Set contact info
     *
     * @param string $contactInfo
     * @return $this
     */
    public function setContactInfo($contactInfo)
    {
        return $this->setData(self::CONTANCT_INFO, $contactInfo);
    }

    /**
     * Get enabled sellers
     *
     * @return string
     */
    public function getIsEnabled()
    {
        return $this->getData(self::IS_ENABLED);
    }

    /**
     * Set is enabled
     *
     * @param string $isEnabled
     * @return $this
     */
    public function setIsEnabled($isEnabled)
    {
        return $this->setData(self::IS_ENABLED, $isEnabled);
    }
}
