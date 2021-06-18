<?php

namespace PixelBoii\Vague\Elements;

use PixelBoii\Vague\Element;

class Relationship extends Element
{
    public $tag = 'div';
    public $displayTitle = true;
    public $limit = 5;
    public $link;

    public $relationship;
    public $targetMethod;
    public $mapFn;

    public function __construct($relationship, $method)
    {
        $this->relationship = $relationship;
        $this->targetMethod = $method;

        $this->link = in_array($relationship->target()::class, config('vague.resources'));
    }

    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function hideTitle()
    {
        $this->displayTitle = false;

        return $this;
    }

    public function displayTitle()
    {
        $this->displayTitle = true;

        return $this;
    }

    public function disableLink()
    {
        $this->link = false;

        return $this;
    }

    public function enableLink()
    {
        $this->link = true;

        return $this;
    }

    public function map($fn)
    {
        $this->mapFn = $fn;

        return $this;
    }

    public function summaryForItem($item)
    {
        $method = $this->targetMethod;
        $mapFn = $this->mapFn;
        $summary = $this->relationship->target()->bindRecord($item)->$method();

        if (isset($mapFn)) {
            return $mapFn($summary, $this->relationship->target()->bindRecord($item), $item);
        } else {
            return $summary;
        }
    }

    public function summary()
    {
        $query = $this->relationship->query()->latest();
        $limit = $this->relationship->type == 'single' ? 1 : $this->limit;

        $records = $query->limit($limit)->get();

        $summary = Element::div(
            $records->reduce(function($records, $item) {
                $result = $this->summaryForItem($item)->meta(['record' => $item]);

                if ($this->link) {
                    $result = Element::link(
                        $result,
                        '/' . config('vague.prefix') . '/resource/' . $this->relationship->target()->slug() . '/' . $item->id
                    );
                }

                if (isset($result)) {
                    return [...$records, $result];
                } else {
                    return $records;
                }
            }, [])
        )->class('space-y-2');

        return $summary;
    }

    public function render()
    {
        $res = $this->summary();

        if ($this->displayTitle) {
            $res = Element::div([
                Element::subText($this->relationship->target()->name()),
                $res,
            ])->class('space-y-2');
        }

        return [$res];
    }
}