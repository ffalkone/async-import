<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportApi\Api\Data\SourceInterfaceFactory;
use Magento\AsynchronousImportApi\Api\SaveSourceInterface;
use Magento\TestFramework\Helper\Bootstrap;

/** @var SourceInterfaceFactory $sourceFactory */
$sourceFactory = Bootstrap::getObjectManager()->get(SourceInterfaceFactory::class);
/** @var SaveSourceInterface $saveSource */
$saveSource = Bootstrap::getObjectManager()->get(SaveSourceInterface::class);

$sourcesData = [
    [
        'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b41',
        'file' => 'csv-1.csv',
        'metaData' => 'meta-1',
    ],
    [
        'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b42',
        'file' => 'csv-2.csv',
        'metaData' => 'meta-2',
    ],
    [
        'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b43',
        'file' => 'csv-2.csv',
        'metaData' => 'meta-3',
    ],
    [
        'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b44',
        'file' => 'csv-3.csv',
        'metaData' => 'meta-4',
    ],
];
foreach ($sourcesData as $sourceData) {
    /** @var SourceInterface $source */
    $source = $sourceFactory->create($sourceData);
    $saveSource->execute($source);
}
