<?php
namespace Softserve\Seller\Model\Seller;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Softserve\Seller\Api\SellerRepositoryInterface;

class SellerRepository implements SellerRepositoryInterface
{
    /**
     * @var \Softserver\Seller\Model\Seller\SellerFactory 
     */
    protected $sellerFactory;

    /**
     * @var \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchResultsInterface
     */
    protected $searchResults;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @param \Softserver\Seller\Model\Seller\SellerFactory $sellerFactory
     * @param \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchResultsInterface $searchResults
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Softserve\Seller\Model\Seller\SellerFactory $sellerFactory,
        \Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterface $searchResults,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Magento\Framework\App\State $state,
        \Softserve\Seller\Helper\Configuration $configuration,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->sellerFactory = $sellerFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResults = $searchResults;
        $this->collectionProcessor = $collectionProcessor;
        $this->state = $state;
        $this->configuration = $configuration;
        $this->request = $request;
    }

    /**
     * Get code by id
     *
     * @param string $id
     * @return \Softserve\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        if (!$this->validate()) {
            throw new CouldNotSaveException(__('Not enabled by module config'));
        }
        $seller = $this->sellerFactory->create();
        $seller->getResource()->load($seller, $id);
        if (!$seller->getId()) {
            throw new NoSuchEntityException(__('Unable to find seller with ID "%1"', $id));
        }
        return $seller;
    }
    
    /**
     * Get seller by code
     *
     * @param string $seller
     * @return \Softserve\Seller\Api\Data\SellerInterface
     */
    public function get($code)
    {
        if (!$this->validate()) {
            throw new CouldNotSaveException(__('Not enabled by module config'));
        }
        $sellerCollection = $this->collectionFactory->create();
        $sellerCollection->getByCode($code);
        if ($sellerCollection->getSize()) {
            return $sellerCollection->getFirstItem();
        }
        throw new NoSuchEntityException(__('Unable to find seller with code "%1"', $code));
    }
     
    /**
     * Save Seller
     *
     * @param Softserve\Seller\Api\Data\SellerInterface
     * @return Softserve\Seller\Api\Data\SellerInterface
     */
    public function save(\Softserve\Seller\Api\Data\SellerInterface $seller)
    {
        if (!$this->validate()) {
            throw new CouldNotSaveException(__('Not enabled by module config'));
        }
        if (empty($seller->getData())) {
            throw new CouldNotSaveException(__('No required data'));
        }
        $sellerResource = $this->sellerFactory->create()->getResource();
        $sellerId = $seller->getSellerId();
        try {
            if ($sellerId && $existingSeller = $this->getById($sellerId)) {
                $existingSeller->setData($seller->getData());
                $seller = $existingSeller;
            }        
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
        }
        $sellerResource->save($seller);
        if (!$seller->getSellerId()) {
            throw new CouldNotSaveException(__('Unable to save seller'));
        }
        return $seller;
    }

    /**
     * Delete seller
     *
     * @param Softserve\Seller\Api\Data\SellerInterface
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Softserve\Seller\Api\Data\SellerInterface $seller)
    {
        if (!$this->validate()) {
            throw new CouldNotSaveException(__('Not enabled by module config'));
        }
        $sellerResource = $this->sellerFactory->create();
        $sellerResource->getResource()->delete($seller);
        if ($seller->getSellerId()) {
            throw new StateException(__('Unable to delete seller'));
        }
        return true;
    }

    /**
     * @param string $sellerId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($sellerId)
    {
        if (!$this->validate()) {
            throw new CouldNotSaveException(__('Not enabled by module config'));
        }
        $seller = $this->sellerFactory->create();
        $seller->getResource()->load($seller, $sellerId);
        if (!$seller->getSellerId()) {
            throw new NoSuchEntityException(__('Unable to find seller with ID "%1"', $sellerId));
        }
        $seller->delete($seller);
        return true;
    }

    /**
     * Get seller list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\BlockSearchResultsInterface $searchResults */
        $this->searchResults->setSearchCriteria($searchCriteria);
        $this->searchResults->setItems($collection->getItems());
        $this->searchResults->setTotalCount($collection->getSize());
        return $this->searchResults;
    }
    
    /**
     * Validate for api request and check if config enables it
     * @return bool
     */
    private function validate()
    {
        $area = $this->state->getAreaCode();
        if (($area == \Magento\Framework\App\Area::AREA_WEBAPI_REST ||
            $area == \Magento\Framework\App\Area::AREA_WEBAPI_REST) &&
            !$this->configuration->getApiEnabled()
        ) {
            return false;
        }
        return true;
    }
}
