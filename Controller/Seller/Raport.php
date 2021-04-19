<?php
namespace Softserve\Seller\Controller\Seller;

class Raport extends \Magento\Downloadable\Controller\Download
{
    protected $resultPageFactory;

    /**
     * NoRoute constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Downloadable\Helper\File $file,
        \Magento\Framework\View\Asset\Repository $assetRepository
    ) {
        parent::__construct($context);
        $this->moduleReader = $moduleReader;
        $this->file = $file;
        $this->assetRepository = $assetRepository;

    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $fileName = $this->getRequest()->getParam('file_name');
        $fileId = 'Softserve_Seller::files/' . $fileName;
        $params = [
            'area' => 'frontend'
        ];
        $asset = $this->assetRepository->createAsset($fileId, $params);
        try {
            return $asset->getSourceFile();
        } catch (\Exception $e) {
            return null;
        }
        return;
    }
}
