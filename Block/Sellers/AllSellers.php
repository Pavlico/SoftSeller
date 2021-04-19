<?php
namespace Softserve\Seller\Block\Sellers;

class AllSellers extends \Magento\Framework\View\Element\Template
{
    const ENABLED = 1;
    const IS_ENABLED = 'is_enabled';

    /**
     * @var \Softserve\Seller\Api\SellerRepositoryInterface
     */
    protected $sellerRepository;

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
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\Search\FilterGroup $filterGroup
     * @param \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sellerRepository = $sellerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroup = $filterGroup;
        $this->filterGroupBuilder = $filterGroupBuilder;
    }

    /**
     * Retrieve all sellers
     * @return string|bool
     */
    public function getAllSellers()
    {
        $sellers = $this->sellerRepository->getList($this->setSearch());
        return $sellers->getItems();
    }

    /**
     * Search criteria object
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    private function setSearch()
    {
        $sellerFilter = $this->filterBuilder->setField(self::IS_ENABLED)
            ->setValue(self::ENABLED)
            ->setConditionType('eq')
            ->create();

        $sellerFilterGroup = $this->filterGroupBuilder->setFilters([$sellerFilter])->create();
        $this->searchCriteriaBuilder->setFilterGroups([$sellerFilterGroup]);
        return $this->searchCriteriaBuilder->create();
    }
}
