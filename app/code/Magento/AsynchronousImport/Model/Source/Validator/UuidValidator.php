<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Source\Validator;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportApi\Model\SourceValidatorInterface;
use Ramsey\Uuid\Uuid;

/**
 * Check that "uuid" value is valid
 */
class UuidValidator implements SourceValidatorInterface
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
    public function validate(SourceInterface $source): ValidationResult
    {
        $value = (string)$source->getUuid();

        if ('' === trim($value)) {
            $errors[] = __('"%field" can not be empty.', ['field' => SourceInterface::UUID]);
        } elseif (!Uuid::isValid($value)) {
            $errors[] = __('"The uuid "%uuid" is not valid.', ['uuid' => $value]);
        } else {
            $errors = [];
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
