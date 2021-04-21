<?php
namespace Softserve\Seller\Controller\Adminhtml\Sellers;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Softserve\Seller\Model\Seller\SellerFactory
     */
    protected $sellerFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Softserve\Seller\Model\Seller\SellerFactory $sellerFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Softserve\Seller\Model\Seller\SellerFactory $sellerFactory
    ) {
        parent::__construct($context);
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * Delete Seller with requested id
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $sellerId = $this->getRequest()->getParam('seller_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($sellerId) {
            try {
                $seller = $this->sellerFactory->create();
                $resource = $seller->getResource();
                $resource->load($seller, $sellerId);
                $resource->delete($seller);

                $this->messageManager->addSuccessMessage(__('The Seller has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Unexpected error occured.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t find a seller to delete.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
