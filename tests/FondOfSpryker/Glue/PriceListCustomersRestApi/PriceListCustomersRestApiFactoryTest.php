<?php

namespace FondOfSpryker\Glue\PriceListCustomersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander\PriceListsCustomersResourceRelationshipExpanderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;

class PriceListCustomersRestApiFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PriceListCustomersRestApi\PriceListCustomersRestApiFactory
     */
    protected $priceListCustomersRestApiFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceBuilderInterfaceMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCustomersRestApiFactory = new class (
         $this->restResourceBuilderInterfaceMock
            ) extends PriceListCustomersRestApiFactory {
            /**
             * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            protected $restResourceBuilder;

            /**
             * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
             */
            public function __construct(RestResourceBuilderInterface $restResourceBuilder)
            {
                $this->restResourceBuilder = $restResourceBuilder;
            }

            /**
             * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            public function getResourceBuilder(): RestResourceBuilderInterface
            {
                return $this->restResourceBuilder;
            }
        };
    }

    /**
     * @return void
     */
    public function testCreatePriceListsCustomersResourceRelationshipExpander(): void
    {
        $this->assertInstanceOf(
            PriceListsCustomersResourceRelationshipExpanderInterface::class,
            $this->priceListCustomersRestApiFactory->createPriceListsCustomersResourceRelationshipExpander()
        );
    }
}
