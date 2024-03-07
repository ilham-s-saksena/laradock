<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeService;
use Illuminate\Support\Facades\Validator;   

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $content = $this->homeService->getAllContent();
        $total_content = $content->count();

        if ($total_content == 0) {
            return response()->json([
                "message" => "ok",
                "content" => "Content is Empty",
                "total_content" => $content->count(),
            ], 404);
        } else {   
            return response()->json([
                "message" => "ok",
                "content" => $content,
                "total_content" => $content->count(),
            ], 200);
        }
    }

    public function show($id){
        $data = $this->homeService->getById($id);
        if ($data !== null) {
            return response()->json([
                "message" => "ok",
                "content" => $data,
            ], 200);
        } else {
            return response()->json([
                "message" => "err, not found"
            ], 404);
        }
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "err",
                'errors' => $validator->errors()->all()
            ], 400);
        }

        if($this->homeService->storeContent($request->all())){
            return response()->json([
                "message" => "ok"
            ], 201);
        } else {
            return response()->json([
                "message" => "err"
            ], 501);
        }
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => "err",
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $up = $this->homeService->updateContent($id, $request->all());

        if($up == 404){
            return response()->json([
                "message" => "err, Content id not Found"
            ], $up);
        } elseif ($up == 201) {
            return response()->json([
                "message" => "ok"
            ], $up);
        } else {
            return response()->json([
                "message" => "err"
            ], $up);
        }

        
    }

    public function delete($id){
        if($this->homeService->deleteContent($id)){
            return response()->json([
                "message" => "ok"
            ], 201);
        } else {
            return response()->json([
                "message" => "err"
            ], 404);
        }
    }

    
}
