<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportApi\Api\StartImportInterface;

/**
 * @inheritdoc
 */
class StartImport implements StartImportInterface
{
    /**
     * @inheritdoc
     */
    public function execute(ImportInterface $import): void
    {
    }
}
