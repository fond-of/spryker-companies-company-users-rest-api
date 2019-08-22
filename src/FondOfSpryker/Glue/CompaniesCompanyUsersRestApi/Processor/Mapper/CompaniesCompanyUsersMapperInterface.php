<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

interface CompaniesCompanyUsersMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function mapCompanyUsersResource(
        CompanyUserTransfer $companyUserTransfer
    ): RestResourceInterface;
}
