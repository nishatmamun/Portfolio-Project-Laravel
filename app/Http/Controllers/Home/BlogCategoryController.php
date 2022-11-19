<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function allBlogCategory(){
        
        $blogCategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all', compact('blogCategory'));
    }

    public function addBlogCategory(){
        
        return view('admin.blog_category.blog_category_add');
    }

    public function storeBlogCategory(Request $request){



        BlogCategory::insert([
            'blogCategory' => $request->blogCategory,
        ]);
        
        $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function editBlogCategory($id){
        $blogCategory = BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit', compact('blogCategory'));
    }
    
    public function updateBlogCategory(Request $request, $id){

        BlogCategory::findOrFail($id)->update([
            'blogCategory' => $request->blogCategory
        ]);
        
        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function deleteBlogCategory($id){
        
        BlogCategory::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);
    }


}