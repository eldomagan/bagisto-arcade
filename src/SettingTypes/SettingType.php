<?php

namespace EldoMagan\BagistoArcade\SettingTypes;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * @method $this id(string $id)
 * @method $this label(string $label)
 * @method $this type(string $type)
 * @method $this default($name)
 * @method $this info(string $info)
 *
 * @property-read string $id
 * @property-read string $label
 * @property-read string $type
 * @property-read mixed $default
 * @property-read string $info
 */
class SettingType implements Arrayable
{
    protected string $id;
    protected string $label;
    protected string $type;
    protected $default;
    protected string $info;

    public static function make(string $id, string $label = '')
    {
        return (new static())
            ->id($id)
            ->label($label ?: Str::title(str_replace('_', ' ', $id)))
            ->type('text')
            ->default('')
            ->info('');
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        return null;
    }

    public function __call($name, $arguments)
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $arguments[0];

            return $this;
        }

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'type' => $this->type,
            'default' => $this->default,
            'info' => $this->info,
        ];
    }
}
