<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;



use Response;

use Validator;

use DateTime;

use DateInterval;

use Mail;

use Image;

use Cache;

class deleteShopController extends Controller
{
  

    public function deleteShop(Request $request)
    {
	

    if (!empty($deletedFolders)) {
        return response()->json(['message' => 'success', 'deleted_folders' => $request]);
    } else {
        return response()->json(['message' => 'ไม่พบโฟลเดอร์ที่ต้องการลบ'], 404);
    }
      
  
    }
	
public function showImageRegister(Request $request, $pid, $filename)
{
     //$imagePath = storage_path('app/register/2797/2797-image11-230910.jpg');
    $imagePath = storage_path('app/register/' . $pid . '/' . $filename);
    return response()->file($imagePath, ['Content-Type' => 'image/jpeg']);
}





	
	
}
