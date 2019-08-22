<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Api;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingResultInterface;

/**
 * Retrieve source data operation
 *
 * @api
 */
interface RetrieveSourceDataInterface
{
    /**
     * Retrieve source data operation
     *
     * @param SourceDataInterface $sourceData
     * @return RetrievingResultInterface
     * @throws RetrievingSourceException
     */
    public function execute(SourceDataInterface $sourceData): RetrievingResultInterface;
}
