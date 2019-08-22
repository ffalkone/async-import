<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrieveSourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\RetrievingSourceException;
use Magento\Framework\ObjectManagerInterface;

/**
 * Extension point for retrieving of new source data types via di configuration
 *
 * @api
 */
class SourceDataRetrievingChain implements RetrieveSourceDataInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var array
     */
    private $sourceDataRetrievers;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $sourceDataRetrievers
     * @throws RetrievingSourceException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        array $sourceDataRetrievers = []
    ) {
        $this->objectManager = $objectManager;
        foreach ($sourceDataRetrievers as $sourceDataRetriever) {
            if (false === is_subclass_of($sourceDataRetriever, RetrieveSourceDataInterface::class)) {
                throw new RetrievingSourceException(
                    __('%1 must implement %2.', [$sourceDataRetriever, RetrieveSourceDataInterface::class])
                );
            }
        }
        $this->sourceDataRetrievers = $sourceDataRetrievers;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceDataInterface $sourceData): RetrievingResultInterface
    {
        if (!isset($this->sourceDataRetrievers[$sourceData->getSourceType()])) {
            throw new RetrievingSourceException(
                __('Source type %1 is not supported.', $sourceData->getSourceType())
            );
        }
        /** @var RetrieveSourceDataInterface $sourceDataRetriever */
        $sourceDataRetriever = $this->objectManager->get($this->sourceDataRetrievers[$sourceData->getSourceType()]);

        return $sourceDataRetriever->execute($sourceData);
    }
}
