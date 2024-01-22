<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\customer\CustomerModel;
use App\Models\Labours\LabourModel;
use Yajra\DataTables\Datatables;

class CustomerController extends Controller
{
    //

    public function index(Request $request)
    {
      $keyword = $request->input('search');
        $customers = CustomerModel::select('*')->where('company_number', '!=','')
        ->where('company_name', '!=','');

        if(!empty($keyword)) {
          $customers = $customers->where(function ($query) use ($keyword) {
            $query->where('company_name', 'LIKE', "%$keyword%");
          });
        }

        $customers = $customers->orderBy('company_id','desc')->paginate(13);


        return view('customer.index',compact('customers'));
    }

    public function create()
    {
        $provinces = DB::table('provinces')->get();
        return view('customer.form-add',compact('provinces'));
    }

    public function edit(CustomerModel $customer)
    {    
      $provinces = DB::table('provinces')->get();
      return view('customer.form-edit',compact('provinces','customer'));
    }

    public function show(CustomerModel $customer)
    {    
      $provinces = DB::table('provinces')->get();
      return view('customer.form-show',compact('provinces','customer'));
    }



    public function update(Request $request, CustomerModel $customer)
    {

       $customer->update($request->all());
       return redirect()->back()->with('success', 'แก้ไขข้อมูลนายจ้างสำเร็จ!');
    }

    
    public function store(Request $request) 
    {

       // เช็ค เลข vat ซ้ำ
       $pass = CustomerModel::where('company_code',$request->company_code)->count();
       if($pass > 0)
       {
           return redirect()->back()->with('error','บันทึกข้อมูลล้มเหลว เนื่องจากข้อมูล บริษัท ซ้ำกันกับระบบ');
       }
     
       $findNumber = CustomerModel::latest()->where('company_number', '!=','')->value('company_number');

       // ถ้าไม่มีข้อมูลในตาราง
       if($findNumber === Null)
       {
          $number = 1;
       }else{
           $explode = explode('-',$findNumber);
           $number = $explode[1] + 1;
       }

       $Seq = substr('00000000'.$number, -8,8);
       $NewNumber = 'COM-'.$Seq;

       $request->merge(['company_number'=> $NewNumber]);

      if($request)
      {
        CustomerModel::create($request->all());
        return redirect()->route('customer.index')->with('success','บันทึกข้อมูลสำเร็จ!');
      }else{
        return redirect()->route('customer.index')->with('error','บันทึกข้อมูลล้มเหลว!');
      }
      
    }


    public function delete(CustomerModel $customer)
    {
      $customer->delete();
      return response()->json(['success' => true]);
    }


}
