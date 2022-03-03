<?php

namespace Softserve\Seller\Test\Unit\Model\Seller;

class SellerRepositoryTest extends \PHPUnit\Framework\TestCase
{
    // /**
    //  * @var \PHPUnit_Framework_MockObject_MockBuilder
    //  */
    // private $sellerFactory;

    public function setUp(): void
    {
        $this->sellerFactory = $this->getMockBuilder(\Softserve\Seller\Model\Seller\SellerFactory::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['create'])
            ->getMock();

        $this->collectionFactory = $this->getMockBuilder(\Softserve\Seller\Model\Seller\ResourceModel\Seller\CollectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchResults = $this->getMockBuilder(\Magento\Framework\Api\SearchResultsInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionProcessor = $this->getMockBuilder(\Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->state = $this->getMockBuilder(\Magento\Framework\App\State::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configuration = $this->getMockBuilder(\Softserve\Seller\Helper\Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->request = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->seller = $this->getMockBuilder(\Softserve\Seller\Api\Data\SellerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sellerRepository = new \Softserve\Seller\Model\Seller\SellerRepository(
            $this->sellerFactory,
            $this->collectionFactory,
            $this->searchResults,
            $this->collectionProcessor,
            $this->state,
            $this->configuration,
            $this->request
        );
    }

    public function testSaveUpdate()
    {
        $seller = $this->getMockBuilder(\Softserve\Seller\Model\Seller\Seller::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getResource', 'getSellerId', 'getData', 'getId'])
            ->getMock();

        $seller->expects($this->exactly(2))
            ->method('getData')
            ->willreturn(['test']);

        $resource = $this->getMockBuilder(\Softserve\Seller\Model\Seller\ResourceModel\Seller::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['save','load'])
            ->getMock();

        $this->sellerFactory->expects($this->exactly(2))
            ->method('create')
            ->willreturn($seller);

        $seller->expects($this->exactly(2))
            ->method('getResource')
            ->willreturn($resource);

        $seller->expects($this->any())
            ->method('getSellerId')
            ->willreturn('1');

        $resource->expects($this->once())
            ->method('load')
            ->with($seller, '1')
            ->willreturn($seller);

        $seller->expects($this->once())
            ->method('getId')
            ->willreturn('1');

        $resource->expects($this->once())
            ->method('save')
            ->with($seller);
        
       $this->sellerRepository->save($seller);
    }

    public function testSaveNew()
    {
        $seller = $this->getMockBuilder(\Softserve\Seller\Model\Seller\Seller::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getResource', 'getSellerId', 'getData'])
            ->getMock();

        $seller->expects($this->once())
            ->method('getData')
            ->willreturn(['test']);

        $resource = $this->getMockBuilder(\Softserve\Seller\Model\Seller\ResourceModel\Seller::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['save'])
            ->getMock();

        $this->sellerFactory->expects($this->once())
            ->method('create')
            ->willreturn($seller);

        $seller->expects($this->once())
            ->method('getResource')
            ->willreturn($resource);

        $seller->expects($this->exactly(2))
            ->method('getSellerId')
            ->willReturnOnConsecutiveCalls(null, '1');

        $resource->expects($this->once())
            ->method('save')
            ->with($seller);

       $this->sellerRepository->save($seller);
    }

    public function testSaveDoesntExist()
    {
        $seller = $this->getMockBuilder(\Softserve\Seller\Model\Seller\Seller::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getResource', 'getSellerId', 'getData'])
            ->getMock();

        $seller->expects($this->once())
            ->method('getData')
            ->willreturn(['test']);

        $resource = $this->getMockBuilder(\Softserve\Seller\Model\Seller\ResourceModel\Seller::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['save'])
            ->getMock();

        $this->sellerFactory->expects($this->once())
            ->method('create')
            ->willreturn($seller);

        $seller->expects($this->once())
            ->method('getResource')
            ->willreturn($resource);

        $seller->expects($this->exactly(2))
            ->method('getSellerId')
            ->willReturnOnConsecutiveCalls(null);

        $resource->expects($this->once())
            ->method('save')
            ->with($seller);

        $this->expectException(\Magento\Framework\Exception\CouldNotSaveException::class);
        $this->sellerRepository->save($seller);
    }

    public function testSaveNoData()
    {
        $seller = $this->getMockBuilder(\Softserve\Seller\Model\Seller\Seller::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getData'])
            ->getMock();

        $seller->expects($this->once())
            ->method('getData')
            ->willreturn([]);
            
        $this->expectException(\Magento\Framework\Exception\CouldNotSaveException::class);
        $this->sellerRepository->save($seller);
    }
}
