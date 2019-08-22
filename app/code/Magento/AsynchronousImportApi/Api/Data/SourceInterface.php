<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api\Data;

/**
 * Represents Source for Import
 *
 * @api
 */
interface SourceInterface
{
    public const UUID = 'uuid';
    public const FILE = 'file';
    public const META_DATA = 'meta_data';

    /**
     * Retrieve source uuid
     *
     * @return string
     */
    public function getUuid(): string;

    /**
     * Get file
     *
     * @return string
     */
    public function getFile(): string;

    /**
     * Get source meta data
     *
     * @return string
     */
    public function getMetaData(): string;
}
