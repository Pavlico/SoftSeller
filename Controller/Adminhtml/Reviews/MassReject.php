<?php
namespace Softserve\Seller\Controller\Adminhtml\Reviews;

class MassReject extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Softserve\Seller\Model\Review\ResourceModel\Review\CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Mass deactivate reviews
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $filteredCollection = $this->filter->getCollection($this->collectionFactory->create());
        $recordEdited = 0;

        foreach ($filteredCollection->getItems() as $record) {
            $record->setIsConfirmed(0);
            $record->save();
            $recordEdited++;
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been rejected.', $recordEdited));
        return $resultRedirect->setPath('*/*/');
    }
}
