<?php
namespace Softserve\Seller\Controller\Seller;

class Details implements \Magento\Framework\App\ActionInterface
{
    const ENABLED = 1;
    const IS_ENABLED = 'is_enabled';

    /** 
     * @var \Magento\Framework\View\Result\Page 
     */
    protected $resultPageFactory;

    /** 
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /** 
     * @var \Softserve\Seller\Api\SellerRepositoryInterface
     */
    protected $sellerRepository;

    /** 
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->sellerRepository = $sellerRepository;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Init seller page
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $code = $this->request->getParam('code');
        if (!$code || $code && !$this->checkSeller($code)) {
            $resultRedirect = $this->redirectFactory->create();
            return $resultRedirect->setPath('*/*/noroute');

        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__($code));
        return $resultPage;
    }

    /**
     * Check if seller is enabled
     * @return string|bool
     */
    public function checkSeller($code)
    {
        try {
            $enabled = $this->sellerRepository->get($code)->getIsEnabled();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return false;
        }
        return $enabled;
    }
}
