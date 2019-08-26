<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import;

use Magento\AsynchronousImport\Model\Source\ResourceModel\Source as SourceResourceModel;
use Magento\AsynchronousImportApi\Api\Data\ImportInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * @inheritdoc
 */
class Import extends AbstractModel implements ImportInterface
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'asynchronous_import';

    /**
     * $uuid, $sourceUuid, $importType, $importBehaviour, $validationStrategy, $allowedErrorCount
     * are marked as null for Backward Compatibility with \Magento\Framework\Data\Collection
     *
     * @see \Magento\Framework\Data\Collection::getNewEmptyItem
     *
     * @param Context $context
     * @param Registry $registry
     * @param string $uuid
     * @param string $sourceUuid
     * @param string $importType
     * @param string $importBehaviour
     * @param string $validationStrategy
     * @param int $allowedErrorCount
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        string $uuid = null,
        string $sourceUuid = null,
        string $importType = null,
        string $importBehaviour = null,
        string $validationStrategy = null,
        int $allowedErrorCount = null,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

        $this->setData(self::UUID, $uuid);
        $this->setData(self::SOURCE_UUID, $sourceUuid);
        $this->setData(self::IMPORT_TYPE, $importType);
        $this->setData(self::IMPORT_BEHAVIOUR, $importBehaviour);
        $this->setData(self::VALIDATION_STRATEGY, $validationStrategy);
        $this->setData(self::ALLOWED_ERROR_COUNT, $allowedErrorCount);
    }

    /**
     * Object initialization
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(SourceResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getUuid(): ?string
    {
        return $this->getData(self::UUID);
    }

    /**
     * @inheritdoc
     */
    public function getSourceUuid(): ?string
    {
        return $this->getData(self::SOURCE_UUID);
    }

    /**
     * @inheritdoc
     */
    public function getImportType(): ?string
    {
        return $this->getData(self::IMPORT_TYPE);
    }

    /**
     * @inheritdoc
     */
    public function getImportBehaviour(): ?string
    {
        return $this->getData(self::IMPORT_BEHAVIOUR);
    }

    /**
     * @inheritdoc
     */
    public function getValidationStrategy(): ?string
    {
        return $this->getData(self::VALIDATION_STRATEGY);
    }

    /**
     * @inheritdoc
     */
    public function getAllowedErrorCount(): ?int
    {
        return $this->getData(self::ALLOWED_ERROR_COUNT);
    }
}
