<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;

/**
 * @inheritdoc
 */
class SourceData implements SourceDataInterface
{
    /**
     * @var string
     */
    private $sourceType;

    /**
     * @var string
     */
    private $sourceData;

    /**
     * @param string $sourceType
     * @param string $sourceData
     */
    public function __construct(
        string $sourceType,
        string $sourceData
    ) {
        $this->sourceType = $sourceType;
        $this->sourceData = $sourceData;
    }

    /**
     * @inheritdoc
     */
    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    /**
     * @inheritdoc
     */
    public function getSourceData(): string
    {
        return $this->sourceData;
    }
}
