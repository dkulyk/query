<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query\Types;

use Carbon\Carbon;
use DKulyk\Eloquent\Query\Contracts\QueryField;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class DateMonthInt
 *
 * @package DtKt\Query\Types
 */
class DateMonthInt extends Date
{
    /**
     * Date constructor.
     *
     * @param string $format
     * @param string $printFormat
     */
    public function __construct($format = 'm.Y', $printFormat = 'mm.yyyy')
    {
        parent::__construct($format, $printFormat, ['viewMode' => 'years', 'minViewMode' => 'months']);
    }

    /**
     * @inheritdoc
     *
     * @throws \InvalidArgumentException
     */
    public function prepareValue($value)
    {
        $date = Carbon::createFromFormat($this->format, $value);

        return $date->year * 12 + ($date->month - 1);
    }

    public function applyFilter(
        Builder $query,
        QueryField $field,
        string $filter,
        $value,
        $boolean = 'and'
    ): bool{
        return false;
    }
}
