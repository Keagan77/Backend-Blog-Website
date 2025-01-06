<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    // This method will return all blogs
    public function index(){

    }

    // This method will return a single blog
    public function show(){

    }

    // This method will store a blog
    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author'=> 'required'
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validation failed',
                'errors'=>$validator->errors()
            ]);
        }
    
        // Blog creation logic should be here, after validation passes
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->shortDesc = $request->shortDesc;
        $blog->save();
    
        return response()->json([
            'status'=> true,
            'message'=>'Blog created successfully',
            'data'=>$blog
        ]);
    }
    

    // This method will update the blog
    public function update(){

    }

    // This method will delete a blog
    public function destroy(){

    }

}