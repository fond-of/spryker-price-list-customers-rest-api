<?php

namespace FondOfSpryker\Glue\PriceListCustomersRestApi\Processor\Expander;

use FondOfSpryker\Glue\PriceListCompanyUsersRestApi\PriceListCompanyUsersRestApiConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestPriceListAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PriceListsCustomersResourceRelationshipExpander implements PriceListsCustomersResourceRelationshipExpanderInterface
{
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
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[] $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        foreach ($resources as $resource) {
            /**
             * @var \Generated\Shared\Transfer\CustomerTransfer|null $payload
             */
            $payload = $resource->getPayload();

            if ($payload === null || !($payload instanceof CustomerTransfer)) {
                continue;
            }

            $priceListCollectionTransfer = $payload->getPriceListCollection();

            if ($priceListCollectionTransfer === null) {
                continue;
            }

            foreach ($priceListCollectionTransfer->getPriceLists() as $priceListTransfer) {
                $restPriceListAttributesTransfer = (new RestPriceListAttributesTransfer())->fromArray(
                    $priceListTransfer->toArray(),
                    true
                );

                $priceListResource = $this->restResourceBuilder->createRestResource(
                    PriceListCompanyUsersRestApiConfig::RESOURCE_PRICE_LISTS,
                    $priceListTransfer->getUuid(),
                    $restPriceListAttributesTransfer
                );

                $resource->addRelationship($priceListResource);
            }
        }
    }
}
