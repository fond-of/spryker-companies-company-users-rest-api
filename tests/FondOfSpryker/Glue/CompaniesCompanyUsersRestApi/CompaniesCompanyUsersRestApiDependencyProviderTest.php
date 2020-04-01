<?php

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\Container;

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
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
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
    }
}
