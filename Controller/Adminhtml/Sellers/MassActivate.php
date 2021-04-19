<?php
namespace Softserve\Seller\Controller\Adminhtml\Sellers;

class MassActivate extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Mass activate sellers
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $filteredCollection = $this->filter->getCollection($this->collectionFactory->create());
        $recordEdited = 0;
        foreach ($filteredCollection->getItems() as $record) {
            $record->setIsEnabled(1);
            $record->save();
            $recordEdited++;
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been activated.', $recordEdited));
        return $resultRedirect->setPath('*/*/');
    }
}
