<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Source;

use Exception;
use Magento\AsynchronousImport\Model\Source\ResourceModel\Source as SourceResourceModel;
use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportApi\Api\SaveSourceInterface;
use Magento\AsynchronousImportApi\Model\SourceValidatorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class SaveSource implements SaveSourceInterface
{
    /**
     * @var SourceValidatorInterface
     */
    private $sourceValidator;

    /**
     * @var SourceResourceModel
     */
    private $sourceResourceModel;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param SourceValidatorInterface $sourceValidator
     * @param SourceResourceModel $sourceResourceModel
     * @param LoggerInterface $logger
     */
    public function __construct(
        SourceValidatorInterface $sourceValidator,
        SourceResourceModel $sourceResourceModel,
        LoggerInterface $logger
    ) {
        $this->sourceValidator = $sourceValidator;
        $this->sourceResourceModel = $sourceResourceModel;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceInterface $source): void
    {
        $validationResult = $this->sourceValidator->validate($source);

        if (!$validationResult->isValid()) {
            throw new ValidationException(__('Validation Failed'), null, 0, $validationResult);
        }

        try {
            $this->sourceResourceModel->save($source);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('Could not save Source'), $e);
        }
    }
}
