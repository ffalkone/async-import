<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportApi;

use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Start import test
 */
class StartImportTest extends WebapiAbstract
{
    /**#@+
     * Service constants
     */
    private const RESOURCE_PATH = '/V1/imports';
    private const SERVICE_NAME = 'asynchronousImportApiStartImportV1';
    /**#@-*/

    /**
     * @magentoApiDataFixture Magento/AsynchronousImportApi/_files/sources.php
     */
    public function testStartImport(): void
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
            'import' => [
                'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634001',
                'sourceUuid' => 'c4f2d109-0792-41ff-9f24-788ed5634b41',
                'importType' => 'import_type',
                'importBehaviour' => 'import_behaviour',
                'validationStrategy' => 'validation_strategy',
                'allowedErrorCount' => 1,
            ],
        ];
        $this->_webApiCall($serviceInfo, $data);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Source with uuid \"%uuid\" does not exist.
     */
    public function testStartImportWithNonExistentSource(): void
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
            'import' => [
                'uuid' => 'c4f2d109-0792-41ff-9f24-788ed5634001',
                'sourceUuid' => '00000000-0000-0000-0000-000000000000',
            ],
        ];
        $this->_webApiCall($serviceInfo, $data);
    }
}
