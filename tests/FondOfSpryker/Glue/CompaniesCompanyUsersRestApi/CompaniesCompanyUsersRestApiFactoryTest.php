<?php

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\CompanyUser\CompanyUserReader;
use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\Mapper\CompaniesCompanyUsersMapper;
use Spryker\Client\Company\CompanyClientInterface;
use Spryker\Client\CompanyUser\CompanyUserClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
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
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $restResourceBuilderMock;

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

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserClientInterfaceMock = $this->getMockBuilder(CompanyUserClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyClientInterfaceMock = $this->getMockBuilder(CompanyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companiesCompanyUsersRestApiFactory = new class ($this->restResourceBuilderMock) extends CompaniesCompanyUsersRestApiFactory {
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

        $this->companiesCompanyUsersRestApiFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUsersReader(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER],
                [CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY],
                [CompaniesCompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_SEARCH_VALIDATOR],
            )->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER],
                [CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY],
                [CompaniesCompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_SEARCH_VALIDATOR],
            )
            ->willReturnOnConsecutiveCalls(
                $this->companyUserClientInterfaceMock,
                $this->companyClientInterfaceMock,
                []
            );

        $this->assertInstanceOf(
            CompanyUserReader::class,
            $this->companiesCompanyUsersRestApiFactory->createCompanyUsersReader()
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUsersMapper(): void
    {
        $this->assertInstanceOf(
            CompaniesCompanyUsersMapper::class,
            $this->companiesCompanyUsersRestApiFactory->createCompaniesCompanyUsersMapper()
        );
    }
}
