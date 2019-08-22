<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model\SourceDataValidator;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\SourceDataValidatorInterface;
use Magento\Framework\Filesystem\Directory\Write;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class LocalPathValidator implements SourceDataValidatorInterface
{
    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        File $fileSystemIo,
        Filesystem $fileSystem,
        ValidationResultFactory $validationResultFactory
    ) {
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * @inheritdoc
     */
    public function validate(SourceDataInterface $sourceData): ValidationResult
    {
        $errors = [];

        /** @var Write $write */
        $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

        /** create absolute path */
        $absoluteFilePath = $write->getAbsolutePath($sourceData->getSourceData());

        /** check if file exist */
        if (!$this->fileSystemIo->fileExists($absoluteFilePath)) {
            $errors[] = __('Local file %1 does not exist.', $sourceData->getSourceData());
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
