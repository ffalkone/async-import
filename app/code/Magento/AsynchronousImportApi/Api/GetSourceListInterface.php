<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi\Api;

use Magento\AsynchronousImportApi\Api\Data\SourceSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Find Sources by SearchCriteria operation
 *
 * @api
 */
interface GetSourceListInterface
{
    /**
     * Find Sources by SearchCriteria operation
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SourceSearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria): SourceSearchResultInterface;
}
