<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Api;

use Magento\AsynchronousImportApi\Api\ImportException;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;

/**
 * Update CSV source format operation
 *
 * @api
 */
interface UpdateCsvSourceFormatInterface
{
    /**
     * Update CSV source format operation
     *
     * @param string $uuid
     * @param CsvFormatInterface $format
     * @return void
     * @throws ImportException
     */
    public function execute(string $uuid, CsvFormatInterface $format): void;
}
