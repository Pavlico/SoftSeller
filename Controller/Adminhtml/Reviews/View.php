<?php
namespace Softserve\Seller\Controller\Adminhtml\Reviews;

class View extends \Magento\Backend\App\Action
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
     * View review with requested id
     *
     * @return \Magento\Framework\View\Result\Page/\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $reviewId = $this->getRequest()->getParam('review_id');
        $resultPage->getConfig()->getTitle()->prepend(__('View review'));
        $model = $this->reviewFactory->create();
        try {
            $model->load($reviewId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('This review no longer exists.'));
            return $this->_redirect('*/*');
        }
        return $resultPage;
    }
}
