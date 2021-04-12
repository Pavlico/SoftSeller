<?php
namespace Softserve\Seller\Ui\Component\Listing\Sellers\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    const URL_PATH_EDIT = 'seller/sellers/edit';

    const URL_PATH_DELETE = 'seller/sellers/delete';

    const URL_PATH_ACTIVATE = 'seller/sellers/activate';

    const URL_PATH_DEACTIVATE = 'seller/sellers/deactivate';

    /**
     * @var \Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder
     */
    protected $actionUrlBuilder;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder $actionUrlBuilder
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder $actionUrlBuilder,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getName();
                if (isset($item['seller_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_EDIT, [
                            'seller_id' => $item['seller_id']
                        ]),
                        'label' => __('Edit'),
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, [
                            'seller_id' => $item['seller_id']
                        ]),
                        'label' => __('Delete'),
                    ];
                    $item[$name]['activate'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_ACTIVATE, [
                            'seller_id' => $item['seller_id']
                        ]),
                        'label' => __('Activate'),
                    ];
                    $item[$name]['deactivate'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DEACTIVATE, [
                            'seller_id' => $item['seller_id']
                        ]),
                        'label' => __('Deactivate'),
                    ];
                }
                if (isset($item['identifier'])) {
                    $item[$name]['preview'] = [
                        'href' => $this->actionUrlBuilder->getUrl(
                            $item['identifier'],
                            isset($item['_first_store_id']) ? $item['_first_store_id'] : null,
                            isset($item['store_code']) ? $item['store_code'] : null
                        ),
                        'label' => __('View'),
                    ];
                }
            }
        }
        return $dataSource;
    }
}
