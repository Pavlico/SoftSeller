<?php
namespace Softserve\Seller\Controller\Adminhtml\Sellers;

class Deactivate extends \Magento\Backend\App\Action
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
     * Deactivate seller with requested id
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $sellerId = $this->getRequest()->getParam('seller_id');
        $seller = $this->sellerFactory->create();
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $seller->load($sellerId);
            $seller->setIsEnabled(0);
            $seller->save();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Seller could not be deactivated.'));
            $resultRedirect->setPath('*/*/');
            return;
        }
        $this->messageManager->addSuccessMessage(__('Seller deactivated.'));
        return $$resultRedirect->setPath('*/*/');
    }
}
