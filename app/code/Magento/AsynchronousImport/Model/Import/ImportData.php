<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Import;

use Magento\AsynchronousImportApi\Api\Data\ImportDataInterface;

/**
 * @inheritdoc
 */
class ImportData implements ImportDataInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(
        array $data
    ) {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
