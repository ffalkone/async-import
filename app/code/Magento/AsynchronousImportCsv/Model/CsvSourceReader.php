<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\Data\ImportDataInterfaceFactory;
use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportApi\Model\SourceReaderInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * @inheritdoc
 */
class CsvSourceReader implements SourceReaderInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ImportDataInterfaceFactory
     */
    private $importDataFactory;

    /**
     * @param SerializerInterface $serializer
     * @param ImportDataInterfaceFactory $importDataFactory
     */
    public function __construct(
        SerializerInterface $serializer,
        ImportDataInterfaceFactory $importDataFactory
    ) {
        $this->serializer = $serializer;
        $this->importDataFactory = $importDataFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceInterface $source): ImportDataInterface
    {
        $metaData = $this->serializer->unserialize($source->getMetaData());
        $file = $source->getFile();

        $importData = $this->importDataFactory->create([
            'data' => ['row-1', 'row-2', 'row-3'],
        ]);
        return $importData;
    }
}
