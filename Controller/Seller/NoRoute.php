<?php
namespace Softserve\Seller\Controller\Seller;

class NoRoute implements \Magento\Framework\App\ActionInterface
{
    protected $resultPageFactory;

    /**
     * NoRoute constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setStatusHeader(404, '1.1', 'Not Found');
        $resultPage->setHeader('Status', '404 File not found');
        $resultPage->getConfig()->getTitle()->prepend(__('Seller doesn\'t exist'));
        return $resultPage;
    }
}
