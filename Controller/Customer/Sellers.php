<?php
namespace Softserve\Seller\Controller\Customer;

class Sellers implements \Magento\Framework\App\ActionInterface
{
    /** 
     * @var \Magento\Framework\View\Result\Page 
     */
    protected $resultPageFactory;

    /** 
     * @var \Magento\Customer\Model\SessionFactory
     */
    protected $customerSessionFactory;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Customer\Model\SessionFactory $customerSessionFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Model\SessionFactory $customerSessionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSessionFactory = $customerSessionFactory;
    }
    /**
     * Init all sellers page
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Best sellers for you'));
        $block = $resultPage->getLayout()->getBlock('customer_sellers');
        $block->setData('customer', $this->customerSessionFactory->create()->getCustomer());
        return $resultPage;
    }
}
