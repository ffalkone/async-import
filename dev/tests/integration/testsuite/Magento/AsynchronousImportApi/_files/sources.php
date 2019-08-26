<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportApi\Api\Data\SourceInterfaceFactory;
use Magento\AsynchronousImportApi\Api\SaveSourceInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\TestFramework\Helper\Bootstrap;

/** @var SourceInterfaceFactory $sourceFactory */
$sourceFactory = Bootstrap::getObjectManager()->get(SourceInterfaceFactory::class);
/** @var SaveSourceInterface $saveSource */
$saveSource = Bootstrap::getObjectManager()->get(SaveSourceInterface::class);
/** @var SerializerInterface $serializer */
$serializer = Bootstrap::getObjectManager()->get(SerializerInterface::class);

$sourcesData = [
    [
        'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b41',
        'file' => 'csv-1.csv',
        'metaData' => ['format' => 'csv'],
    ],
    [
        'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b42',
        'file' => 'csv-2.csv',
        'metaData' => ['format' => 'csv'],
    ],
    [
        'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b43',
        'file' => 'csv-2.csv',
        'metaData' => ['format' => 'csv'],
    ],
    [
        'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b44',
        'file' => 'csv-3.csv',
        'metaData' => ['format' => 'csv'],
    ],
];
foreach ($sourcesData as $sourceData) {
    $sourceData['metaData'] = $serializer->serialize($sourceData['metaData']);
    /** @var SourceInterface $source */
    $source = $sourceFactory->create($sourceData);
    $saveSource->execute($source);
}
