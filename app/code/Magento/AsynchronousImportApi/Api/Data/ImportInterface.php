<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api\Data;

/**
 * Interface ImportDataInterface
 *
 * @api
 */
interface ImportInterface
{
    public const UUID = 'uuid';
    public const SOURCE_UUID = 'source_uuid';
    public const IMPORT_TYPE = 'import_type';
    public const IMPORT_BEHAVIOUR = 'import_behaviour';
    public const VALIDATION_STRATEGY = 'validation_strategy';
    public const ALLOWED_ERROR_COUNT = 'allowed_error_count';
    public const IMPORT_IMAGE_ARCHIVE = 'import_image_archive';
    public const IMPORT_IMAGES_FILE_DIR = 'import_images_file_dir';

    /**
     * Get import uuid
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Get source uuid
     *
     * @return string|null
     */
    public function getSourceUuid(): ?string;

    /**
     * Get import type
     *
     * @return string|null
     */
    public function getImportType(): ?string;

    /**
     * Get import behaviour
     *
     * @return string|null
     */
    public function getImportBehaviour(): ?string;

    /**
     * Get validation startegy
     *
     * @return string|null
     */
    public function getValidationStrategy(): ?string;

    /**
     * Get allowed error count
     *
     * @return int|null
     */
    public function getAllowedErrorCount(): ?int;
}
