<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\Framework\Validation\ValidationResult;

/**
 * Responsible for Import validation. Extension point for base validation
 *
 * @api
 */
interface ImportValidatorInterface
{
    /**
     * Import validation. Extension point for base validation
     *
     * @param ImportInterface $import
     * @return ValidationResult
     */
    public function validate(ImportInterface $import): ValidationResult;
}
