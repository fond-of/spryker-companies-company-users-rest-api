<?php

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi;

use Codeception\Test\Unit;
use Spryker\Client\Company\CompanyClientInterface;
use Spryker\Client\CompanyUser\CompanyUserClientInterface;
use Spryker\Glue\Kernel\Container;

class CompaniesCompanyUsersRestApiFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\CompaniesCompanyUsersRestApiFactory
     */
    protected $companiesCompanyUsersRestApiFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\CompanyUser\CompanyUserClientInterface
     */
    protected $companyUserClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Company\CompanyClientInterface
     */
    protected $companyClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserClientInterfaceMock = $this->getMockBuilder(CompanyUserClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyClientInterfaceMock = $this->getMockBuilder(CompanyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companiesCompanyUsersRestApiFactory = new CompaniesCompanyUsersRestApiFactory();
        $this->companiesCompanyUsersRestApiFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetCompanyUserClient(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER)
            ->willReturn($this->companyUserClientInterfaceMock);

        $this->assertInstanceOf(
            CompanyUserClientInterface::class,
            $this->companiesCompanyUsersRestApiFactory->getCompanyUserClient()
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyClient(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY)
            ->willReturn($this->companyClientInterfaceMock);

        $this->assertInstanceOf(
            CompanyClientInterface::class,
            $this->companiesCompanyUsersRestApiFactory->getCompanyClient()
        );
    }
}
