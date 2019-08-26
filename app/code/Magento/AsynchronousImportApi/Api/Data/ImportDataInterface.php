<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api\Data;

/**
 * Represents Import data
 *
 * @api
 */
interface ImportDataInterface
{
    public const DATA = 'data';

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array;
}
