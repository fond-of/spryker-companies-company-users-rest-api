<?php

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Controller;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\CompaniesCompanyUsersRestApiFactory;
use FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\CompanyUser\CompanyUserReaderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CompaniesCompanyUsersResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\CompaniesCompanyUsersRestApiFactory
     */
    protected $companiesCompanyUsersRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Processor\CompanyUser\CompanyUserReaderInterface
     */
    protected $companyUserReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfSpryker\Glue\CompaniesCompanyUsersRestApi\Controller\CompaniesCompanyUsersResourceController
     */
    protected $companiesCompanyUsersResourceController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companiesCompanyUsersRestApiFactoryMock = $this->getMockBuilder(CompaniesCompanyUsersRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companiesCompanyUsersResourceController = new class ($this->companiesCompanyUsersRestApiFactoryMock) extends CompaniesCompanyUsersResourceController {
            /**
             * @var \Spryker\Glue\Kernel\AbstractFactory
             */
            protected $factory;

            /**
             *  constructor.
             *
             * @param \Spryker\Glue\Kernel\AbstractFactory $factory
             */
            public function __construct(AbstractFactory $factory)
            {
                $this->factory = $factory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            public function getFactory(): AbstractFactory
            {
                return $this->factory;
            }
        };
    }

    /**
     * @return void
     */
    public function testGetAction(): void
    {
        $this->companiesCompanyUsersRestApiFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUsersReader')
            ->willReturn($this->companyUserReaderMock);

        $this->companyUserReaderMock->expects($this->atLeastOnce())
            ->method('findCompanyUsersByCompanyId')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        $restResponse = $this->companiesCompanyUsersResourceController->getAction($this->restRequestMock);

        $this->assertEquals($this->restResponseMock, $restResponse);
    }
}
