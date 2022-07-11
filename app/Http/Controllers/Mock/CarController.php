<?php

namespace App\Http\Controllers\mock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars=Car::all();
        
        if(count($cars) > 0) {
            return response()->json(["status" => 200, "success" => true, "count" => count($cars), "data" => $cars]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no record found"]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            "description"  => "required",
            "model" => "required",
            "produced_on"  => "required|date",
            'image'=>'mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        if ($validation->fails()){
            $response=array('status'=>'error','errors'=>$validation->errors()->toArray()); 
            return response()->json($response);
        }
    //nếu dùng $this->validate() thì lấy về lỗi: $errors = $validate->errors();

        //kiểm tra file tồn tại
        $name='';
        
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $name=time().'_'.$file->getClientOriginalName();
            $file->move(public_path('image'), $name); //lưu hình ảnh vào thư mục public/images/cars
        } 
     
        $car=new Car();
        $car->description=$request->input('description');
        $car->model=$request->input('model');
        $car->produced_on=$request->input('produced_on');
        $car->image=$name;
        $car->save();
        if($car) {            
                return response()->json(["status" => "successful", "success" => true, "message" => "car record created successfully", "data" => $car]);
            }    
        else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $name='';
        
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $name=time().'_'.$file->getClientOriginalName();
            $file->move(public_path('image'), $name); //lưu hình ảnh vào thư mục public/images/cars
        } 
     
        $car = Car::find($id);
        
        $car->description=$request->input('description');
        $car->model=$request->input('model');
        $car->produced_on=$request->input('produced_on');
        $car->image=$name;
        $car->save();
        if($car) {            
                return response()->json(["status" => "successful", "success" => true, "message" => "car record created successfully", "data" => $car]);
            }    
        else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);
       
        //Xóa hình ảnh trong folder khi xóa
        // $imgLink = public_path('image/').$car->image;    
        // if(File::exists($imgLink)) {
        //     File::delete($imgLink);
        // }
        $car->delete();
        if($car) {            
            return response()->json(["status" => "successful", "success" => true, "message" => "car record created successfully", "data" => $car]);
        }else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
        }
    }
}
