<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import;

use Exception;
use Magento\AsynchronousImport\Model\Import\ResourceModel\Import as ImportResourceModel;
use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportApi\Api\SaveImportInterface;
use Magento\AsynchronousImportApi\Model\ImportValidatorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class SaveImport implements SaveImportInterface
{
    /**
     * @var ImportValidatorInterface
     */
    private $importValidator;

    /**
     * @var ImportResourceModel
     */
    private $importResourceModel;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ImportValidatorInterface $importValidator
     * @param ImportResourceModel $importResourceModel
     * @param LoggerInterface $logger
     */
    public function __construct(
        ImportValidatorInterface $importValidator,
        ImportResourceModel $importResourceModel,
        LoggerInterface $logger
    ) {
        $this->importValidator = $importValidator;
        $this->importResourceModel = $importResourceModel;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(ImportInterface $import): void
    {
        $validationResult = $this->importValidator->validate($import);

        if (!$validationResult->isValid()) {
            throw new ValidationException(__('Validation Failed'), null, 0, $validationResult);
        }

        try {
            $this->importResourceModel->save($import);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('Could not save Import'), $e);
        }
    }
}
