<?php

namespace PixelBoii\Vague\Paginators;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class LengthAwarePaginator extends Paginator
{
    public function toArray()
    {
        return [
            'data' => $this->items->toArray(),
            'links' => $this->links(),
        ];
    }

    public function items()
    {
        return $this->items;
    }

    public function links($view = null, $data = [])
    {
        $this->appends(Request::all());

        $window = UrlWindow::make($this);

        $elements = array_filter([
            $window['first'],
            is_array($window['slider']) ? '...' : null,
            $window['slider'],
            is_array($window['last']) ? '...' : null,
            $window['last'],
        ]);

        return Collection::make($elements)->flatMap(function ($item) {
            if (is_array($item)) {
                return Collection::make($item)->map(function ($url, $page) {
                    return [
                        'url' => $url,
                        'label' => $page,
                        'active' => $this->currentPage() === $page,
                    ];
                });
            } else {
                return [
                    [
                        'url' => null,
                        'label' => '...',
                        'active' => false,
                    ],
                ];
            }
        })->prepend([
            'url' => $this->previousPageUrl(),
            'label' => 'Previous',
            'active' => false,
        ])->push([
            'url' => $this->nextPageUrl(),
            'label' => 'Next',
            'active' => false,
        ]);
    }
}
