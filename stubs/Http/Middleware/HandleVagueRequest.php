<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use PixelBoii\Vague\Middleware;

class HandleVagueRequest extends Middleware
{
    public function userHasAccess(Request $request)
    {
        return $request->user()->hasRoles(['Admin']);
    }
}
