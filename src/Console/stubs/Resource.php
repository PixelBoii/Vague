<?php

namespace DummyNamespace;

use PixelBoii\Vague\Resource;
use PixelBoii\Vague\Element;
use PixelBoii\Vague\Relationship;

class DummyClass extends Resource
{
    /**
     * Model related to resource
    */ 
    public static $model = null;

    /**
     * The fields that should be searchable via the navigation bar
    */
    public static $searchable = [
        //
    ];

    /**
     * The fields that will be available in the admin panel
    */
    public function fields($fields)
    {
        return [
            //
        ];
    }

    /**
     * The view that will show up when directly loading this resource
    */
    public function render($record)
    {
        return Element::div([
            $this->recordForm($record)
        ]);
    }

    /**
     * What should be displayed in read-only mode
    */
    public function summary($record)
    {
        return Element::div([
            Element::text('This is an example'),
            Element::subText('This is an example'),
        ]);
    }
}