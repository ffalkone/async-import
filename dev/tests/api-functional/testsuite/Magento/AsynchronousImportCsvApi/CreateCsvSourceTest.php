<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportCsvApi\Api;

use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

class AsynchronousImportCsvApi extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    const RESOURCE_PATH = '/V1/import/sources/csv';
    const SERVICE_NAME = 'asynchronousImportCsvApiCreateSourceV1';
    /**#@-*/

    public function testCreateCsvSource()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => Request::HTTP_METHOD_POST,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'operation' => self::SERVICE_NAME . 'Execute',
            ],
        ];

        $data = [
            'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b41',
            'sourceData' => [
                'sourceType' => 'base64_encoded_data',
                'sourceData' => 'value2',
            ],
            'format' => [
                'separator' => 'CSV',
                'enclosure' => 'CSV',
                'delimiter' => 'CSV',
                'multipleValueSeparator' => 'CSV',
            ]
        ];
        $this->_webApiCall($serviceInfo, $data);
    }
    // with wrong source type
    // without format
}
