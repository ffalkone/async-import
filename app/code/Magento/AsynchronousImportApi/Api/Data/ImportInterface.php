<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ImportDataInterface
 *
 * @api
 */
interface ImportInterface extends ExtensibleDataInterface
{
    public const UUID = 'uuid';
    public const SOURCE_UUID = 'source_uuid';
    public const IMPORT_TYPE = 'import_type';
    public const IMPORT_BEHAVIOUR = 'import_behaviour';
    public const VALIDATION_STRATEGY = 'validation_strategy';
    public const ALLOWED_ERROR_COUNT = 'allowed_error_count';
    public const IMPORT_IMAGE_ARCHIVE = 'import_image_archive';
    public const IMPORT_IMAGES_FILE_DIR = 'import_images_file_dir';
    public const STARTED_AT = 'created_at';
    public const FINISHED_AT = 'finished_at';
    public const STATUS = 'status';

    public const STATUS_RUNNING = 'running';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAIL = 'fail';

    /**
     * Retrieve source uuid
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Retrieve Import type
     *
     * @return string|null
     */
    public function getImportType(): ?string;

    /**
     * Get Import data
     *
     * @return string|null
     */
    public function getImportData(): ?string;

    /**
     * Get Import data
     *
     * @return string|null
     */
    public function getMetaData(): ?string;

    /**
     * Get Meta data
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Retrieve existing extension attributes object
     *
     * @return \Magento\AsynchronousImportApi\Api\Data\ImportDataExtensionInterface|null
     */
    public function getExtensionAttributes(): ?\Magento\AsynchronousImportApi\Api\Data\ImportDataExtensionInterface;
}
