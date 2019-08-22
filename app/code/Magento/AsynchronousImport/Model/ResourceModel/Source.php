<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\ResourceModel;

use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\PredefinedId;

/**
 * Implementation of basic operations for Source entity for specific db layer
 */
class Source extends AbstractDb
{
    /**
     * Provides possibility of saving entity with predefined/pre-generated id
     */
    use PredefinedId;

    /**#@+
     * Constants related to specific db layer
     */
    public const TABLE_NAME = 'asynchronous_import_source';
    /**#@-*/

    /**
     * @inheritdoc
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, SourceInterface::UUID);
    }
}
