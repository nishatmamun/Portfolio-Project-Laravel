<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Image;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    public function allBlog(){

        $blogs = Blog::latest()->get();
        return view('admin.blogs.blogs_all', compact('blogs'));
    }

    public function addBlog(){

        $categories = BlogCategory::orderBy('blogCategory','ASC')->get();
        return view('admin.blogs.blogs_add', compact('categories'));
    }

    public function storeBlog(Request $request){

        $image = $request->file('blogImage');
        $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(430,327)->save('upload/blog/'.$name_gen);
        $saveUrl = 'upload/blog/'.$name_gen;
 
        Blog::insert([
            'blog_category_id' => $request->blog_category_id, 			
            'blogTitle' => $request->blogTitle,
            'blogDescription' => $request->blogDescription,
            'blogTags' => $request->blogTags,
            'blogImage' => $saveUrl,
            'created_at' => Carbon::now()
        ]);
        
        $notification = array(
            'message' => 'Blog Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog')->with($notification); 
    }

    public function editBlog($id){
        
        $categories = BlogCategory::orderBy('blogCategory','ASC')->get();
        $blogs = Blog::findOrFail($id);
        return view('admin.blogs.blogs_edit', compact('blogs','categories'));
    }

    public function updateBlog(Request $request){
        
        $blog_id = $request->id;

        if($request->file('blogImage')){
            $image = $request->file('blogImage');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(430,327)->save('upload/blog/'.$name_gen);
        $saveUrl = 'upload/blog/'.$name_gen;

        Blog::findOrFail($blog_id)->update([
            'blog_category_id' => $request->blog_category_id, 			
            'blogTitle' => $request->blogTitle,
            'blogTags' => $request->blogTags,
            'blogDescription' => $request->blogDescription,
            'blogImage' => $saveUrl,
        ]);
        
        $notification = array(
            'message' => 'Blog Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog')->with($notification);

        } else {
            
            Blog::findOrFail($blog_id)->update([
            'blog_category_id' => $request->blog_category_id, 			
            'blogTitle' => $request->blogTitle,
            'blogTags' => $request->blogTags,
            'blogDescription' => $request->blogDescription,
        ]);
        
        $notification = array(
            'message' => 'Blog Updated Without Image Successfully',
            'alert-type' => 'success'
        );
            return redirect()->route('all.blog')->with($notification);
        }
    }

    public function deleteBlog($id){

        $blog = Blog::findOrFail($id);
        $img = $blog->blogImage;
        unlink($img);

        Blog::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog')->with($notification);
    } 

    public function blogDetails($id){

        $allBlogs = Blog::latest()->limit(5)->get();
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blogCategory','ASC')->get();
        return view('frontend.blog_details', compact('blogs','allBlogs','categories'));
    }

    public function categoryBlog($id){

        $blogPost = Blog::where('blog_category_id',$id)->orderBy('id','DESC')->get();
        $allBlogs = Blog::latest()->limit(5)->get();
        $categories = BlogCategory::orderBy('blogCategory','ASC')->get();
        $catname = BlogCategory::findOrFail($id);
        return view('frontend.cat_blog_details', compact('categories','allBlogs','blogPost','catname'));
    }

    public function homeBlog(){

        $categories = BlogCategory::orderBy('blogCategory','ASC')->get();
        $allBlogs = Blog::latest()->paginate(3);
        return view('frontend.blog', compact('allBlogs','categories'));
    }
}