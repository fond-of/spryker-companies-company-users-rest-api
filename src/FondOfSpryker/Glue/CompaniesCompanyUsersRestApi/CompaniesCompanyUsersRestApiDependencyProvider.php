<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompaniesCompanyUsersRestApi;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class CompaniesCompanyUsersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_COMPANY_USER = 'CLIENT_COMPANY_USER';
    public const CLIENT_COMPANY = 'CLIENT_COMPANY';

    public const COMPANY_USER_SEARCH_VALIDATOR_PLUGINS = 'COMPANY_USER_SEARCH_VALIDATOR_PLUGINS';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addCompanyUserClient($container);
        $container = $this->addCompanyClient($container);
        $container = $this->addCompanyUserSearchValidatorPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyUserClient(Container $container): Container
    {
        $container[static::CLIENT_COMPANY_USER] = static function (Container $container) {
            return $container->getLocator()->companyUser()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyClient(Container $container): Container
    {
        $container[static::CLIENT_COMPANY] = static function (Container $container) {
            return $container->getLocator()->company()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyUserSearchValidatorPlugins(Container $container): Container
    {
        $container[self::COMPANY_USER_SEARCH_VALIDATOR_PLUGINS] = function () {
            return $this->getCompanyUserSearchValidatorPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Glue\CompaniesCompanyUsersRestApiExtension\Dependency\Plugin\CompanyCompanyUserSearchValidatorPluginInterface[]
     */
    protected function getCompanyUserSearchValidatorPlugins(): array
    {
        return [];
    }
}
