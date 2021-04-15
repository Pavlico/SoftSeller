<?php
namespace Softserve\Seller\Block\Sellers;

use Magento\Review\Model\ResourceModel\Rating\Collection as RatingCollection;

class Form extends \Magento\Framework\View\Element\Template
{
    const CODE = 'code';
    /**
     * Review data
     *
     * @var \Magento\Review\Helper\Data
     */
    protected $_reviewData = null;

    /**
     * Catalog product model
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $reviewRepository;

    /**
     * Rating model
     *
     * @var \Magento\Review\Model\RatingFactory
     */
    protected $_ratingFactory;

    /**
     * @var \Magento\Framework\Url\EncoderInterface
     */
    protected $urlEncoder;

    /**
     * Message manager interface
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $customerUrl;

    /**
     * @var array
     */
    protected $jsLayout;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $serializer;

    /**
     * Form constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Review\Helper\Data $reviewData
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $reviewRepository
     * @param \Magento\Review\Model\RatingFactory $ratingFactory
     * @param array $data
     * @param \Magento\Framework\Serialize\Serializer\Json|null $serializer
     * @throws \RuntimeException
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Softserve\Seller\Api\ReviewRepositoryInterface $reviewRepository,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Framework\App\Request\Http $request,
        array $data = [],
        \Magento\Framework\Serialize\Serializer\Json $serializer = null
    ) {
        parent::__construct($context, $data);
        $this->reviewRepository = $reviewRepository;
        $this->sellerRepository = $sellerRepository;
        $this->_ratingFactory = $ratingFactory;
        $this->request = $request;
        $this->jsLayout = isset($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->serializer = $serializer ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Framework\Serialize\Serializer\Json::class);
    }

    /**
     * Get collection of ratings
     * @return RatingCollection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getRatings()
    {
        return $this->_ratingFactory->create()->getResourceCollection()->addEntityFilter(
            'product'
        )->setPositionOrder()->addRatingPerStoreName(
            $this->_storeManager->getStore()->getId()
        )->setStoreFilter(
            $this->_storeManager->getStore()->getId()
        )->setActiveFilter(
            true
        )->load()->addOptionToItems();
    }

    /**
     * @return string
     */
    public function getJsLayout()
    {
        return $this->serializer->serialize($this->jsLayout);
    }

    /**
     * Get seller id
     * @return Softserve\Seller\Api\Data\SellerInterface/bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSeller()
    {
        try {
            $seller = $this->sellerRepository->get($this->request->getParam(self::CODE));
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return false;
        }
        return $seller;
    }

    /**
     * Get review product post action
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl(
            'softserve/review/post',
            [
                '_secure' => $this->getRequest()->isSecure(),
                'id' => $this->getProductId(),
            ]
        );
    }
}
