<?php
namespace Softserve\Seller\Block\Adminhtml;

class Info extends \Magento\Backend\Block\Template
{
    const ENABLED = 1;
    const IS_ENABLED = 'is_enabled';
    const CODE = 'code';
    const IS_CONFIRMED = 'is_confirmed';
    const CONFIRMED = 'confirmed';
    const SELLER_ID = 'seller_id';

    /**
     * @var \Softserve\Seller\Api\SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var \Softserve\Seller\Api\ReviewRepositoryInterface
     */
    protected $reviewRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \Magento\Framework\Api\Search\FilterGroup
     */
    protected $filterGroup;

    /**
     * @var \Magento\Framework\Api\Search\FilterGroupBuilder
     */
    protected $filterGroupBuilder;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
     * @param \Softserve\Seller\Api\ReviewRepositoryInterface $reviewRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\Search\FilterGroup $filterGroup
     * @param \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Softserve\Seller\Api\ReviewRepositoryInterface $reviewRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sellerRepository = $sellerRepository;
        $this->reviewRepository = $reviewRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroup = $filterGroup;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->data[self::CODE] = $this->request->getParam(self::CODE);
    }

    /**
     * Retrieve seller data
     * @return array
     */
    public function getSellerData()
    {
        $seller = $this->sellerRepository->getList($this->setSearch());
        return $seller->getItems();
    }

    /**
     * Retrieve seller data product page
     * @return Softserve\Seller\Api\Data\SellerInterface/boolean
     */
    public function getSellerInfo()
    {
        $product = $this->productRepository->getById($this->getRequest()->getParam('id'));
        $attribute = $product->getResource()->getAttribute('seller');
        $productAttrSeller = $product->getCustomAttribute('seller');
        if ($productAttrSeller) {
            $optionId = $productAttrSeller->getValue();
            try {
                $seller = $this->sellerRepository->get($attribute->getSource()->getOptionText($optionId));
            } catch (\Exception $e) {
                return false;
            }
            return $seller;
        }
        return false;
    }

    /**
     * Search criteria object
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    private function setSearch()
    {
        $sellerFilter = $this->filterBuilder->setField(self::IS_ENABLED)
            ->setValue(self::IS_ENABLED)
            ->setConditionType('eq')
            ->setField(self::CODE)
            ->setValue($this->data[self::CODE])
            ->setConditionType('eq')
            ->create();

        $sellerFilterGroup = $this->filterGroupBuilder->setFilters([$sellerFilter])->create();
        $this->searchCriteriaBuilder->setFilterGroups([$sellerFilterGroup])->setPageSize(1);
        return $this->searchCriteriaBuilder->create();
    }

    /**
     * Retrieve all sellers
     *
     * @return string|bool
     */
    public function getSellerReviews()
    {
        try {
            $this->data[self::SELLER_ID] = $this->sellerRepository->get($this->data[self::CODE])->getSellerId();
            $reviews = $this->reviewRepository->getList($this->setSearchReviews());
            return $reviews->getItems();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {

        }
        return [];
    }

    /**
     * Search criteria object
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    private function setSearchReviews()
    {
        $sellerFilter = $this->filterBuilder->setField(self::IS_CONFIRMED)
            ->setValue(self::ENABLED)
            ->setConditionType('eq')
            ->setField(self::SELLER_ID)
            ->setValue($this->data[self::SELLER_ID])
            ->setConditionType('eq')
            ->create();

        $sellerFilterGroup = $this->filterGroupBuilder->setFilters([$sellerFilter])->create();
        $this->searchCriteriaBuilder->setFilterGroups([$sellerFilterGroup]);
        return $this->searchCriteriaBuilder->create();
    }
}
