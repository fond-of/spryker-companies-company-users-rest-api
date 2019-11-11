<?php

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Plugin;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\CompaniesCompanyUsersRestApiConfig;
use FondOfSpryker\Glue\CompaniesRestApi\CompaniesRestApiConfig;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CompaniesCompanyUsersResourceRoutePluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Plugin\CompaniesCompanyUsersResourceRoutePlugin
     */
    protected $companiesCompanyUsersResourceRoutePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resourceRouteCollectionInterfaceMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companiesCompanyUsersResourceRoutePlugin = new CompaniesCompanyUsersResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addGet')
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->assertInstanceOf(
            ResourceRouteCollectionInterface::class,
            $this->companiesCompanyUsersResourceRoutePlugin->configure(
                $this->resourceRouteCollectionInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->assertSame(
            CompaniesCompanyUsersRestApiConfig::RESOURCE_COMPANIES_COMPANY_USERS,
            $this->companiesCompanyUsersResourceRoutePlugin->getResourceType()
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertSame(
            CompaniesCompanyUsersRestApiConfig::CONTROLLER_COMPANIES_COMPANY_USER,
            $this->companiesCompanyUsersResourceRoutePlugin->getController()
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertSame(
            RestCompanyUsersRequestAttributesTransfer::class,
            $this->companiesCompanyUsersResourceRoutePlugin->getResourceAttributesClassName()
        );
    }

    /**
     * @return void
     */
    public function testGetParentResourceType(): void
    {
        $this->assertSame(
            CompaniesRestApiConfig::RESOURCE_COMPANIES,
            $this->companiesCompanyUsersResourceRoutePlugin->getParentResourceType()
        );
    }
}
