<?php

namespace FondOfSpryker\Glue\PriceListCustomersRestApi;

use FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander\PriceListsCustomersResourceRelationshipExpander;
use FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander\PriceListsCustomersResourceRelationshipExpanderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class PriceListCustomersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander\PriceListsCustomersResourceRelationshipExpanderInterface
     */
    public function createPriceListsCustomersResourceRelationshipExpander(): PriceListsCustomersResourceRelationshipExpanderInterface
    {
        return new PriceListsCustomersResourceRelationshipExpander(
            $this->getResourceBuilder()
        );
    }
}
