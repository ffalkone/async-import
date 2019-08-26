<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi;

use Magento\AsynchronousImportApi\Api\Data\SourceInterface;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\Assert\AssertArrayContains;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Get source list test
 */
class GetSourceListTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    private const RESOURCE_PATH = '/V1/import/sources';
    private const SERVICE_NAME = 'asynchronousImportApiGetSourceListV1';
    /**#@-*/

    /**
     * @magentoApiDataFixture Magento/AsynchronousImportApi/_files/sources.php
     */
    public function testGetList(): void
    {
        $expectedResponse = [
            'search_criteria' => [
                SearchCriteria::FILTER_GROUPS => [
                    [
                        'filters' => [
                            [
                                'field' => SourceInterface::UUID,
                                'value' => implode(
                                    ',',
                                    [
                                        'c4f2d109-0792-41ff-9f24-788ed5634b41',
                                        'c4f2d109-0792-41ff-9f24-788ed5634b42',
                                        'c4f2d109-0792-41ff-9f24-788ed5634b43',
                                        'c4f2d109-0792-41ff-9f24-788ed5634b44',
                                    ]
                                ),
                                'condition_type' => 'in',
                            ],
                        ],
                    ],
                    [
                        'filters' => [
                            [
                                'field' => SourceInterface::FILE,
                                'value' => 'csv-2.csv',
                                'condition_type' => 'eq',
                            ],
                        ],
                    ],
                ],
                SearchCriteria::SORT_ORDERS => [
                    [
                        'field' => SourceInterface::UUID,
                        'direction' => SortOrder::SORT_DESC,
                    ],
                ],
                SearchCriteria::CURRENT_PAGE => 2,
                SearchCriteria::PAGE_SIZE => 1,
            ],
            'total_count' => 2,
            'items' => [
                [
                    SourceInterface::UUID => 'c4f2d109-0792-41ff-9f24-788ed5634b42',
                ],
            ],
        ];

        $requestData = ['searchCriteria' => $expectedResponse['search_criteria']];
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?' . http_build_query($requestData),
                'httpMethod' => Request::HTTP_METHOD_GET,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'operation' => self::SERVICE_NAME . 'Execute',
            ],
        ];
        $response = (TESTS_WEB_API_ADAPTER == self::ADAPTER_REST)
            ? $this->_webApiCall($serviceInfo)
            : $this->_webApiCall($serviceInfo, $requestData);

        AssertArrayContains::assert($expectedResponse, $response);
    }
}
