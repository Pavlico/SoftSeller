<?php
namespace Softserve\Seller\Controller\Adminhtml\Sellers;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Softserve\Seller\Model\Seller\SellerFactory
     */
    protected $sellerFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Softserve\Seller\Model\Seller\SellerFactory $sellerFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Softserve\Seller\Model\Seller\SellerFactory $sellerFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * Edit Seller with requested id
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $sellerId = $this->getRequest()->getParam('seller_id');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Seller'));
        $model = $this->sellerFactory->create();
        try {
            $model->load($sellerId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('This seller no longer exists.'));
            $this->_redirect('*/*');
            return;
        }

        return $resultPage;
    }
}
