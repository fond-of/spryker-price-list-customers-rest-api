<?php

namespace FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Glue\PriceListCompanyUsersRestApi\PriceListCompanyUsersRestApiConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PriceListsCustomersResourceRelationshipExpanderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander\PriceListsCustomersResourceRelationshipExpander
     */
    protected $priceListsCustomersResourceRelationshipExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderInterfaceMock;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[]
     */
    protected $resources;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    protected $priceListCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected $priceListTransferMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\PriceListTransfer[]
     */
    protected $priceLists;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceBuilderInterfaceMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceInterfaceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resources = [
            $this->restResourceInterfaceMock,
        ];

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCollectionTransferMock = $this->getMockBuilder(PriceListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceLists = new ArrayObject([
            $this->priceListTransferMock,
        ]);

        $this->uuid = 'uuid';

        $this->priceListsCustomersResourceRelationshipExpander = new PriceListsCustomersResourceRelationshipExpander(
            $this->restResourceBuilderInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testAddResourceRelationships(): void
    {
        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getPayload')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPriceListCollection')
            ->willReturn($this->priceListCollectionTransferMock);

        $this->priceListCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPriceLists')
            ->willReturn($this->priceLists);

        $this->priceListTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->priceListTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                PriceListCompanyUsersRestApiConfig::RESOURCE_PRICE_LISTS,
                $this->uuid
            )->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('addRelationship')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        $this->priceListsCustomersResourceRelationshipExpander->addResourceRelationships(
            $this->resources,
            $this->restRequestInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testAddResourceRelationshipsPayloadNull(): void
    {
        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getPayload')
            ->willReturn(null);

        $this->priceListsCustomersResourceRelationshipExpander->addResourceRelationships(
            $this->resources,
            $this->restRequestInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testAddResourceRelationshipsPriceListCollectionNull(): void
    {
        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getPayload')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPriceListCollection')
            ->willReturn(null);

        $this->priceListsCustomersResourceRelationshipExpander->addResourceRelationships(
            $this->resources,
            $this->restRequestInterfaceMock
        );
    }
}
