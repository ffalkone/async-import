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
     * @var array
     */
    private $allowedMimeTypes;

    /**
     * @param Http $httpDriver
     * @param Mime $mime
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        Http $httpDriver,
        Mime $mime,
        File $fileSystemIo,
        Filesystem $fileSystem,
        ValidationResultFactory $validationResultFactory,
        array $allowedMimeTypes = []
    ) {
        $this->httpDriver = $httpDriver;
        $this->mime = $mime;
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
        $this->validationResultFactory = $validationResultFactory;
        $this->allowedMimeTypes = $allowedMimeTypes;
    }

    /**
     * @inheritdoc
     */
    public function validate(SourceDataInterface $sourceData): ValidationResult
    {
        $errors = [];
        $mimeType = $this->getMimeType($sourceData);
        if ($mimeType) {
            if (is_array($mimeType)) {
                $mimeType = implode(";", $mimeType);
            }
            $mimeType = trim(explode(";", $mimeType)[0]);
            if (!isset($this->allowedMimeTypes[$sourceData->getSourceFormat()]) ||
                !in_array($mimeType, $this->allowedMimeTypes[$sourceData->getSourceFormat()])) {
                $errors[] = __(
                    'Invalid mime type: %1, expected is one of: %2',
                    $mimeType,
                    ''
                );
            }
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }

    /**
     * Get mime type
     *
     * @param SourceDataInterface $sourceData
     * @return bool|string
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    private function getMimeType(SourceDataInterface $sourceData)
    {
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
        return $mimeType;
    }
}
