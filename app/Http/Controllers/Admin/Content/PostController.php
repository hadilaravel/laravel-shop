<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Content\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Content\PostCategory;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\Content\PostRequest;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

//    public function __construct()
//    {
//        $this->authorizeResource(Post::class , 'post');
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.post.index' , compact('posts') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $postCategoris = PostCategory::all();
        return view('admin.content.post.create' , compact('postCategoris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request , ImageService $imageService)
    {
        $inputs = $request->all();

        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if($result === false)
            {
                return redirect()->route('admin.content.post.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }
        $inputs['author_id'] = auth()->user()->id;
        $post = Post::create($inputs);
        $slug = persianSlug($post->title) . '-' . $post->id;
        $post->update(['slug' => $slug]);
        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست  جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $postCategories = PostCategory::all();
        return view('admin.content.post.edit' , compact('post' , 'postCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post, ImageService $imageService)
    {
//        if(!Gate::allows('update-post' , $post)){
//            abort(403);
//        }
//        $response = Gate::inspect('update-post');
//        if($response->allowed()){
//
//        }else{
//            dd($response->message());
//        }



        $inputs = $request->all();

        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if($request->hasFile('image'))
        {
            if(!empty($post->image)){
                $imageService->deleteDirectoryAndFiles($post->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if($result === false)
            {
                return redirect()->route('admin.content.post.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }else{
            if(isset($inputs['currentImage']) && !empty($post->image) ){
                $image = $post->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $post->update($inputs);
        return redirect()->route('admin.content.post.index')->with('swal-success', ' پست شما با موفقیت ویرایش شد');
    }

    public function status(Post $post){

        $post->status = $post->status == 0 ? 1 : 0;
        $result = $post->save();
        if($result){
            if($post->status == 0){
                return response()->json(['status' => true, 'checked' => false]);
            }
            else{
                return response()->json(['status' => true, 'checked' => true]);
            }
        }
        else{
            return response()->json(['status' => false]);
        }

    }

    public function commentable(Post $post){

        $post->commentable = $post->commentable == 0 ? 1 : 0;
        $result = $post->save();
        if($result){
            if($post->commentable == 0){
                return response()->json(['commentable' => true, 'checked' => false]);
            }
            else{
                return response()->json(['commentable' => true, 'checked' => true]);
            }
        }
        else{
            return response()->json(['commentable' => false]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $result = $post->delete();
        return redirect()->route('admin.content.post.index')->with('swal-success' , 'پست شما با موفقیت حذف شد');
    }
}
