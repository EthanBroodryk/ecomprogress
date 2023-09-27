<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;


class FrontPageController extends Controller
{
    //

    public function displayEscortImages(Request $request):Response
    {
        // $images = Image::pluck('filename','user_id');
       
        $images = Image::all();
        return Inertia::render('Index', [
          'images'=>$images
        ]);

    }

    public function displaySelectedEscort(Request $request):Response
    {
 
      $product_image_id = $request->pic;
      $product = Image::find($product_image_id);
      
      return Inertia::render('ShowProduct',['product'=>$product]);

    }
}
