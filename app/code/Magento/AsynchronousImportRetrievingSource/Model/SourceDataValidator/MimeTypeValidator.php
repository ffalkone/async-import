<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model\SourceDataValidator;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\SourceDataValidatorInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\Write;
use Magento\Framework\Filesystem\Driver\Http;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\ImportService\Model\Import\SourceTypePool;

/**
 * @inheritdoc
 */
class MimeTypeValidator implements SourceDataValidatorInterface
{
    /**
     * @var \Magento\Framework\Filesystem\Driver\Http
     */
    private $httpDriver;

    /**
     * @var SourceTypePool
     */
    private $sourceTypePool;

    /**
     * @var Mime
     */
    private $mime;

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
     * @param Http $httpDriver
     * @param SourceTypePool $sourceTypePool
     * @param Mime $mime
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        Http $httpDriver,
        SourceTypePool $sourceTypePool,
        Mime $mime,
        File $fileSystemIo,
        Filesystem $fileSystem,
        ValidationResultFactory $validationResultFactory
    ) {
        $this->httpDriver = $httpDriver;
        $this->sourceTypePool = $sourceTypePool;
        $this->mime = $mime;
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

        /** @var $mimeType */
        $mimeType = false;

        /** validate import source for remote url or local path */
        if (filter_var($sourceData->getSourceData(), FILTER_VALIDATE_URL)) {
            /** check empty variable */
            $importData = $sourceData->getSourceData();

            if (isset($importData) && $importData !== '') {
                $externalSourceUrl = preg_replace('(^https?://)', '', $importData);

                /** check for file exists */
                if ($this->httpDriver->isExists($externalSourceUrl)) {
                    /** @var array $stat */
                    $stat = $this->httpDriver->stat($externalSourceUrl);
                    if (isset($stat['type'])) {
                        $mimeType = $stat['type'];
                    }
                }
            }
        } else {
            /** @var Write $write */
            $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

            /** create absolute path */
            $absoluteFilePath = $write->getAbsolutePath($sourceData->getSourceData());

            /** check if file exist */
            if ($this->fileSystemIo->fileExists($absoluteFilePath)) {
                $mimeType = $this->mime->getMimeType($absoluteFilePath);
            }
        }

        if ($mimeType) {
            if (is_array($mimeType)){
                $mimeType = implode(";", $mimeType);
            }
            $mimeType = trim(explode(";", $mimeType)[0]);
            if (!in_array($mimeType, $this->sourceTypePool->getAllowedMimeTypes())) {
                $errors[] = __(
                    'Invalid mime type: %1, expected is one of: %2',
                    $mimeType,
                    implode(', ', $this->sourceTypePool->getAllowedMimeTypes())
                );
            }
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
