<?php

namespace PixelBoii\Vague;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use PixelBoii\Vague\Element;
use PixelBoii\Vague\ResourceFields;
use PixelBoii\Vague\ResourceActions;

class Resource
{
    public static $model;
    public static $searchable;
    public static $name;

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

    public function render($record)
    {
        return $this->recordForm($record);
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
    }

    public function delete(Request $request, $resource, $record)
    {
        $record->delete();

        return redirect()->route('vague.resource.index', [
            'resource' => $resource->slug()
        ]);
    }

    public function recordForm($record, $label = true)
    {
        if ($label) {
            return Element::div([
                Element::subText($this->name()),
                Element::recordForm($this, $record),
            ])->class('space-y-2');
        } else {
            return Element::recordForm($this, $record);
        }
    }

    /**
     * Fallback if resource doesnt define actions
    */
    public function actions($actions)
    {
        return [];
    }

    public function resolveFields($record = null)
    {
        return array_reduce($this->fields(resolve(ResourceFields::class)), function($fields, $field) use($record) {
            if (method_exists($field, 'onRender') && isset($record)) {
                $field->onRender($record);
            }

            return [...$fields, $field];
        }, []);
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