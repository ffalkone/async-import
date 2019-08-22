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
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\Write;
use Magento\Framework\Filesystem\Io\File;

/**
 * Files processor for asynchronous import
 */
class LocalFile implements RetrieveSourceDataInterface
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
     * @var SourceDataValidatorInterface
     */
    private $sourceDataValidator;

    /**
     * @var RetrievingResultInterfaceFactory
     */
    private $retrievingResultFactory;

    /**
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param SourceDataValidatorInterface $sourceDataValidator
     * @param RetrievingResultInterfaceFactory $retrievingResultFactory
     */
    public function __construct(
        File $fileSystemIo,
        Filesystem $fileSystem,
        SourceDataValidatorInterface $sourceDataValidator,
        RetrievingResultInterfaceFactory $retrievingResultFactory
    ) {
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
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

        try {
            /** @var Write $write */
            $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);
            /** create absolute path */
            $absoluteSourcePath = $write->getAbsolutePath($sourceData->getSourceData());
            /** read content from system */
            $content = $this->fileSystemIo->read($absoluteSourcePath);
        } catch (ValidatorException $e) {
            return $this->createResult(
                RetrievingResultInterface::STATUS_FAILED,
                null,
                [$e->getMessage()]
            );
        } catch (FileSystemException $e) {
            return $this->createResult(
                RetrievingResultInterface::STATUS_FAILED,
                null,
                [$e->getMessage()]
            );
        }

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
