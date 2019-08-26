<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportApi\Api\ImportException;

/**
 * Responsible for processing (exchange) import data with destination instance. Extension point for new import types
 *
 * @api
 */
interface ImportDataProcessorInterface
{
    /**
     * Responsible for processing (exchange) import data with destination instance. Extension point for new import types
     *
     * @param ImportInterface $import
     * @param ImportDataInterface $importData
     * @return void
     * @throws ImportException
     */
    public function execute(ImportInterface $import, ImportDataInterface $importData): void;
}
