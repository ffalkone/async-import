<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Model;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;
use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\AsynchronousImportApi\Api\ImportException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Chain of source readers. Extension point for new source data formats via di configuration
 *
 * @api
 */
class SourceReaderChain implements SourceReaderInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var array
     */
    private $readers;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param SerializerInterface $serializer
     * @param array $readers
     * @throws ImportException
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        SerializerInterface $serializer,
        array $readers = []
    ) {
        $this->objectManager = $objectManager;
        $this->serializer = $serializer;
        foreach ($readers as $reader) {
            if (false === is_subclass_of($reader, SourceReaderInterface::class)) {
                throw new ImportException(
                    __('%1 must implement %2.', [$reader, SourceReaderInterface::class])
                );
            }
        }
        $this->readers = $readers;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceInterface $source): ImportDataInterface
    {
        $metaData = $this->serializer->unserialize($source->getMetaData());
        if (!isset($metaData['format'])) {
            // TODO:
            throw new ImportException(
                __('Source format is empty.')
            );
        }

        if (!isset($this->readers[$metaData['format']])) {
            throw new ImportException(
                __('Source type %1 is not supported.', $metaData['format'])
            );
        }
        /** @var SourceReaderInterface $reader */
        $reader = $this->objectManager->get($this->readers[$metaData['format']]);

        return $reader->execute($source);
    }
}
