<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Search results of \Magento\AsynchronousImportApi\Api\GetSourceListInterface::execute method
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
 */
interface SourceSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Magento\AsynchronousImportApi\Api\Data\SourceInterface[]
     */
    public function getItems();
}
