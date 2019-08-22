<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model\SourceDataRetrieving;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingResultInterfaceFactory;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\SourceDataValidatorInterface;

/**
 * Base64 encoded data processor for asynchronous import
 */
class Base64EncodedData implements RetrieveSourceDataInterface
{
    /**
     * @var SourceDataValidatorInterface
     */
    private $sourceDataValidator;

    /**
     * @var RetrievingResultInterfaceFactory
     */
    private $retrievingResultFactory;

    /**
     * @param SourceDataValidatorInterface $sourceDataValidator
     * @param RetrievingResultInterfaceFactory $retrievingResultFactory
     */
    public function __construct(
        SourceDataValidatorInterface $sourceDataValidator,
        RetrievingResultInterfaceFactory $retrievingResultFactory
    ) {
        $this->sourceDataValidator = $sourceDataValidator;
        $this->retrievingResultFactory = $retrievingResultFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceDataInterface $sourceData): RetrievingResultInterface
    {
        $validationResult = $this->sourceDataValidator->validate($sourceData);
        if (!$validationResult->isValid()) {
            return $this->createResult(
                RetrievingResultInterface::STATUS_FAILED,
                null,
                $validationResult->getErrors()
            );
        }

        $content = base64_decode($sourceData->getSourceData());

        return $this->createResult(RetrievingResultInterface::STATUS_SUCCESS, $content);
    }

    /**
     * Create retrieving source data result
     *
     * @param string $status
     * @param string|null $file
     * @param array $errors
     * @return RetrievingResultInterface
     */
    private function createResult(string $status, ?string $file, array $errors = []): RetrievingResultInterface
    {
        $data = [
            RetrievingResultInterface::STATUS => $status,
            RetrievingResultInterface::FILE => $file,
            RetrievingResultInterface::ERRORS => $errors,
        ];
        return $this->retrievingResultFactory->create($data);
    }
}
