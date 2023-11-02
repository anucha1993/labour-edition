<?php

namespace App\Http\Controllers\importGroup;

use App\Http\Controllers\Controller;
use App\Models\importGroup\importGroupModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Datatables;

class importGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('auth');
     }

    public function index(Request $request)
    {
        //
        if($request->ajax())
        {
            $data = importGroupModel::select('*')->get();
            return Datatables::of($data)
            ->addColumn('delete',function ($row){
                $delete = '<a href='.route("importgroup.delete",$row->import_id).' class="text-danger"  onclick="return confirm(`คุณต้องการ ลบข้อมูล ใช่  หรือ ไม่ ?`)" ><i class="fa fa-trash"></i></a>';
                return $delete;
            })
            ->addColumn('action',function ($row){
                $delete = '
                <a href='.route("importgroup.edit",$row->import_id).' class="text-info import-group-edit"><i class="fa fa-edit"></i></a>
                 
                <script>
                 $(document).ready(function() {
                $(".import-group-edit").click(function(e) {
                e.preventDefault();
                var modal = $("#modal-edit-import-group");
                modal.modal("show");
                modal.addClass(" modal-lg")
                modal.addClass("container")
                modal.find(".modal-content").load($(this).attr("href"));
                });
                });
                </script>
                ';
                return $delete;
            })
            ->addColumn('status',function ($row){
                 if($row->import_status === 'Y')
                 {
                    $status = '<span class="text-success"><i class="fa fa-eye"></i></span>';
                 }else{
                    $status = '<span class="text-danger"><i class="fa fa-eye-slash"></i></span>';
                 }
                return $status;
            })
            ->rawColumns(['delete','action','status'])
            ->make();
        }
        $import = importGroupModel::select('*')->paginate(15);
        return view('import-group.index',compact('import'));
    }

    public function modalAdd()
    {
        return view('import-group.modal-add');
    }
    public function modalStore(Request $request)
    {
        $request->merge(['import_user_add' => Auth::user()->name]);
        importGroupModel::create($request->all());
        return redirect()->back()->with('success','Create Import Successfully');
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
        //
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
    public function edit(importGroupModel $importGroupModel)
    {
        //
        return view('import-group.modal-edit',compact('importGroupModel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, importGroupModel $importGroupModel)
    {
        //
        $importGroupModel->update($request->all());
        return redirect()->back()->with('success','แก้ไขข้อมูลสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(importGroupModel $importGroupModel)
    {
        //
        $importGroupModel->delete();
        return redirect()->back()->with('success','ลบข้อมูลสำเร็จ');
    }
}
