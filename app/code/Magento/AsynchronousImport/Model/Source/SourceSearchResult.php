<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImport\Model\Source;

use Magento\AsynchronousImportApi\Api\Data\SourceSearchResultInterface;
use Magento\Framework\Api\SearchResults;

/**
 * @inheritdoc
 */
class SourceSearchResult extends SearchResults implements SourceSearchResultInterface
{
}
