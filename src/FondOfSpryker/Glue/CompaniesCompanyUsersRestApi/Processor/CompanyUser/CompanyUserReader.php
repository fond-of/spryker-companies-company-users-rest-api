<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\CompanyUser;

use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\Mapper\CompaniesCompanyUsersMapperInterface;
use FondOfSpryker\Glue\CompaniesRestApi\CompaniesRestApiConfig;
use FondOfSpryker\Shared\CompaniesCompanyUsersRestApi\CompaniesCompanyUsersRestApiConfig;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Client\Company\CompanyClientInterface;
use Spryker\Client\CompanyUser\CompanyUserClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\Response;

final class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    private $restResourceBuilder;

    /**
     * @var \Spryker\Client\CompanyUser\CompanyUserClientInterface
     */
    private $companyUserClient;

    /**
     * @var \FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\Mapper\CompaniesCompanyUsersMapperInterface
     */
    private $companiesCompanyUsersMapper;

    /**
     * @var \Spryker\Client\Company\CompanyClientInterface
     */
    private $companyClient;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\Mapper\CompaniesCompanyUsersMapperInterface $companiesCompanyUsersMapper
     * @param \Spryker\Client\CompanyUser\CompanyUserClientInterface $companyUserClient
     * @param \Spryker\Client\Company\CompanyClientInterface $companyClient
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompaniesCompanyUsersMapperInterface $companiesCompanyUsersMapper,
        CompanyUserClientInterface $companyUserClient,
        CompanyClientInterface $companyClient
    ) {
        $this->companyUserClient = $companyUserClient;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companiesCompanyUsersMapper = $companiesCompanyUsersMapper;
        $this->companyClient = $companyClient;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function findCompanyUsersByCompanyId(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        if ($restRequest->getRestUser() === null) {
            return $this->addAccessDeniedError($restResponse);
        }

        $companyTransfer = new CompanyTransfer();
        $companyTransfer->setUuid($this->findCompanyUserIdentifier($restRequest));
        $companyResponseTransfer = $this->companyClient->findCompanyByUuid($companyTransfer);

        if (!$companyResponseTransfer->getIsSuccessful() || $companyResponseTransfer->getCompanyTransfer() === null) {
            return $this->addCompanyNotFoundError($restResponse);
        }

        $companyUserFilter = new CompanyUserCriteriaFilterTransfer();
        $companyUserFilter->setIdCompany($companyResponseTransfer->getCompanyTransfer()->getIdCompany());

        $companyUserCollectionTransfer = $this->companyUserClient->getCompanyUserCollection($companyUserFilter);
        foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUser) {
            $resource = $this->companiesCompanyUsersMapper
                ->mapCompanyUsersResource($companyUser)
                ->setPayload($companyUser);

            $restResponse->addResource($resource);
        }

        return $restResponse;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string|null
     */
    protected function findCompanyUserIdentifier(RestRequestInterface $restRequest): ?string
    {
        $companyResource = $restRequest->findParentResourceByType(CompaniesRestApiConfig::RESOURCE_COMPANIES);
        if ($companyResource !== null) {
            return $companyResource->getId();
        }

        return null;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addAccessDeniedError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompaniesCompanyUsersRestApiConfig::RESPONSE_CODE_ACCESS_DENIED)
            ->setStatus(Response::HTTP_FORBIDDEN)
            ->setDetail(CompaniesCompanyUsersRestApiConfig::RESPONSE_DETAILS_ACCESS_DENIED);

        return $restResponse->addError($restErrorTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addCompanyNotFoundError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompaniesCompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_NOT_FOUND)
            ->setStatus(Response::HTTP_FORBIDDEN)
            ->setDetail(CompaniesCompanyUsersRestApiConfig::RESPONSE_COMPANY_NOT_FOUND);

        return $restResponse->addError($restErrorTransfer);
    }
}
