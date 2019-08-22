<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api;

use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;

/**
 * Save source operation
 *
 * @api
 */
interface SaveSourceInterface
{
    /**
     * Save source operation
     *
     * @param SourceInterface $source
     * @return void
     * @throws ValidationException
     * @throws CouldNotSaveException
     */
     public function execute(SourceInterface $source): void;
}
