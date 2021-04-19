<?php
namespace Softserve\Seller\Model\File;

use Magento\Eav\Api\AttributeManagementInterface;
use Magento\Catalog\Model\Config;
use Magento\Eav\Api\Data\AttributeSetInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Api\AttributeSetRepositoryInterface;
use Magento\Framework\Filesystem\DirectoryList;

class Generator extends \Magento\Framework\Model\AbstractExtensibleModel
{
   /**
     * @var AttributeManagementInterface
     */
    private $attributeManagementInterface;

    /**
     * @var Config
     */
    private $configAttr;

    /**
     * @var AttributeSetRepositoryInterface
     */
    private $attributeSetRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param AttributeManagementInterface $attributeManagementInterface
     * @param Config $configAttr
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        AttributeManagementInterface $attributeManagementInterface,
        Config $configAttr,
        AttributeSetRepositoryInterface $attributeSetRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Softserve\Seller\Api\SellerRepositoryInterface $sellerRepository,
        \Softserve\Seller\Api\ReviewRepositoryInterface $reviewRepository,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Io\File $file,
        \Magento\Framework\Convert\ConvertArray $convertArray
    ) {
        $this->attributeManagementInterface = $attributeManagementInterface;
        $this->configAttr = $configAttr;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroup = $filterGroup;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->fileFactory = $fileFactory;
        $this->sellerRepository = $sellerRepository;
        $this->reviewRepository = $reviewRepository;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->convertArray = $convertArray;
    }

    /**
     * Execute command
     * 
     * @param string $attributeCode
     * @param string $order
     * @param string $group
     * 
     * @return void
     */
    public function execute($limit = false, $sellers = false, $includeReviews = false)
    {
        $fileContent = [];
        $reviewArray = [];
        $sellers = $this->sellerRepository->getList($this->setSearch($limit, $sellers, 'code'));
        foreach ($sellers->getItems() as $seller) {
                $fileContent[$seller->getCode()] = [
                    'seller_id' => $seller->getSellerId(),
                    'code' => $seller->getCode(),
                    'name' => $seller->getName(),
                    'link' => $seller->getLink(),
                    'description' => $seller->getDescription(),
                    'contact_info' => $seller->getContactInfo(),
                    'is_enabled' => $seller->getIsEnabled()
                ];
                $reviews = [];
            if ($includeReviews) {
                $reviews = $this->reviewRepository->getList($this->setSearch(false, $seller->getSellerId(), 'seller_id'));
                foreach ($reviews->getItems() as $review) {
                    $reviewArray['review_' . $review->getReviewId()] = [
                        'rate' => 'test',
                        'title' => 'test',
                        'message' => 'test'
                    ];
                }
                $fileContent[$seller->getCode()]['reviews'] = $reviewArray;
            }
            
            
        }
        return $this->createExcel($fileContent, $includeReviews);
    }

    /**
     * Search criteria object
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    private function setSearch($limit, $values, $field)
    {
        $sellerFilterGroup = $this->setFilters($field, $values);
        $this->searchCriteriaBuilder->setFilterGroups([$sellerFilterGroup]);
        if ($limit) {
            $this->searchCriteriaBuilder->setPageSize($limit);
        }
        return $this->searchCriteriaBuilder->create();
    }

    /**
     * Create filters
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    private function setFilters($field, $values)
    {
        $sellerFilter = $this->filterBuilder;
        $filterGroupBuilder = $this->filterGroupBuilder;
        if ($values) {
            $values = explode(' ', $values);
            $sellerFilter = $sellerFilter
                ->setField($field)
                ->setValue($values)
                ->setConditionType('in')
                ->create();
            $filterGroupBuilder->setFilters([$sellerFilter]);
        }
        return $filterGroupBuilder->create();
    }

    /**
     * Create excel
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    public function createExcel($fileContent, $includeReviews)
    {
        $name = 'Sellers_list_';
        if ($includeReviews) {
            $name .= 'with_reviews_';
        }
        $simpleXmlContents = $this->convertArray->assocToXml($fileContent, 'sellers');
        $content = $simpleXmlContents->asXML();
        $fileName = $name . date('Y_m_d') . '.xml';
        $baseDir = $this->moduleReader->getModuleDir('', 'Softserve_Seller');
        $path = $baseDir . '/view/frontend/web/files/' . $fileName;
        $app = $this->filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::APP);
        $app->writeFile($path, $content);
        return $fileName;
    }
}
