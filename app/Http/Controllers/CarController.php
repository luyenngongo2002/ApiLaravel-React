<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Mf;
 
use Illuminate\Support\Facades\File;
 
class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // models là Car, nó ánh xạ đến bảng cars
        // dd($cars);
        // $manufacturers=Car::all()->manufacturer;
        // dd($manufacturers);
        // return view('index',['cars'=> $cars]);
        $cars=Car::all();
        return view('index',compact('cars'));
 
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mfs=Mf::all();
        return view('car-create',compact('mfs'));
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $name='';
        if($request -> hasfile('image')){
            $this->validate($request,[
                'image'=>'mimes:jpg,png,gif,jpeg|max: 2048'
            ],[
                'image.mimes'=>'Chỉ chấp nhận file hình ảnh',
                'image.max'=>'Chỉ chấp nhận hình ảnh dưới 2Mb',
            ]);
            $file = $request->file('image');
            $name =time().'_'.$file->getClientOriginalName();
            $destinationPath=public_path('image');
            $file -> move($destinationPath, $name);
        }
        $validated = $request->validate([
            'des' => 'required',
            'pro_on' => 'required|date',
            'model' => 'required'
        ],[
                'des.required' => 'Chưa nhập mô tả',
                'pro_on.required' => 'Chưa nhập ngày sản xuất',
                'model.required' => 'Chưa nhập số model',
                'pro_on.date' => 'Produces_on phải là số ngày',
        ]);
        $car = new Car();
        $car->des=$request->des;
        $car->model = $request->model;
        $car->pro_on = $request->pro_on;
        $car->mf_id = $request->mf_id;
        $car->img = $name;
        $car->save();
       
        return redirect()-> route('cars.index')->with('success', 'Bạn đã cập nhật thành công');
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car=Car::find($id);
             
        return view('show',['car'=>$car]);
 
       
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car=Car::find($id);
        $mfs=Mf::all();
        return view('car-edit',compact('car','mfs'));
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
        if($request -> hasfile('image')){
            $this->validate($request,[
                'image'=>'mimes:jpg,png,gif,jpeg|max: 2048'
            ],[
                'image.mimes'=>'Chỉ chấp nhận file hình ảnh',
                'image.max'=>'Chỉ chấp nhận hình ảnh dưới 2Mb',
            ]);
            $file = $request->file('image');
            $name =time().'_'.$file->getClientOriginalName();
            $destinationPath=public_path('image');
            $file -> move($destinationPath, $name);
        }
        $validated = $request->validate([
            'des' => 'required',
            'pro_on' => 'required|date',
            'model' => 'required'
        ],[
                'des.required' => 'Chưa nhập mô tả',
                'pro_on.required' => 'Chưa nhập ngày sản xuất',
                'model.required' => 'Chưa nhập số model',
                'pro_on.date' => 'Produces_on phải là số ngày',
        ]);
        $car = Car::find($id);
        $car->des = $request->des;
        $car->model = $request->model;
        $car->pro_on = $request->pro_on;
        $car->mf_id = $request->mf_id;
        $car->img = $name;
        $car->save();
        return redirect()-> route('cars.index')->with('success', 'Bạn đã cập nhật thành công');
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
        $imgLink = public_path('image/').$car->image;    
        if(File::exists($imgLink)) {
            File::delete($imgLink);
        }
        $car->delete();
        return redirect()-> route('cars.index')->with('success', 'Bạn đã xóa thành công');
    }
    //Tieens paplanw
}
