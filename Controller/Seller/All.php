<?php
namespace Softserve\Seller\Controller\Seller;

class All implements \Magento\Framework\App\ActionInterface
{
    /** 
     * @var \Magento\Framework\View\Result\Page 
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Init all sellers page
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Sellers'));
        return $resultPage;
    }
}
