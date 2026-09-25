<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ResourceAdminController extends Controller
{
    public function index()
    {
        $resources = Resource::latest()->get();
        return response()->json($resources);
    }

    public function show($id)
    {
        $resource = Resource::findOrFail($id);
        return response()->json($resource);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'desc'  => 'required|string|max:500',
            'href'  => 'required|url|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'resources']
            );
            $data['image'] = $uploadedFile['secure_url'];
        }

        $resource = Resource::create($data);

        return response()->json([
            'success'  => true,
            'message'  => 'Resource created successfully',
            'resource' => $resource,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        $data = $request->validate([
            'brand' => 'sometimes|required|string|max:100',
            'title' => 'sometimes|required|string|max:255',
            'desc'  => 'sometimes|required|string|max:500',
            'href'  => 'sometimes|required|url|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'resources']
            );
            $data['image'] = $uploadedFile['secure_url'];
        }

        $resource->update($data);

        return response()->json([
            'success'  => true,
            'message'  => 'Resource updated successfully',
            'resource' => $resource,
        ]);
    }

    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->delete();

        return response()->json([
            'success' => true,
            'message' => 'Resource deleted successfully',
        ]);
    }
}