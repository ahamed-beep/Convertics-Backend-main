<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BlogAdminController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return response()->json($blogs);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'category'=> ['required', Rule::in(['Marketing', 'B2B', 'Design'])],
            'excerpt' => 'required|string|max:500',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'  => 'nullable|in:draft,published',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'blogs']
            );
            $data['image'] = $uploadedFile['secure_url'];
        }

        $blog = Blog::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully',
            'blog'    => $blog,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title'   => 'sometimes|required|string|max:255',
            'category'=> ['sometimes', 'required', Rule::in(['Marketing', 'B2B', 'Design'])],
            'excerpt' => 'sometimes|required|string|max:500',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'  => 'nullable|in:draft,published',
        ]);

        if (isset($data['title']) && $data['title'] !== $blog->title) {
            $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        }

        if ($request->hasFile('image')) {
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'blogs']
            );
            $data['image'] = $uploadedFile['secure_url'];
        }

        $blog->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
            'blog'    => $blog,
        ]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully',
        ]);
    }
}