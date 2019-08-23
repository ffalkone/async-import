<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api;

use Magento\AsynchronousImportApi\Api\Data\ImportStatusInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Get import status operation
 *
 * @api
 */
interface GetImportStatusInterface
{
    /**
     * Get import status operation
     *
     * @param string $uuid
     * @return void
     * @throws NotFoundException
     */
    public function execute(string $uuid): ImportStatusInterface;
}
