<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Api\Data;

/**
 * Represents Source Data retrieving request
 *
 * @api
 */
interface SourceDataInterface
{
    public const SOURCE_TYPE = 'source_type';
    public const SOURCE_DATA = 'source_data';

    /**
     * Get source type
     *
     * @return string
     */
    public function getSourceType(): string;

    /**
     * Get Source data
     *
     * @return string
     */
    public function getSourceData(): string;
}
