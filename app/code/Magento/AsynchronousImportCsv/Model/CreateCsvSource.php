<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportApi\Api\Data\SourceInterfaceFactory;
use Magento\AsynchronousImportApi\Api\SaveSourceInterface;
use Magento\AsynchronousImportCsvApi\Api\CreateCsvSourceInterface;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * @inheritdoc
 */
class CreateCsvSource implements CreateCsvSourceInterface
{
    /**
     * @var RetrieveSourceDataInterface
     */
    private $retrieveSourceData;

    /**
     * @var ExtensibleDataObjectConverter
     */
    private $dataObjectConverter;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var SourceInterfaceFactory
     */
    private $sourceFactory;

    /**
     * @var SaveSourceInterface
     */
    private $saveSource;

    /**
     * @param RetrieveSourceDataInterface $retrieveSourceData
     * @param ExtensibleDataObjectConverter $dataObjectConverter
     * @param SerializerInterface $serializer
     * @param SourceInterfaceFactory $sourceFactory
     * @param SaveSourceInterface $saveSource
     */
    public function __construct(
        RetrieveSourceDataInterface $retrieveSourceData,
        ExtensibleDataObjectConverter $dataObjectConverter,
        SerializerInterface $serializer,
        SourceInterfaceFactory $sourceFactory,
        SaveSourceInterface $saveSource
    ) {
        $this->retrieveSourceData = $retrieveSourceData;
        $this->dataObjectConverter = $dataObjectConverter;
        $this->serializer = $serializer;
        $this->sourceFactory = $sourceFactory;
        $this->saveSource = $saveSource;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $uuid, SourceDataInterface $sourceData, CsvFormatInterface $format): void
    {
        $retrievingResult = $this->retrieveSourceData->execute($sourceData);

        if ($retrievingResult->getStatus() === RetrievingResultInterface::STATUS_FAILED) {
            throw new RetrievingSourceException(__('Source retrieving was failed'), null, 0, $retrievingResult);
        }

        $formatData = $this->dataObjectConverter->toFlatArray($format, [], CsvFormatInterface::class);
        $formatData = array_merge(
            [
                CsvFormatInterface::SEPARATOR => CsvFormatInterface::DEFAULT_SEPARATOR,
                CsvFormatInterface::ENCLOSURE => CsvFormatInterface::DEFAULT_ENCLOSURE,
                CsvFormatInterface::MULTIPLE_VALUE_SEPARATOR => CsvFormatInterface::DEFAULT_MULTIPLE_VALUE_SEPARATOR,
            ],
            $formatData
        );
        $metaData = $this->serializer->serialize([
            'format' => CsvFormatInterface::FORMAT_TYPE,
            'data' => $formatData
        ]);

        /** @var SourceInterface $source */
        $source = $this->sourceFactory->create([
            'uuid' => $uuid,
            'file' => $retrievingResult->getFile(),
            'metaData' => $metaData,
        ]);
        $this->saveSource->execute($source);
    }
}
