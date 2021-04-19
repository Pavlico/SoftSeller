<?php
namespace Softserve\Seller\Controller\Adminhtml\Sellers;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Softserve\Seller\Model\Seller\SellerFactory
     */
    protected $sellerFactory;

    /**
     * @var \Softserve\Seller\Model\Seller\ResourceModel\Seller
     */
    protected $seller;
        
    /**
     * @var \Softserve\Seller\Model\Image\ImageUploader
     */
    protected $imageUploader;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Softserve\Seller\Model\Seller\SellerFactory $sellerFactory
     * @param \Softserve\Seller\Model\Seller\ResourceModel\Seller $seller
     * @param \Softserve\Seller\Model\Image\ImageUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Softserve\Seller\Model\Seller\SellerFactory $sellerFactory,
        \Softserve\Seller\Model\Seller\ResourceModel\Seller $seller,
        \Softserve\Seller\Model\Image\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->sellerFactory = $sellerFactory;
        $this->seller = $seller;
        $this->imageUploader = $imageUploader;
    }

    /**
     * Save form data
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();   
        if (array_key_exists('general', $sellerData = $this->_request->getParams())) {
            $sellerData = $this->imageSaveToDir($sellerData);
            try {
                $seller = $this->sellerFactory->create();
                $seller->setData($sellerData['general']);
                $seller->save($seller);
            } catch (\Magento\Framework\Validator\Exception $ex) {
                $this->messageManager->addErrorMessage(__('Something went wrong but %1 record(s) have been added.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            $this->messageManager->addSuccessMessage(__('Record has been added.'));
            return $resultRedirect->setPath('*/*/');
        }
        
        $this->messageManager->addErrorMessage(__('Something went wrong'));
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Save image to directory
     */
    private function imageSaveToDir(array $data) {
        if (isset($data['general']['logo'][0]['name']) && isset($data['general']['logo'][0]['tmp_name'])) {
            $data['general']['logo'] = $data['general']['logo'][0]['name']; 
            $this->imageUploader->moveFileFromTmp($data['general']['logo']);
        } elseif (isset($data['general']['logo'][0]['image']) && !isset($data['general']['logo'][0]['tmp_name'])) {
            $data['general']['logo'] = $data['logo'][0]['image'];
        } else {
            $data['general']['logo'] = null;
        }
        return $data;
    }
}
