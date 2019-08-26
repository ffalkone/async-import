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
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @inheritdoc
 */
class StartImport implements StartImportInterface
{
    /**
     * @var GetSourceListInterface
     */
    private $getSourceList;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SaveImportInterface
     */
    private $saveImport;

    /**
     * @param GetSourceListInterface $getSourceList
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SaveImportInterface $saveImport
     */
    public function __construct(
        GetSourceListInterface $getSourceList,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SaveImportInterface $saveImport
    ) {
        $this->getSourceList = $getSourceList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
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

        /** @var \Magento\AsynchronousImportApi\Api\Data\SourceInterface $source */
//        $source = reset($sourceSearchResult->getItems());
//        $parser = $pasrersPool->get($source);
        // parsing csv => publisher


        $this->saveImport->execute($import);
    }
}
