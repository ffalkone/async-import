<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import;

use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportApi\Api\GetSourceListInterface;
use Magento\AsynchronousImportApi\Api\SaveImportInterface;
use Magento\AsynchronousImportApi\Api\StartImportInterface;
use Magento\AsynchronousImportApi\Model\SourceReaderInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @inheritdoc
 */
class StartImport implements StartImportInterface
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var GetSourceListInterface
     */
    private $getSourceList;

    /**
     * @var SourceReaderInterface
     */
    private $sourceReader;

    /**
     * @var SaveImportInterface
     */
    private $saveImport;

    /**
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param GetSourceListInterface $getSourceList
     * @param SourceReaderInterface $sourceReader
     * @param SaveImportInterface $saveImport
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        GetSourceListInterface $getSourceList,
        SourceReaderInterface $sourceReader,
        SaveImportInterface $saveImport
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->getSourceList = $getSourceList;
        $this->sourceReader = $sourceReader;
        $this->saveImport = $saveImport;
    }

    /**
     * @inheritdoc
     */
    public function execute(ImportInterface $import): void
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(SourceInterface::UUID, $import->getSourceUuid(), 'eq')
            ->create();
        $sourceSearchResult = $this->getSourceList->execute($searchCriteria);

        if ($sourceSearchResult->getTotalCount() === 0) {
            throw new NoSuchEntityException(
                __('Source with uuid "%uuid" does not exist.', ['uuid' => $import->getSourceUuid()])
            );
        }
        $sources = $sourceSearchResult->getItems();
        /** @var SourceInterface $source */
        $source = reset($sources);

        $importData = $this->sourceReader->execute($source);

        $this->saveImport->execute($import);
    }
}
