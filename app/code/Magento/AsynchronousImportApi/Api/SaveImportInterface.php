<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api;

use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;

/**
 * Save import operation
 *
 * @api
 */
interface SaveImportInterface
{
    /**
     * Save import operation
     *
     * @param ImportInterface $import
     * @return void
     * @throws ValidationException
     * @throws CouldNotSaveException
     */
    public function execute(ImportInterface $import): void;
}
