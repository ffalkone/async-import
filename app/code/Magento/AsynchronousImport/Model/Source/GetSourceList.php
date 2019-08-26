<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Source;

use Magento\AsynchronousImportApi\Api\Data\SourceSearchResultInterface;
use Magento\AsynchronousImportApi\Api\Data\SourceSearchResultInterfaceFactory;
use Magento\AsynchronousImportApi\Api\GetSourceListInterface;
use Magento\AsynchronousImport\Model\Source\ResourceModel\SourceCollection;
use Magento\AsynchronousImport\Model\Source\ResourceModel\SourceCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @inheritdoc
 */
class GetSourceList implements GetSourceListInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SourceCollectionFactory
     */
    private $sourceCollectionFactory;

    /**
     * @var SourceSearchResultInterfaceFactory
     */
    private $sourceSearchResultFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SourceCollectionFactory $sourceCollectionFactory
     * @param SourceSearchResultInterfaceFactory $sourceSearchResultFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        SourceCollectionFactory $sourceCollectionFactory,
        SourceSearchResultInterfaceFactory $sourceSearchResultFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->sourceCollectionFactory = $sourceCollectionFactory;
        $this->sourceSearchResultFactory = $sourceSearchResultFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritdoc
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): SourceSearchResultInterface
    {
        /** @var SourceCollection $collection */
        $collection = $this->sourceCollectionFactory->create();

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        /** @var SourceSearchResultInterface $searchResult */
        $searchResult = $this->sourceSearchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult;
    }
}
