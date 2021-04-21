<?php
namespace Softserve\Seller\Controller\Adminhtml\Sellers;

class Activate extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

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
     * @param \Softserve\Seller\Model\Seller\SellerFactory $registry
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
     * Activate seller with requested id
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $sellerId = $this->getRequest()->getParam('seller_id');
        $seller = $this->sellerFactory->create();
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $seller->load($sellerId);
            $seller->setIsEnabled(1);
            $seller->save();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Seller could not be activated.'));
            return $resultRedirect->setPath('*/*/');
        }
        $this->messageManager->addSuccessMessage(__('Seller activated.'));
        return $resultRedirect->setPath('*/*/');
    }
}
