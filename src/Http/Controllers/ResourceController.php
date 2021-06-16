<?php

namespace PixelBoii\Vague\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use PixelBoii\Vague\Http\Helpers\ResourceHelper;
use PixelBoii\Vague\Breadcrumbs;

class ResourceController extends Controller
{
    public function index(Request $request, $resource)
    {
        $request->validate([
            'sortBy' => ['string'],
            'order' => ['in:DESC,ASC'],
            'search' => ['string']
        ]);

        $resource = ResourceHelper::getModelOrFail($resource);
        $sortBy = $request->get('sortBy') ?? 'created_at';
        $search = $request->get('search') ?? '';
        $sortOrder = $request->get('order') ?? 'DESC';

        $fields = $resource->resolveFields();
        $actions = $resource->actionsForRoute('table');

        $query = $resource->model()->orderBy($sortBy, $sortOrder)->where(fn($query) => $resource->search($query, $search));

        $breadcrumbs = Breadcrumbs::make()->add('', 'Resource')->newRoot('resource')->add($resource->slug(), $resource->name());
        $results = $query->paginate();

        return Inertia::render('Resource', [
            'filters' => $request->all('search', 'order', 'sortBy'),
            'records' => [
                'links' => $results->links(),
                'data' => $results->items()->map(function($item) use($resource) {
                    return [
                        'data' => $item,
                        'fields' => $resource->newInstance()->bindRecord($item)->renderFields()
                    ];
                })
            ],
            'fields' => $fields,
            'actions' => $actions,
            'slug' => $resource->slug(),
            'name' => $resource->name(),
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function search(Request $request, $resource_id)
    {
        $request->validate([
            'search' => ['nullable', 'string']
        ]);

        $search = $request->input('search') ?? '';
        $resource = ResourceHelper::getModelOrFail($resource_id);

        return $resource->model()->where(fn($query) => $resource->search($query, $search))->limit(10)->get()->map(function($item) use($resource) {
            return [
                'data' => $item,
                'element' => $resource->summary($item)
            ];
        });
    }

    public function action(Request $request, $resource_id, $action_query)
    {
        $request->validate([
            'records' => 'required|array'
        ]);

        $record_ids = $request->input('records');

        $resource = ResourceHelper::getModelOrFail($resource_id);
        $records = $resource->model()->whereIn('id', $record_ids)->get();

        $actions = $resource->resolveActions();

        foreach ($records as $record) {
            if ($action_query == 'delete') {
                $resource->delete($request, $resource, $record);

                continue;
            }

            if ($action_query == 'save') {
                $resource->save($request, $resource, $record);

                continue;
            }

            foreach ($actions as $action) {
                if ($action->id == $action_query) {
                    call_user_func($action->method, $request, $resource, $record);
                }
            }
        }

        return redirect()->route('vague.resource.index', [
            'resource' => $resource_id
        ]);
    }
}
