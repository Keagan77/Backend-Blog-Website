<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    // This method will return all blogs
    public function index(){
        $blogs = Blog::orderBy("created_at","DESC")->get();

        return response()->json([
            'status'=> true,
            'data'=> $blogs
        ]);
    }

    // This method will return a single blog
    public function show($id){
        $blog = Blog::find($id);

        if($blog == null){
            return response()->json([
                'status'=>false,
                'message'=>'Blog Not Found!'
            ]);
        }

        return response()->json([
            'status'=>true,
            'data'=>$blog
        ]);
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

        // Save Image here

        $tempImage = TempImage::find($request->image_id);

        if($tempImage != null){
            $imageExtArray = explode(".", $tempImage->name);
            $ext = last($imageExtArray);
            $imageName = time().'-'.$blog->id.'.'.$ext;

            $blog->image = $imageName;
            $blog->save();

            $sourcePath = public_path("uploads/temp/".$tempImage->name);
            $destPath = public_path("uploads/blogs/".$imageName);
            File::copy($sourcePath,$destPath);
        }
    
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