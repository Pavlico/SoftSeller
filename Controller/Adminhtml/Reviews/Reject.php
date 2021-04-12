<?php
namespace Softserve\Seller\Controller\Adminhtml\Reviews;

class Reject extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Softserve\Seller\Model\Review\ReviewFactory
     */
    protected $reviewFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Softserve\Seller\Model\Review\ReviewFactory $reviewFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Softserve\Seller\Model\Review\ReviewFactory $reviewFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->reviewFactory = $reviewFactory;
    }

    /**
     * Reject review with requested id
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $reviewId = $this->getRequest()->getParam('review_id');
        $review = $this->reviewFactory->create();
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $review->load($reviewId);
            $review->setIsConfirmed(0);
            $review->save();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Review could not be rejected.'));
            $resultRedirect->setPath('*/*/');
            return;
        }
        $this->messageManager->addSuccessMessage(__('Review rejected.'));
        return $$resultRedirect->setPath('*/*/');
    }
}
