<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\about;
use App\Models\MultiImage;
use Image;
use Illuminate\Support\Carbon;


class AboutController extends Controller
{
    public function aboutPage(){
        $aboutPage = about::find(1);
        return view('admin.about_page.about_page_all', compact('aboutPage'));
    }

    public function updateAbout(Request $request){

        $about_id = $request->id;

        if($request->file('aboutImage')){
            $image = $request->file('aboutImage');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(523,605)->save('upload/home_about/'.$name_gen);
        $saveUrl = 'upload/home_about/'.$name_gen;

        about::findOrFail($about_id)->update([
            'title' => $request->title,
            'shortTitle' => $request->shortTitle,
            'shortDescription' => $request->shortDescription,
            'longDescription' => $request->longDescription,
            'aboutImage' => $saveUrl,
        ]);
        
        $notification = array(
            'message' => 'About Page Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else {
            
            about::findOrFail($about_id)->update([
            'title' => $request->title,
            'shortTitle' => $request->shortTitle,
            'shortDescription' => $request->shortDescription,
            'longDescription' => $request->longDescription,
        ]);
        
        $notification = array(
            'message' => 'About Page Updated without Image Successfully',
            'alert-type' => 'success'
        );

            return redirect()->back()->with($notification);
        }
    }

    public function homeAbout(){
        $aboutPage = about::find(1);
        return view('frontend.about_page', compact('aboutPage'));
    }

    public function aboutMultiImage(){
        return view('admin.about_page.multi_image');
    }

    public function storeMultiImage(Request $request){

        $image = $request->file('multiImage');
        
        foreach ($image as $multi_image) {
            
            $name_gen= hexdec(uniqid()).'.'.$multi_image->getClientOriginalExtension();

            Image::make($multi_image)->resize(220,220)->save('upload/multi/'.$name_gen);
            $saveUrl = 'upload/multi/'.$name_gen;

            MultiImage::insert([
               'multi_image' => $saveUrl,
               'created_at' => Carbon::now()
            ]);

        }
            $notification = array(
               'message' => 'Multiple Images Inserted Successfully',
               'alert-type' => 'success'
            );

            return redirect()->route('all.multi.image')->with($notification);
    }

    public function allMultiImage(){

        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multi_image', compact('allMultiImage'));
    }

    public function editMultiImage($id){
        
        $multiImage = MultiImage::findOrFail($id);
        return view('admin.about_page.edit_multi_image', compact('multiImage'));
    }

    public function updateMultiImage(Request $request){

        $multi_image_id = $request->id;

        if($request->file('multiImage')){
            $image = $request->file('multiImage');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(220,220)->save('upload/multi/'.$name_gen);
        $saveUrl = 'upload/multi/'.$name_gen;

        MultiImage::findOrFail($multi_image_id)->update([
            'multi_image' => $saveUrl,
        ]);
        
        $notification = array(
            'message' => 'Multi Image Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.multi.image')->with($notification);
        }
    }

    public function deleteMultiImage($id){
        
        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}