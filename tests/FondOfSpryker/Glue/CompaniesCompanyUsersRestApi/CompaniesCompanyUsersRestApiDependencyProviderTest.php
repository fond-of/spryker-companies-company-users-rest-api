<?php

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi;

use Codeception\Test\Unit;
use Spryker\Client\Company\CompanyClientInterface;
use Spryker\Client\CompanyUser\CompanyUserClientInterface;
use Spryker\Glue\Kernel\Container;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Locator;

class CompaniesCompanyUsersRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\CompaniesCompanyUsersRestApiDependencyProvider
     */
    protected $companiesCompanyUsersRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Locator
     */
    protected $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Company\CompanyClientInterface
     */
    protected $companyClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\CompanyUser\CompanyUserClientInterface
     */
    protected $companyUserClientMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'offsetSet', 'offsetGet', 'set', 'get'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyClientMock = $this->getMockBuilder(CompanyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserClientMock = $this->getMockBuilder(CompanyUserClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companiesCompanyUsersRestApiDependencyProvider = new CompaniesCompanyUsersRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companiesCompanyUsersRestApiDependencyProvider->provideDependencies(
                $this->containerMock
            )
        );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('__call')
            ->withConsecutive(
                ['companyUser'],
                ['company']
            )
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('client')
            ->willReturnOnConsecutiveCalls(
                $this->companyUserClientMock,
                $this->companyClientMock
            );

        $this->assertInstanceOf(
            CompanyUserClientInterface::class,
            $this->containerMock[CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER]
        );

        $this->assertInstanceOf(
            CompanyClientInterface::class,
            $this->containerMock[CompaniesCompanyUsersRestApiDependencyProvider::CLIENT_COMPANY]
        );

        $this->assertIsArray(
            $this->containerMock[CompaniesCompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_SEARCH_VALIDATOR]
        );
    }
}
