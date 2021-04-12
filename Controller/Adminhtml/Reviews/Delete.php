<?php
namespace Softserve\Seller\Controller\Adminhtml\Reviews;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Softserve\Seller\Model\Review\ReviewFactory
     */
    protected $reviewFactory;

    /**
     * Delete constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Softserve\Seller\Model\Review\ReviewFactory $reviewFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Softserve\Seller\Model\Review\ReviewFactory $reviewFactory
    ) {
        parent::__construct($context);
        $this->reviewFactory = $reviewFactory;
    }

    /**
     * Delete Review with requested id
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $reviewId = $this->getRequest()->getParam('review_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($reviewId) {
            try {
                $review = $this->reviewFactory->create();
                $resource = $review->getResource();
                $resource->load($review, $reviewId);
                $resource->delete($review);

                $this->messageManager->addSuccessMessage(__('The Review has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Unexpected error occured.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t find a review to delete.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
