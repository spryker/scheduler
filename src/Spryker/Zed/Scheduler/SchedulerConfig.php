<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Scheduler;

use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class SchedulerConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const ROLE_ADMIN = 'admin';

    /**
     * @var string
     */
    public const ROLE_REPORTING = 'reporting';

    /**
     * @var string
     */
    public const ROLE_EMPTY = 'empty';

    /**
     * Specification:
     * - Returns the path to PHP file to retrieve schedule for particular scheduler
     *
     * @api
     *
     * @param string $idScheduler
     *
     * @return string
     */
    public function getPhpSchedulerReaderPath(string $idScheduler): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            APPLICATION_ROOT_DIR,
            'config',
            'Zed',
            'cronjobs',
            $idScheduler . '.php',
        ]);
    }

    /**
     * @api
     *
     * @return array<string>
     */
    public function getRoles(): array
    {
        return [
            static::ROLE_ADMIN,
            static::ROLE_REPORTING,
            static::ROLE_EMPTY,
        ];
    }

    /**
     * @api
     *
     * @return string
     */
    public function getDefaultRole(): string
    {
        return static::ROLE_ADMIN;
    }

    /**
     * @api
     *
     * @return array<string>
     */
    public function getEnabledSchedulers(): array
    {
        return $this->get(SchedulerConstants::ENABLED_SCHEDULERS, []);
    }

    /**
     * Specification:
     * - Returns current region if defined.
     *
     * @api
     *
     * @return string|null
     */
    public function getCurrentRegion(): ?string
    {
        if (defined('APPLICATION_REGION')) {
            return APPLICATION_REGION;
        }

        return null;
    }

    /**
     * Specification:
     * - Checks if job region is required.
     *
     * @api
     *
     * @return bool
     */
    public function isJobRegionRequired(): bool
    {
        return (bool)getenv('SPRYKER_DYNAMIC_STORE_MODE');
    }
}
