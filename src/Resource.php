<?php

namespace PixelBoii\Vague;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use PixelBoii\Vague\Element;
use PixelBoii\Vague\Relationship;
use PixelBoii\Vague\ResourceFields;
use PixelBoii\Vague\ResourceActions;

use JsonSerializable;
use ReflectionObject;
use ReflectionProperty;

class Resource implements JsonSerializable
{
    public static $model;
    public static $searchable;
    public static $name;

    public $record;

    public static function slug()
    {
        return class_basename(new static());
    }

    public function name()
    {
        return Str::of($this::$name ?? $this->slug())->snake()->replace('_', ' ')->title();
    }

    public function model()
    {
        if (is_null($this::$model)) {
            $model = 'App\\Models\\' . $this->slug();

            return new $model();
        }

        return new $this::$model();
    }

    public function render()
    {
        return $this->recordForm();
    }

    public function save(Request $request, $resource, $record)
    {
        $record->update(
            $request->validate(
                array_reduce($resource->resolveFields(), function($form, $field) {
                    $column = $field->column;
                    $form[$column] = [];
        
                    return $form;
                }, [])
            )
        );

        return redirect()->route('vague.record.index', [
            'resource' => $resource->slug(),
            'record' => $record->id
        ]);
    }

    public function delete(Request $request, $resource, $record)
    {
        $record->delete();

        return redirect()->route('vague.resource.index', [
            'resource' => $resource->slug()
        ]);
    }

    public function recordForm($record = null, $label = true)
    {
        if (is_null($record)) {
            $record = $this->record;
        }

        if ($label) {
            return Element::div([
                Element::subText($this->name()),
                Element::recordForm($this, $record),
            ])->class('space-y-2');
        } else {
            return Element::recordForm($this, $record);
        }
    }

    public function search($query, $search)
    {
        foreach ($this->resolveFields() as $field) {
            if ($field->casts == 'relationship') {
                if (!method_exists($this->model(), $field->relationship->target()::slug())) {
                    $this->model()->resolveRelationUsing($field->relationship->target()::slug(), fn($model) => $field->relationship->buildRelationship($model));
                }

                $target_fields = array_values(array_filter($field->relationship->target()->resolveFields(), fn($field) => $field->casts != 'relationship'));

                // Ignore relationships without any defined fields
                if (count($target_fields) > 0) {
                    $query->orWhereHas($field->relationship->target()::slug(), function($q) use($target_fields, $search) {
                        $q->where(function($q) use($target_fields, $search) {
                            foreach ($target_fields as $field) {
                                $q->orWhere($field->column, 'LIKE', '%' . $search . '%');
                            }
                        });
                    });
                }
            } else {
                $query->orWhere($field->column, 'LIKE', '%' . $search . '%');
            }
        }
    }

    public function setAttribute($attribute, $value)
    {
        $this->record->$attribute = $value;
    }

    public function getAttribute($attribute)
    {
        return $this->record->$attribute;
    }

    public function bindRecord($record)
    {
        $this->record = $record;

        return $this;
    }

    public function __call($name, $args)
    {
        if (in_array(strtolower($name), ['belongsto', 'belongstomany', 'hasmany', 'hasmanythrough', 'hasone'])) {
            return Relationship::$name(...$args)->bindResource($this);
        }
    }

    public function newInstance()
    {
        return $this->make();
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name(),
            'slug' => $this->slug()
        ];
    }

    /**
     * Fallback if resource doesnt define actions
    */
    public function actions($actions)
    {
        return [];
    }

    public function resolveFields()
    {
        return $this->fields(new ResourceFields());
    }

    public function renderFields()
    {
        return array_map(function($field) {
            $properties = (new ReflectionObject($field))->getProperties(ReflectionProperty::IS_PUBLIC);
            $json = [ 'element' => $field->render($this->record) ];

            foreach ($properties as $property) {
                $name = $property->name;
                $json[$name] = $field->$name;
            }

            return $json;
        }, $this->resolveFields());
    }

    public function resolveActions()
    {
        return $this->actions(resolve(ResourceActions::class));
    }

    public function actionsForRoute($route)
    {
        return array_filter($this->resolveActions(), fn($action) => $action->visible($route));
    }

    public function query()
    {
        return $this->model()->query();
    }

    public static function make()
    {
        $class = get_called_class();

        return new $class;
    }
}