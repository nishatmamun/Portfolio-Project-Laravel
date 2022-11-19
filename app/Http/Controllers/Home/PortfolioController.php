<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use Image;
use Illuminate\Support\Carbon;

class PortfolioController extends Controller
{
    public function allPortfolio(){
        
        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_all', compact('portfolio'));
    }

    public function addPortfolio(){
        return view('admin.portfolio.portfolio_add');
    }

    public function storePortfolio(Request $request){
        
        $request->validate([
            'portfolioName' => 'required',
            'portfolioTitle' => 'required',
            'portfolioImage' => 'required',
        ],[
            'portfolioName.required' => 'Portfolio Name is Required',
            'portfolioTitle.required' => 'Portfolio Title is Required',
        ]);

        $image = $request->file('portfolioImage');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(1020,519)->save('upload/portfolio/'.$name_gen);
        $saveUrl = 'upload/portfolio/'.$name_gen;

        Portfolio::insert([
            'portfolio_name' => $request->portfolioName, 			
            'portfolio_title' => $request->portfolioTitle,
            'portfolio_description' => $request->portfolioDescription,
            'portfolio_image' => $saveUrl,
            'created_at' => Carbon::now()
        ]);
        
        $notification = array(
            'message' => 'Portfolio Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);
    }

    public function editPortfolio($id){

        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio.portfolio_edit', compact('portfolio'));
    }

    public function updatePortfolio(Request $request){

        $portfolio_id = $request->id;

        if($request->file('portfolioImage')){
            $image = $request->file('portfolioImage');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(1050,519)->save('upload/portfolio/'.$name_gen);
        $saveUrl = 'upload/portfolio/'.$name_gen;

        Portfolio::findOrFail($portfolio_id)->update([
            'portfolio_name' => $request->portfolioName, 			
            'portfolio_title' => $request->portfolioTitle,
            'portfolio_description' => $request->portfolioDescription,
            'portfolio_image' => $saveUrl,
            'created_at' => Carbon::now()
        ]);
        
        $notification = array(
            'message' => 'Home Slide Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);

        } else {
            
            Portfolio::findOrFail($portfolio_id)->update([
            'portfolio_name' => $request->portfolioName, 			
            'portfolio_title' => $request->portfolioTitle,
            'portfolio_description' => $request->portfolioDescription,
            'created_at' => Carbon::now()
        ]);
        
        $notification = array(
            'message' => 'Portfolio Updated Without Image Successfully',
            'alert-type' => 'success'
        );
            return redirect()->route('all.portfolio')->with($notification);
        }
    }

    public function deletePortfolio($id){

        $portfolio = Portfolio::findOrFail($id);
        $img = $portfolio->portfolio_image;
        unlink($img);

        Portfolio::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Portfolio Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.portfolio')->with($notification);
    }    

    public function portfolioDetails($id){
        
        $portfolio = Portfolio::findOrFail($id);
        return view('frontend.portfolio_details',compact('portfolio'));
    }
    
    public function homePortfolio(){
        
        $portfolio = Portfolio::latest()->get();
        return view('frontend.portfolio',compact('portfolio'));
    }

}