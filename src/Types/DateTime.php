<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

use Carbon\Carbon;
use DKulyk\Eloquent\Query\Contracts\QueryField;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class DateTime
 *
 * @package DtKt\Query\Types
 */
class DateTime extends Date
{
    protected $type = 'datetime';

    /**
     * DateTime constructor.
     *
     * @param string $format
     * @param string $printFormat
     * @param array $options
     */
    public function __construct($format = 'd.m.Y H:i', $printFormat = 'dd.mm.yyyy hh:ii', array $options = [])
    {
        parent::__construct($format, $printFormat, $options);
    }

    /**
     * @inheritdoc
     */
    public function prepareValue($value)
    {
        return $value === null ? null : Carbon::createFromFormat($this->format, $value)->toDateTimeString();
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
