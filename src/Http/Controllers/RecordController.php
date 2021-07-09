<?php

namespace PixelBoii\Vague\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use PixelBoii\Vague\Http\Helpers\ResourceHelper;
use PixelBoii\Vague\Breadcrumbs;
use PixelBoii\Vague\Vague;

class RecordController extends Controller
{
    public function index($resource, $record_id)
    {
        $resource = ResourceHelper::getModelOrFail($resource);
        $resource->bindRecord($resource->model()->whereId($record_id)->firstOrFail());

        $breadcrumbs = Breadcrumbs::make()->add('', 'Resource')->newRoot('resource')->add($resource->slug(), $resource->name())->add($resource->getAttribute('id'));

        return Inertia::render('Record', [
            'elements' => $resource->render(),
            'record' => $resource->record,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function action(Request $request, $resource_id, $record_id, $action_query)
    {
        $resource = ResourceHelper::getModelOrFail($resource_id);
        $record = $resource->model()->whereId($record_id)->firstOrFail();

        $actions = $resource->resolveActions();

        if ($action_query == 'delete') {
            return $resource->delete($request, $resource, $record);
        }

        if ($action_query == 'save') {
            return $resource->save($request, $resource, $record);
        }

        foreach ($actions as $action) {
            if ($action->id == $action_query) {
                $res = call_user_func($action->method, $request, $resource, $record);

                if (isset($res)) {
                    return $res;
                }
            }
        }

        return redirect()->route('vague.record.index', [
            'resource' => $resource_id,
            'record' => $record_id
        ]);
    }

    public function triggerEvent(Request $request, $resource, $record_id, $elementId, $event)
    {
        $resource = ResourceHelper::getModelOrFail($resource);
        $resource->bindRecord($resource->model()->whereId($record_id)->firstOrFail())->render();
        $element = Vague::$elements[$elementId] ?? null;

        if (is_null($element) || !in_array($event, array_keys($element->events))) {
            return abort(400);
        } else {
            $element->events[$event]['fn']($request, ...$request->json()->all());

            return response(null, 204);
        }
    }
}
