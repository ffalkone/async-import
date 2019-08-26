<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import\Validator;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportApi\Model\ImportValidatorInterface;
// TODO: remove dependency
use Ramsey\Uuid\Uuid;

/**
 * Check that "source_uuid" value is valid
 */
class SourceUuidValidator implements ImportValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(ValidationResultFactory $validationResultFactory)
    {
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * @inheritdoc
     */
    public function validate(ImportInterface $import): ValidationResult
    {
        $value = (string)$import->getSourceUuid();

        if ('' === trim($value)) {
            $errors[] = __('"%field" can not be empty.', ['field' => ImportInterface::SOURCE_UUID]);
        } elseif (!Uuid::isValid($value)) {
            $errors[] = __('"The uuid "%uuid" is not valid.', ['uuid' => $value]);
        } else {
            $errors = [];
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
