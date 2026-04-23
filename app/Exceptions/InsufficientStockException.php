<?php

namespace App\Exceptions;

use RuntimeException;

class InsufficientStockException extends RuntimeException
{
    /** @var array<int, array<string, mixed>> */
    public array $items;

    /**
     * @param array<int, array<string, mixed>> $items
     */
    public function __construct(array $items)
    {
        parent::__construct('Insufficient stock for one or more items.');
        $this->items = $items;
    }
}
