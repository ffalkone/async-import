<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Api;

use Magento\AsynchronousImportApi\Api\ImportException;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;

/**
 * Create (including retrieving source data) CSV source operation
 *
 * @api
 */
interface CreateCsvSourceInterface
{
    /**
     * Create (including retrieving source data) CSV source operation
     *
     * @param string $uuid
     * @param SourceDataInterface $sourceData
     * @param CsvFormatInterface $format
     * @return void
     * @throws RetrievingSourceException
     * @throws ValidationException
     * @throws CouldNotSaveException
     */
    public function execute(string $uuid, SourceDataInterface $sourceData, CsvFormatInterface $format): void;
}
