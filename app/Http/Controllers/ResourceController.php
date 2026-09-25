<?php

namespace App\Http\Controllers;

use App\Models\Resource;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::latest()->get();
        return response()->json($resources);
    }
}