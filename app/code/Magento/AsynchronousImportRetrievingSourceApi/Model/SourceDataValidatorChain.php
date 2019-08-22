<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * Extension point for validation of new source data types via di configuration
 *
 * @api
 */
class SourceDataValidatorChain implements SourceDataValidatorInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var SourceDataValidatorInterface[]
     */
    private $validators;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ValidationResultFactory $validationResultFactory
     * @param array $validators
     * @throws RetrievingSourceException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ValidationResultFactory $validationResultFactory,
        array $validators = []
    ) {
        $this->objectManager = $objectManager;
        $this->validationResultFactory = $validationResultFactory;
        foreach ($validators as $validator) {
            if (!$validator instanceof SourceDataValidatorInterface) {
                throw new RetrievingSourceException(
                    __('Validator must implement ' . SourceDataValidatorInterface::class . '.')
                );
            }
        }
        $this->validators = $validators;
    }

    /**
     * @inheritdoc
     */
    public function validate(SourceDataInterface $sourceData): ValidationResult
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            $validationResult = $validator->validate($sourceData);

            if (!$validationResult->isValid()) {
                $errors[] = $validationResult->getErrors();
            }
        }
        $errors = count($errors) ? array_merge(...$errors) : [];
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
