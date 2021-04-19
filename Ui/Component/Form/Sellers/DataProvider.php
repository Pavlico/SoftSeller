<?php

namespace Softserve\Seller\Ui\Component\Form\Sellers;

use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    
    /**
     * @var AbstractCollection
     */
    protected $collection;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . 'seller/';
        $this->loadedData = [];
        foreach ($this->collection->getItems() as $seller) {
            $seller->setData('logo', [
                [
                    'name' => $seller->getData('logo'),
                    'url' => $mediaUrl . $seller->getData('logo'),
                    'type' => 'image/png'
                ]
            ]);
            
            $this->loadedData[$seller->getSellerId()]['general'] = $seller->getData();

        }
        return $this->loadedData;
    }
}
