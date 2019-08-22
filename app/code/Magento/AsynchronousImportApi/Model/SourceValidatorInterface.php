<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model;

use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\Framework\Validation\ValidationResult;

/**
 * Responsible for Source validation. Extension point for base validation
 *
 * @api
 */
interface SourceValidatorInterface
{
    /**
     * Source validation. Extension point for base validation
     *
     * @param SourceInterface $source
     * @return ValidationResult
     */
    public function validate(SourceInterface $source): ValidationResult;
}
