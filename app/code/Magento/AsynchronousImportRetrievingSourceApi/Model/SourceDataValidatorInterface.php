<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\Framework\Validation\ValidationResult;

/**
 * Extension point for validation of new source data types via di configuration
 *
 * @api
 */
interface SourceDataValidatorInterface
{
    /**
     * Validate source data
     *
     * @param SourceDataInterface $sourceData
     * @return ValidationResult
     */
    public function validate(SourceDataInterface $sourceData): ValidationResult;
}
