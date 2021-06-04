<?php

namespace App\Vague;

use PixelBoii\Vague\Element;
use PixelBoii\Vague\Resource;
use PixelBoii\Vague\Relationship;

use Exception;

use App\Models\User as Model;

class User extends Resource
{
    /**
     * Model related to resource
    */ 
    public static $model = Model::class;

    /**
     * The fields that should be searchable via the navigation bar
    */
    public static $searchable = [
        'name',
        'email'
    ];

    /**
     * The fields that will be available in the admin panel
    */
    public function fields($fields)
    {
        return [
            $fields->text('name'),
            $fields->text('email'),
            $fields->dateTime('email_verified_at'),
            $fields->password('password')
        ];
    }

    /**
     * The view that will show up when directly loading this resource
    */
    public function render($record)
    {
        return Element::div([
            $this->recordForm($record),
        ]);
    }

    /**
     * The actions directly related to this resource
    */
    public function actions($actions)
    {
        return [
            $actions->method(function($request, $resource, $record) {
                throw new Exception($record->email . ' would like to reset their password');
            }, 'Reset Password', 'reset_password')->secondary(),
        ];
    }

    /**
     * What should be displayed in the sidebar
    */
    public function sidebar($record)
    {
        return Element::div([
            Element::text($record->name)->setClass('text-white font-medium'),
            Element::text($record->email)->setClass('text-gray-300 text-sm')
        ]);
    }

    /**
     * What should be displayed in read-only mode
    */
    public function summary($record)
    {
        return Element::div([
            Element::text($record->name),
            Element::subText($record->email),
        ]);
    }
}
