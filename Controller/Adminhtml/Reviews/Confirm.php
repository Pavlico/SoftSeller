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
     * @var \Softserve\Seller\Model\Review\ReviewFactory
     */
    protected $reviewFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Softserve\Seller\Model\Review\ReviewFactory $registry
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Softserve\Seller\Model\Review\ReviewFactory $reviewFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->reviewFactory = $reviewFactory;
        $this->date = $date;
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
            $review->setUpdatedAt($this->date->gmtDate());
            $review->save();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Review could not be confirmed.'));
            return $resultRedirect->setPath('*/*/');
        }
        $this->messageManager->addSuccessMessage(__('Review confirmed.'));
        return $resultRedirect->setPath('*/*/');
    }
}
