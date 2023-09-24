<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
class UserPostController extends Controller
{
    public function index(){

        $datas = Post::all();
        return response()->json($datas);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>'422',
                'error'=>$validator->errors()
            ]);
        }else{
            $model = new Post();
            $model->title = $request->title;
            $model->description = $request->description;
            $model->save();
            return response()->json([
                'status'=>'200',
                'msg'=>"Post added successfull"
            ]);
        }
    }
}