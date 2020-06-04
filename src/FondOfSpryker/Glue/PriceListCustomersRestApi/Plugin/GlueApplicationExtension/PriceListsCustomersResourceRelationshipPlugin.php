<?php

namespace FondOfSpryker\Glue\PriceListCustomersRestApi\Plugin\GlueApplicationExtension;

use FondOfSpryker\Glue\PriceListCustomersRestApi\PriceListCustomersRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRelationshipPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Glue\PriceListCustomersRestApi\PriceListCustomersRestApiFactory getFactory()
 */
class PriceListsCustomersResourceRelationshipPlugin extends AbstractPlugin implements ResourceRelationshipPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[] $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        $this->getFactory()
            ->createPriceListsCustomersResourceRelationshipExpander()
            ->addResourceRelationships($resources, $restRequest);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getRelationshipResourceType(): string
    {
        return PriceListCustomersRestApiConfig::RESOURCE_PRICE_LISTS;
    }
}
