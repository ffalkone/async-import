<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingResultInterface;

/**
 * @inheritdoc
 */
class RetrievingResult implements RetrievingResultInterface
{
    /**
     * One of const RetrievingResultInterface::STATUS_*
     *
     * @var string
     */
    private $status;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var string|null
     */
    private $file;

    /**
     * @param string $status
     * @param array $errors
     * @param string $file
     */
    public function __construct(string $status, array $errors, ?string $file)
    {
        $this->status = $status;
        $this->errors = $errors;
        $this->file = $file;
    }

    /**
     * @inheritdoc
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @inheritdoc
     */
    public function getFile(): ?string
    {
        return $this->file;
    }
}
