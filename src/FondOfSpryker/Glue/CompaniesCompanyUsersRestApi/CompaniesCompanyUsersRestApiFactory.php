<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi;

use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\CompanyUser\CompanyUserReader;
use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\CompanyUser\CompanyUserReaderInterface;
use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\Mapper\CompaniesCompanyUsersMapper;
use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\Mapper\CompaniesCompanyUsersMapperInterface;
use Spryker\Client\Company\CompanyClientInterface;
use Spryker\Client\CompanyUser\CompanyUserClientInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Client\CompaniesRestApi\CompaniesRestApiClientInterface getClient()
 */
class CompaniesCompanyUsersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\CompanyUser\CompanyUserReaderInterface
     */
    public function createCompanyUsersReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getResourceBuilder(),
            $this->createCompaniesCompanyUsersMapper(),
            $this->getCompanyUserClient(),
            $this->getCompanyClient()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\Mapper\CompaniesCompanyUsersMapperInterface
     */
    public function createCompaniesCompanyUsersMapper(): CompaniesCompanyUsersMapperInterface
    {
        return new CompaniesCompanyUsersMapper(
            $this->getResourceBuilder()
        );
    }

    /**

     * @return \Spryker\Client\CompanyUser\CompanyUserClientInterface
     */
    public function getCompanyUserClient(): CompanyUserClientInterface
    {
        return $this->getProvidedDependency(CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER);
    }

    /**
     * @return \Spryker\Client\Company\CompanyClientInterface
     */
    public function getCompanyClient(): CompanyClientInterface
    {
        return $this->getProvidedDependency(CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY);
    }
}
