<?php

namespace PixelBoii\Vague;

class Breadcrumbs
{
    public $items = [];
    public $last = '';

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }
    
    public function newRoot($root = '')
    {
        $this->last = $root;

        return $this;
    }

    public function add(String $link, String $name = null)
    {
        if (is_null($name)) {
            $name = $link;
        }

        if ($this->last != '') {
            $link = $this->last . '/' . $link;
        }

        $this->last = $link;

        array_push($this->items, [
            'href' => '/' . config('vague.prefix') . '/' . $link,
            'name' => $name
        ]);

        return $this;
    }
}