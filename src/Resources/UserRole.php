<?php

namespace PixelBoii\Vague\Resources;

use PixelBoii\Vague\Resource;
use PixelBoii\Vague\Element;
use PixelBoii\Vague\Models\UserRole as Model;
use PixelBoii\Vague\Vague;

class UserRole extends Resource
{
    public static $model = Model::class;

    /**
     * What should be displayed in read-only mode
    */
    public function stackedList()
    {
        $role = $this->record->getRole();

        $deleteButton = Element::div(
            Element::text('x')
        )
        ->class('cursor-pointer bg-red-100 py-4 px-6')
        ->onClick(function() {
            $this->model()->whereId($this->record['id'])->delete();
        })->class('text-red-400 font-bold');

        return Element::div([
            Element::div(
                Element::text($role['name']),
            )->class('py-4 px-6'),

            Element::div(
                Element::text('Level ' . $role['level']),
            )->class('py-4 px-6'),

            $deleteButton,
        ])->class('w-full flex justify-between items-center bg-white');
    }
}
