<?php

namespace App\Http\Controllers\logfile;

use App\Http\Controllers\Controller;
use App\Models\logfile\labourLogModel;
use Illuminate\Http\Request;

class labourLogController extends Controller
{
    //

    public function index(Request $request)
    {
        
        $keyword = $request->input('search');
        $labourLog = labourLogModel::select('*');

        if (!empty($keyword)) {
            $labourLog = $labourLog->where(function ($query) use ($keyword) {
                $query->where('description', 'LIKE', "%$keyword%")
                      ->orWhere('subject_type', 'LIKE', "%$keyword%")
                      ->orWhere('event', 'LIKE', "%$keyword%")
                      ->orWhere('subject_id', 'LIKE', "%$keyword%")
                      ->orWhere('causer_id', 'LIKE', "%$keyword%")
                      ->orWhere('causer_type', 'LIKE', "%$keyword%");
               
         
            });
        }
      

        $labourLog = $labourLog->orderByDesc('id')->paginate(10); 


        return view('logfile.index',compact('labourLog'));
    }
}
