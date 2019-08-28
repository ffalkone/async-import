<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsv\Model;

use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatExtensionInterface;
use Magento\AsynchronousImportCsvApi\Api\Data\CsvFormatInterface;

/**
 * @inheritdoc
 */
class CsvFormat implements CsvFormatInterface
{
    /**
     * @var string
     */
    private $separator;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @var string
     */
    private $multipleValueSeparator;

    /**
     * @var CsvFormatExtensionInterface
     */
    private $extensionAttributes;

    /**
     * @param string $separator
     * @param string $enclosure
     * @param string $multipleValueSeparator
     * @param CsvFormatExtensionInterface $extensionAttributes
     */
    public function __construct(
        string $separator,
        string $enclosure,
        string $multipleValueSeparator,
        CsvFormatExtensionInterface $extensionAttributes
    ) {
        $this->separator = $separator;
        $this->enclosure = $enclosure;
        $this->multipleValueSeparator = $multipleValueSeparator;
        $this->extensionAttributes = $extensionAttributes;
    }

    /**
     * @inheritdoc
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * @inheritdoc
     */
    public function getEnclosure(): string
    {
        return $this->enclosure;
    }

    /**
     * @inheritdoc
     */
    public function getMultipleValueSeparator(): string
    {
        return $this->multipleValueSeparator;
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): CsvFormatExtensionInterface
    {
        return $this->extensionAttributes;
    }
}
