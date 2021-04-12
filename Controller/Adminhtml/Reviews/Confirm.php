<?php
namespace Softserve\Seller\Controller\Adminhtml\Reviews;

class Confirm extends \Magento\Backend\App\Action
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
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Softserve\Seller\Model\Review\ReviewFactory $registry
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
     * Confirm review with requested id
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $reviewId = $this->getRequest()->getParam('general')['review_id'];
        $review = $this->reviewFactory->create();
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $review->load($reviewId);
            $review->setIsConfirmed(1);
            $review->save();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Review could not be confirmed.'));
            return $resultRedirect->setPath('*/*/');
        }
        $this->messageManager->addSuccessMessage(__('Review confirmed.'));
        return $resultRedirect->setPath('*/*/');
    }
}
