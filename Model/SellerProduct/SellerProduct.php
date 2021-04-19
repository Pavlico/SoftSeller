<?php
namespace Softserve\Seller\Model\SellerProduct;

use Softserve\Seller\Api\Data\SellerProductInterface;

class SellerProduct extends \Magento\Framework\Model\AbstractExtensibleModel implements SellerProductInterface
{
    const CODE = 'code';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const CONTANCT_INFO = 'contact_info';

    /**
     * @var string
     */
    protected $_cacheTag = 'SellerProduct';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'SellerProduct';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Softserve\Seller\Model\SellerProduct\ResourceModel\SellerProduct');
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
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
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
     * Get contactInfo
     *
     * @return string
     */
    public function getContactInfo()
    {
        return $this->getData(self::CONTANCT_INFO);
    }

    /**
     * @return \Softserve\Seller\Api\Data\Data\SellerProductExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @param \Softserve\Seller\Api\Data\Data\SellerProductExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Softserve\Seller\Api\Data\SellerProductExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
