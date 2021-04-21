<?php
namespace Softserve\Seller\Controller\Seller;

class Raport extends \Magento\Downloadable\Controller\Download
{
    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    protected $moduleReader;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context,
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader,
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    ) {
        parent::__construct($context);
        $this->moduleReader = $moduleReader;
        $this->fileFactory = $fileFactory;
        $this->resultRawFactory = $resultRawFactory;

    }

    /**
     * Download raport file
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $fileName = $this->getRequest()->getParam('file_name');
        $baseDir = $this->moduleReader->getModuleDir('', 'Softserve_Seller');
        $path = $baseDir . '/view/frontend/web/files/' . $fileName;
        $this->fileFactory->create(
            $fileName,
            [
                'type' => 'filename',
                'value' => $path
            ],
            \Magento\Framework\App\Filesystem\DirectoryList::APP,
            'application/octet-stream',
            ''
        );

        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw;
    }
}
