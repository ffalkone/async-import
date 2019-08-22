<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Represents CSV format
 *
 * @api
 */
interface CsvFormatInterface extends ExtensibleDataInterface
{
    public const FORMAT_TYPE = 'csv';

    public const DEFAULT_SEPARATOR = ',';
    public const DEFAULT_ENCLOSURE = '"';
    public const DEFAULT_DELIMITER = ',';
    public const DEFAULT_MULTIPLE_VALUE_SEPARATOR = '|';

    /**
     * Get CSV Separator
     *
     * @return string
     */
    public function getSeparator(): string;

    /**
     * Get CSV Enclosure
     *
     * @return string
     */
    public function getEnclosure(): string;

    /**
     * Get CSV Delimiter
     *
     * @return string
     */
    public function getDelimiter(): string;

    /**
     * Get Multiple Value Separator
     *
     * @return string
     */
    public function getMultipleValueSeparator(): string;
}
