<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportAdvancedPricing\Model\ImportDataProcessor;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportApi\Model\ImportDataProcessorInterface;

/**
 * @inheritdoc
 */
class AdvancedPricing implements ImportDataProcessorInterface
{
    /**
     * @inheritdoc
     */
    public function execute(ImportInterface $import, ImportDataInterface $importData): void
    {
        return;
    }
}
