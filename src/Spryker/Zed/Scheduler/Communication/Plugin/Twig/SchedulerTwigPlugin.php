<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Scheduler\Communication\Plugin\Twig;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\TwigExtension\Dependency\Plugin\TwigPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Twig\Environment;
use Twig\TwigFunction;

/**
 * @method \Spryker\Zed\Scheduler\SchedulerConfig getConfig()
 * @method \Spryker\Zed\Scheduler\Business\SchedulerFacadeInterface getFacade()
 * @method \Spryker\Zed\Scheduler\Communication\SchedulerCommunicationFactory getFactory()
 */
class SchedulerTwigPlugin extends AbstractPlugin implements TwigPluginInterface
{
    public const GET_ENV_FUNCTION_NAME = 'getenv';

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Twig\Environment $twig
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Twig\Environment
     */
    public function extend(Environment $twig, ContainerInterface $container): Environment
    {
        $twig->addFunction($this->getEnvironmentVariableValueByNameFunction());

        return $twig;
    }

    /**
     * @api
     *
     * @return \Twig\TwigFunction
     */
    public function getEnvironmentVariableValueByNameFunction(): TwigFunction
    {
        return new TwigFunction(static::GET_ENV_FUNCTION_NAME, function (string $which) {
            return $this->getEnvironmentVariableValueByName($which);
        });
    }

    /**
     * @api
     *
     * @param string $which
     *
     * @return string|false
     */
    public function getEnvironmentVariableValueByName(string $which)
    {
        return getenv($which);
    }
}