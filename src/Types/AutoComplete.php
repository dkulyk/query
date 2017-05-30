<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

/**
 * Class AutoComplete
 *
 * @package DKulyk\Eloquent\Query\Types
 */
class AutoComplete extends AbstractType
{
    /**
     * @var string
     */
    protected $closure;

    /**
     * @param callable $closure
     */
    public function __construct(callable $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @inheritdoc
     */
    public function getFilter(): array
    {
        return [
            'input' => 'select',
            'multiple' => true,
            'data' => [
                'type' => 'autocomplete'
            ]
        ];
    }

    /**
     * @param string $term
     *
     * @return array
     */
    public function getValues(string $term): array
    {
        return call_user_func($this->closure, $term);
    }
}
