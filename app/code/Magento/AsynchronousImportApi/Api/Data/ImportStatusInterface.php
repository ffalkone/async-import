<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api\Data;

/**
 * Represents import status
 *
 * @api
 */
interface ImportStatusInterface
{
    public const STATUS = 'status';
    public const ERRORS = 'errors';
    public const STARTED_AT = 'created_at';
    public const FINISHED_AT = 'finished_at';

    public const STATUS_RUNNING = 'running';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAIL = 'fail';

    /**
     * @return string One of const STATUS_*
     */
    public function getStatus(): string;

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Get finished at
     *
     * @return string|null
     */
    public function getFinishedAt(): ?string;
}
