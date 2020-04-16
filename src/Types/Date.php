<?php

declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

use Carbon\Carbon;
use DKulyk\Eloquent\Query\Contracts\QueryField;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Date
 *
 * @package DtKt\Query\Types
 */
class Date extends AbstractType
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $printFormat;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $type = 'date';

    /**
     * Date constructor.
     *
     * @param  string  $format
     * @param  string  $printFormat
     * @param  array  $options
     */
    public function __construct($format = 'd.m.Y', $printFormat = 'dd.mm.yyyy', array $options = [])
    {
        $this->format = $format;
        $this->printFormat = $printFormat;
        $this->options = $options;
    }

    /**
     * @inheritdoc
     *
     * @throws \InvalidArgumentException
     */
    public function prepareValue($value)
    {
        return $value === null ? null : Carbon::createFromFormat($this->format, $value)->toDateString();
    }

    /**
     * @inheritdoc
     */
    public function getFilter(): array
    {
        return [
            'type' => $this->type,
            'data' => [
                'format' => $this->printFormat,
                'options' => $this->options,
            ],
        ];
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \DKulyk\Eloquent\Query\Contracts\QueryField  $field
     * @param  string  $filter
     * @param $value
     * @param  string  $boolean
     * @return bool
     */
    public function applyFilter(
        Builder $query,
        QueryField $field,
        string $filter,
        $value,
        $boolean = 'and'
    ): bool {
        $qualifiedField = $field->getQualifiedField();

        switch ($filter) {
            case 'equal':
                $query->whereDate($qualifiedField, '=', $value, $boolean);

                return true;
            case 'not_equal':
                $query->whereDate($qualifiedField, '<>', $value, $boolean);

                return true;
            case 'less':
                $query->whereDate($qualifiedField, '<', $value, $boolean);

                return true;
            case 'less_or_equal':
                $query->whereDate($qualifiedField, '<=', $value, $boolean);

                return true;
            case 'greater':
                $query->whereDate($qualifiedField, '>', $value, $boolean);

                return true;
            case 'greater_or_equal':
                $query->whereDate($qualifiedField, '>=', $value, $boolean);

                return true;
            case 'between':
                $query->whereDate($qualifiedField, '>=', $value[0], $boolean)
                    ->whereDate($qualifiedField, '<=', $value[1], $boolean);

                return true;
            case 'not_between':
                $query->where(function (Builder $builder) use ($value, $qualifiedField) {
                    $builder->whereDate($qualifiedField, '<', $value[0])
                        ->orWhereDate($qualifiedField, '>', $value[1]);
                }, null, null, $boolean);

                return true;
        }

        return false;
    }
}
