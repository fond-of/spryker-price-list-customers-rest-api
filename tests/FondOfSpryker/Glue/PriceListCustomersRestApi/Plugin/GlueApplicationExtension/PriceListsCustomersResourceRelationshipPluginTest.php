<?php

namespace FondOfSpryker\Glue\PriceListCustomersRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\PriceListCustomersRestApi\PriceListCustomersRestApiConfig;
use FondOfSpryker\Glue\PriceListCustomersRestApi\PriceListCustomersRestApiFactory;
use FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander\PriceListsCustomersResourceRelationshipExpanderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class PriceListsCustomersResourceRelationshipPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PriceListCustomersRestApi\Plugin\GlueApplicationExtension\PriceListsCustomersResourceRelationshipPlugin
     */
    protected $priceListsCustomersResourceRelationshipPlugin;

    /**
     * @var array
     */
    protected $resources;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\PriceListCustomersRestApi\PriceListCustomersRestApiFactory
     */
    protected $priceListCustomersRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander\PriceListsCustomersResourceRelationshipExpanderInterface
     */
    protected $priceListsCustomersResourceRelationshipExpanderInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceListsCustomersResourceRelationshipExpanderInterfaceMock = $this->getMockBuilder(PriceListsCustomersResourceRelationshipExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCustomersRestApiFactoryMock = $this->getMockBuilder(PriceListCustomersRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resources = [];

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceInterfaceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListsCustomersResourceRelationshipPlugin = new class (
            $this->priceListCustomersRestApiFactoryMock
        ) extends PriceListsCustomersResourceRelationshipPlugin {
            /**
             * @var \FondOfSpryker\Glue\PriceListCustomersRestApi\PriceListCustomersRestApiFactory
             */
            protected $priceListCustomersRestApiFactory;

            /**
             * @param \FondOfSpryker\Glue\PriceListCustomersRestApi\PriceListCustomersRestApiFactory $priceListCustomersRestApiFactory
             */
            public function __construct(PriceListCustomersRestApiFactory $priceListCustomersRestApiFactory)
            {
                $this->priceListCustomersRestApiFactory = $priceListCustomersRestApiFactory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            protected function getFactory(): AbstractFactory
            {
                return $this->priceListCustomersRestApiFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testAddResourceRelationships(): void
    {
        $this->priceListCustomersRestApiFactoryMock->expects($this->atLeastOnce())
            ->method('createPriceListsCustomersResourceRelationshipExpander')
            ->willReturn($this->priceListsCustomersResourceRelationshipExpanderInterfaceMock);

        $this->priceListsCustomersResourceRelationshipExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('addResourceRelationships')
            ->with($this->resources, $this->restRequestInterfaceMock);

        $this->priceListsCustomersResourceRelationshipPlugin->addResourceRelationships(
            $this->resources,
            $this->restRequestInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testGetRelationshipResourceType(): void
    {
        $this->assertSame(
            PriceListCustomersRestApiConfig::RESOURCE_PRICE_LISTS,
            $this->priceListsCustomersResourceRelationshipPlugin->getRelationshipResourceType()
        );
    }
}
