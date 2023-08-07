<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category_id');
        $isDraft = $request->query('is_draft');
        $pageSize = $request->query('page_size') ?? 10;

        $blogs = Blog::where('title', 'like', '%' . $q . '%');

        if($isDraft){
            $blogs = $blogs->where('is_draft',filter_var($isDraft, FILTER_VALIDATE_BOOLEAN));
        }

        if ($categoryId) {
            $blogs = $blogs->where('category_id', $categoryId);
        }

        $blogs = $blogs->where('is_delete', false)->orderBy('id', 'DESC');

        return BlogResource::collection($blogs->paginate($pageSize));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $blog = Blog::create($request->validated());

        return BlogResource::make($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update($request->validated());

        return BlogResource::make($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response()->noContent();
    }
}
