<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model\SourceDataValidator;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\SourceDataValidatorInterface;
use Magento\Framework\Filesystem\Driver\Http as HttpDriver;
use Magento\Framework\Filesystem\Driver\Http;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class RemoteUrlValidator implements SourceDataValidatorInterface
{
    /**
     * @var HttpDriver
     */
    private $httpDriver;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @param Http $httpDriver
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        Http $httpDriver,
        ValidationResultFactory $validationResultFactory
    ) {
        $this->httpDriver = $httpDriver;
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * @inheritdoc
     */
    public function validate(SourceDataInterface $sourceData): ValidationResult
    {
        $errors = [];

        /** check empty variable */
        $sourceData = $sourceData->getSourceData();

        if (!empty($sourceData)) {
            $externalSourceUrl = preg_replace('(^https?://)', '', $sourceData);

            /** check for file exists */
            if (!$this->httpDriver->isExists($externalSourceUrl)) {
                $errors[] = __('Remote file %1 does not exist.', $sourceData);
            }
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
