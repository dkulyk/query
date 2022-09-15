<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

/**
 * Class Enum
 *
 * @package DKulyk\Eloquent\Query\Types
 */
class Enum extends AbstractType
{
    /**
     * @var array
     */
    protected $values;

    /**
     * Enum constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @inheritdoc
     */
    public function getFilter(): array
    {
        return [
            'input' => 'select',
            'multiple' => true,
            'values' => (object) array_map(fn($value) => is_array($value) ? $value['caption'] ?? $value : $value, $this->values),
        ];
    }

    public function prepareValue($value)
    {
        if(is_array($this->values[$value] ?? null)) {
            return $this->values[$value]['value'] ?? $value;
        }
        return $value;
    }
}
