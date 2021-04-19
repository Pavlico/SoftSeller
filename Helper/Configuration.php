<?php

namespace Softserve\Seller\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Configuration extends AbstractHelper
{
    /**
     * Configuration path
     */
    const CONFIG_API_ENABLE = 'seller/advanced_settings/api_seller_enabled';

    /**
     * @var array
     */
    private static $cache = [];

    /**
     * @return string
     */
    public function getApiEnabled()
    {
        return $this->getConfigValue(self::CONFIG_API_ENABLE);
    }

    /**
     * @param $name
     * @param bool $refresh
     * @return mixed
     */
    private function getConfigValue($name, $refresh = false)
    {
        if ($refresh || !isset(self::$cache[$name])) {
            self::$cache[$name] = $this->scopeConfig->getValue($name, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }
        return self::$cache[$name];
    }
}
