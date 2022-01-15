<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;
use File;
use App\Models\Blog;
Use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() 
    {
        return view('home.index');
    }

    public function createBlog(Request $request){

        return view('home.create');

    }

    public function storeBlog(Request $request){

        try{

            $rules = [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required',
                'expiration' => 'required'
               ];

     $validator = Validator::make($request->all() , $rules);

     if ($validator->fails())
     {
         $response_array = ['alert_type' => 'error', 'message' => implode(',', $validator->messages()->all())];
         return response()->json($response_array, 200);
 
     }else{
         $image_name = "";
         if ($request->hasFile('image'))
         {

             $filenameoriginal = $request->file('image')
                 ->getClientOriginalName();

             $image_name = 'blog/Blog' . '_' . time() . "." . $request->file('image')
                 ->getClientOriginalExtension();

             $destinationPath = public_path('images/blog');

             $request->file('image')
                 ->move($destinationPath, $image_name);

         }
         $blog = new Blog();
         $blog->user_id = Auth::user()->id;
         $blog->image  = $image_name;
         $blog->title = $request->title;
         $blog->description = $request->description;
         $blog->expiration = $request->expiration;
         $blog->published = $request->published;
         $blog->save();

         $response_array = ['alert_type' => 'success', 'message' => "Blog created successfully."];
         return response()->json($response_array, 200);
     }


        }catch(Exception $e) {   
            Log::info('log '. print_r($e->getMessage(), true));
            return response()->json(['alert_type' => 'error', 'message' => "Something went wrong."]);  
        }
    }

    public function getBlogDataJson(Request $request)
    {
        try{
            $blogs = Blog::where('user_id',Auth::user()->id)->get();
            return response()->json($blogs, 200);
        }catch(Exception $e) {   
            Log::info('log '. print_r($e->getMessage(), true));
            return response()->json(['alert_type' => 'error', 'message' => "Something went wrong."]);  
        }
      
    }

    public function editBlog(Request $request, $id){ 
        
        try{

            if (Blog::where('id', $id)->exists()) {
      
                $edit_blog = Blog::where('id',$id)->first();
    
                return view('home.edit',compact('edit_blog'));
    
            }else{
                $response_array = ['alert_type' => 'error', 'message' => "Blog not found."];
                return response()->json($response_array, 200);
            }

        }catch(Exception $e) {   
            Log::info('log '. print_r($e->getMessage(), true));
            return response()->json(['alert_type' => 'error', 'message' => "Something went wrong."]);  
        }

    }

    public function updateBlog(Request $request){
        try{

            $rules = [
                'title' => 'required',
                'description' => 'required',
                'expiration' => 'required'
               ];
    
            $validator = Validator::make($request->all() , $rules);
    
            if ($validator->fails())
            {
                $response_array = ['alert_type' => 'error', 'message' => implode(',', $validator->messages()->all())];
                return response()->json($response_array, 200);
    
            }else{
    
                $upd_blog = Blog::where('id',$request->id)->first();
    
                    if ($request->hasFile('image'))
                    {
                        $image_path = public_path('images/blog' . $upd_blog->image);
                            
                        if (File::exists($image_path))
                        {
                            File::delete($image_path);
                        }
    
                        $filenameoriginal = $request->file('image')
                            ->getClientOriginalName();
    
                        $image_name = 'blog/Blog' . '_' . time() . "." . $request->file('image')
                            ->getClientOriginalExtension();
    
                        $destinationPath = public_path('images/blog');
    
                        $request->file('image')
                            ->move($destinationPath, $image_name);
    
                        Blog::where('id',$upd_blog->id)->update(array('image' => $image_name));
    
                    }
                $upd_blog->title = $request->title;
                $upd_blog->description = $request->description;
                $upd_blog->expiration = $request->expiration;
                $upd_blog->published = $request->published;
                $upd_blog->update();
    
                $response_array = ['alert_type' => 'success', 'message' => "Blog Updated successfully."];
                return response()->json($response_array, 200);

            }

         }catch(Exception $e) {   
            Log::info('log '. print_r($e->getMessage(), true));
            return response()->json(['alert_type' => 'error', 'message' => "Something went wrong."]);  
        }
    }

    public function deleteBlog(Request $request,$id){

        try{
            if (Blog::where('id', $id)->exists()) {

                $delete_blog = Blog::where('id',$id)->first();

                if($delete_blog->image){
                    $image_path = public_path('images/blog' . $delete_blog->image);
                            
                    if (File::exists($image_path))
                    {
                        File::delete($image_path);
                    }
                }
                $delete_blog->delete();

                $response_array = ['alert_type' => 'success', 'message' => "Blog Deleted successfully."];
                return response()->json($response_array, 200);


            }else{
                $response_array = ['alert_type' => 'error', 'message' => "Blog not found."];
                return response()->json($response_array, 200);
            }
        }catch(Exception $e) {   
            Log::info('log '. print_r($e->getMessage(), true));
            return response()->json(['alert_type' => 'error', 'message' => "Something went wrong."]);
            
        }

    }


}
