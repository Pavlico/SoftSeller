<?php
namespace Softserve\Seller\Cron;

class Generate
{
    const CONFIRMED = 1;
    const IS_CONFIRMED = 'is_confirmed';
    const SELLER_ID = 'seller_id';

    /**
     * @var \Magento\Catalog\Model\ResourceModel\ProductFactory
     */
    private $productFactory;

    /**
     * @var \Softserve\Seller\Api\SellerRepositoryInterface
     */
    private $sellerRepository;

    /**
     * @var \Softserve\Seller\Api\ReviewRepositoryInterface
     */
    private $reviewRepository;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepositoryInterface;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var \Magento\Framework\Api\Search\FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
     * @param \Softserve\Seller\Api\ReviewRepositoryInterface $reviewRepository
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Softserve\Seller\Api\ReviewRepositoryInterface $reviewRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->productFactory = $productFactory;
        $this->sellerRepository = $sellerRepository;
        $this->reviewRepository = $reviewRepository;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->storeManager = $storeManager;
    }

    /**
     * Generate seller description based on pattern
     */
    public function generate()
    {
        foreach ($this->storeManager->getStores() as $store) {
            $storeId = $store->getId();
            $this->storeManager->setCurrentStore($storeId);
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('store_id', $storeId)->create();
            $products = $this->productRepositoryInterface->getList($searchCriteria);
            foreach ($products->getItems() as $product) {
                $seller = $this->getSeller($product);
                $reviewAverage = $this->getReviewAverage($seller->getSellerId());
                $description = $seller->getName() . ' (' . $seller->getCode() . '). Rating: ' . $reviewAverage; 
                $product->setCustomAttribute('seller_description', $description);
            }
        }
        return true;
    }

    /**
     * Retrive seller
     * @return \Softserve\Seller\Api\Data\SellerInterface/bool
     */
    private function getSeller($product)
    {
        $productResource = $this->productFactory->create();
        $attribute = $productResource->getAttribute('seller');
        $productAttrSeller = $product->getCustomAttribute('seller');
        if ($productAttrSeller) {
            $optionId = $productAttrSeller->getValue();
            try {
                $seller = $this->sellerRepository->get($attribute->getSource()->getOptionText($optionId));
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                return false;
            }
            return $seller;
        }
        return false;
    }

    /**
     * Retrive reviews average
     * @return int
     */
    private function getReviewAverage($sellerId)
    {
        $reviews = $this->reviewRepository->getList($this->setSearchReviews($sellerId));
        $reviewTotalValue = 0;
        foreach ($reviews as $review) {
            $reviewTotalValue += $review->getRate();
        }
        if ($reviewTotalValue) {
            $average = $reviewTotalValue / count($reviews);
            return $average;
        }
        return 0;
    }

    /**
     * Search criteria object
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    private function setSearchReviews($sellerId)
    {
        $sellerFilter = $this->filterBuilder->setField(self::IS_CONFIRMED)
            ->setValue(self::IS_CONFIRMED)
            ->setConditionType('eq')
            ->setField(self::SELLER_ID)
            ->setValue($sellerId)
            ->setConditionType('eq')
            ->create();

        $sellerFilterGroup = $this->filterGroupBuilder->setFilters([$sellerFilter])->create();
        $this->searchCriteriaBuilder->setFilterGroups([$sellerFilterGroup]);
        return $this->searchCriteriaBuilder->create();
    }
}
