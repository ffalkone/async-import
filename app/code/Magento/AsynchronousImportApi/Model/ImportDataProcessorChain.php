<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportApi\Api\ImportException;
use Magento\Framework\ObjectManagerInterface;

/**
 * Chain of import data processors. Extension point for new import types
 *
 * @api
 */
class ImportDataProcessorChain implements ImportDataProcessorInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var array
     */
    private $processors;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $processors
     * @throws ImportException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        array $processors = []
    ) {
        $this->objectManager = $objectManager;
        foreach ($processors as $processor) {
            if (false === is_subclass_of($processor, ImportDataProcessorInterface::class)) {
                throw new ImportException(
                    __('%1 must implement %2.', [$processor, ImportDataProcessorInterface::class])
                );
            }
        }
        $this->processors = $processors;
    }

    /**
     * @inheritdoc
     */
    public function execute(ImportInterface $import, ImportDataInterface $importData): void
    {
        if (!isset($this->processors[$import->getImportType()])) {
            throw new ImportException(
                __('Import type %1 is not supported.', $import->getImportType())
            );
        }
        /** @var ImportDataProcessorInterface $processor */
        $processor = $this->objectManager->get($this->processors[$import->getImportType()]);
        $processor->execute($import, $importData);
    }
}
