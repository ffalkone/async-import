<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api;

use Magento\Framework\Exception\NotFoundException;

/**
 * Get import operation
 *
 * @api
 */
interface GetImportStatusInterface
{
    /**
     * Get import operation
     *
     * @param string $uuid
     * @return void
     * @throws NotFoundException
     */
    public function execute(string $uuid): void;
}
