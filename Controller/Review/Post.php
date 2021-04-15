<?php
namespace Softserve\Seller\Controller\Review;

class Post implements \Magento\Framework\App\ActionInterface
{
    /**
     * @var \Softserve\Seller\Model\Seller\SellerFactory
     */
    protected $reviewFactory;

    /**
     * @var \Softserve\Seller\Model\Seller\ResourceModel\Seller
     */
    protected $seller;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @param \Softserve\Seller\Model\Seller\SellerFactory $sellerFactory
     * @param \Softserve\Seller\Model\Seller\ResourceModel\Seller $seller
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Softserve\Seller\Model\Review\ReviewFactory $reviewFactory,
        \Softserve\Seller\Model\Seller\ResourceModel\Seller $seller,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
        
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->seller = $seller;
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Save review from data
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->redirectFactory->create();
        $reviewData = $this->request->getParams();
        try {
            $review = $this->reviewFactory->create();
            $review->setData($reviewData);
            $review->save($review);
        } catch (\Exception $e) {
            return $resultRedirect->setPath('*/seller/' . $this->request->getParam('seller_code'));
        }        
        return $resultRedirect->setPath('*/seller/' . $this->request->getParam('seller_code'));
    }
}
