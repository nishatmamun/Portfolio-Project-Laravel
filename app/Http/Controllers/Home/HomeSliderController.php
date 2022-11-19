<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\homeSlide;
use Image;

class HomeSliderController extends Controller
{
    public function homeSlider(){

        $homeSlide = homeSlide::find(1);
        return view('admin.home_slide.home_slide_all',compact('homeSlide'));
    }

    public function updateSlider(Request $request){

        $slide_id = $request->id;

        if($request->file('homeSlide')){
            $image = $request->file('homeSlide');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(636,852)->save('upload/home_slide/'.$name_gen);
        $saveUrl = 'upload/home_slide/'.$name_gen;

        homeSlide::findOrFail($slide_id)->update([
            'title' => $request->title,
            'shortTitle' => $request->shortTitle,
            'videoUrl' => $request->videoUrl,
            'homeSlide' => $saveUrl,
        ]);
        
        $notification = array(
            'message' => 'Home Slide Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else {
            
            homeSlide::findOrFail($slide_id)->update([
            'title' => $request->title,
            'shortTitle' => $request->shortTitle,
            'videoUrl' => $request->videoUrl,
        ]);
        
        $notification = array(
            'message' => 'Home Slide Updated without Image Successfully',
            'alert-type' => 'success'
        );

            return redirect()->back()->with($notification);
        }
    }
    
}