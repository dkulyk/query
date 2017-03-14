<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface QueryFilter
 *
 * @package DtKt\Query\Contracts
 */
interface QueryFilter
{
    /**
     * Get filter name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Build filter query.
     *
     * @param Builder $query
     * @param string  $field
     * @param         $value
     * @param bool    $not
     *
     * @return mixed
     */
    public function filter(Builder $query, string $field, $value, bool $not = false);
}
