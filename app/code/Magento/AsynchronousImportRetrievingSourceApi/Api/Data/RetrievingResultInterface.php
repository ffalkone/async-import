<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Api\Data;

/**
 * Represents Source Data retrieving result
 *
 * @api
 */
interface RetrievingResultInterface
{
    public const STATUS = 'status';
    public const ERRORS = 'errors';
    public const FILE = 'file';

    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';

    /**
     * Get status
     *
     * @return string One of const self::STATUS_*
     */
    public function getStatus(): string;

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors(): array;

    /**
     * Get file
     *
     * @return string|null
     */
    public function getFile(): ?string;
}
