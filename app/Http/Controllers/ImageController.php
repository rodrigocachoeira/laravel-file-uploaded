<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    
    public function index()
    {
        return view('images.index');
    }

    public function show()
    {
        return Image::latest()->pluck('name')->toArray();
    }

    public function store()
    {
        if( ! request()->hasFile('image')) {
            return response()->json([
                'error' => 'There is not image present..'
            ], 500);
        }

        request()->validate([
            'image' => ['required', 'file', 'image', 'mimages:jpg,jpeg,png']
        ]);
        
        $path = request()->file('image')->store('public/images');
        if(! $path) {
            return response()->json([
                'error' => 'The file could not be saved'
            ], 500);
        }

        $file = request()->file('image');
        $image = Image::create([
            'name' => $file->hashName(),
            'extension' => $file->getExtension(),
            'size' => $file->getSize(),
        ]);

        return $image->name;
    }

}
