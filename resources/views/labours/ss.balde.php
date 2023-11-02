<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Tracker;

use Form;

use Storage;

use Response;

use Validator;

use DateTime;

use DateInterval;

use Mail;

use Image;

use Cache;

class ThaCore extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $cache = TRUE;
	private $today;
	private $req = array();
	private $process = TRUE;
	private $redirect;
	private $csrf = '';
	
	// allow debug by yamq
	private $ipAllow = "183.88.114.60";

	private function re_csrf($page,$csrf_tmp)
	{
		$page_new = str_replace($csrf_tmp,$this->csrf,$page);

		return $page_new;
	}

	public function index(Request $request)
	{
		$this->csrf = csrf_token();

		if(!$this->chk_bot($request->header('User-Agent')))
		{
			$this->stat_visit_all($request);
			$this->stat_visit_day($request);
			$this->stat_visit_now($request);
		}

		$this->set_banner($request);

		$keypage = $request->url();
		if( $this->cache && Cache::has( $keypage ) )
		{
			$page = Cache::get( $keypage );
			$csrf_tmp = Cache::get( $keypage.'_csrf' );

			return $this->re_csrf($page,$csrf_tmp);
		}
		else
		{
			//echo "1";
			//echo "abc".$request->path().' - '.$request->url().' - '.$request->fullUrl().' - '.$request->method().' - '.$request->root();
			$file = 'index';

			$this->set_request($request);

			//echo 'QQ'.memory_get_usage().'<br/>';

			$page = $this->show_include_file($file);

			if($this->process)
			{
				//return 'hello world from controller : )';

				if( $this->cache )
				{
					Cache::put( $keypage, $page, 0.25 );
					Cache::put( $keypage.'_csrf', $this->csrf, 0.25 );
				}

				return $page;
			}
			else
			{
				return Redirect::away(url($this->redirect));
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int	$id
	 * @return Response
	 */
	public function home(Request $request, $any = '', $any2 = '', $any3 = '', $any4 = '')
	{
		$page_notcache = array('check_search');
		$keypage = $request->url();
		//echo '<!--'.$keypage.'-->';

		$this->csrf = csrf_token();

		if($any == 'show_pra.php' && is_numeric($request->query('id')))
		{
			return Redirect::to(url('amulet_detail/'.$request->query('id')),301);
		}
		else if($any == 'amulet_new_search.php' && is_numeric($request->query('caterogy')))
		{
			$pra_category = DB::table('pra_category')->where('CID', $request->query('caterogy'))->get();
			if(count($pra_category) > 0)
			{
				$pra_cat = $pra_category[0];
				return Redirect::to(url('category-amulet/'.$pra_cat->url),301);
			}
		}
		else if(($any == 'category-amulet' || $any == 'search-category') && is_numeric($any2))
		{
			$pra_category = DB::table('pra_category')->where('CID', $any2)->get();
			if(count($pra_category) > 0)
			{
				$pra_cat = $pra_category[0];
				$pra_url = 'category-amulet/'.$pra_cat->url;
				if(strlen($any3) > 0)
				{
					$pra_url .= '/'.$any3;

					if(strlen($any4) > 0)
					{
						$pra_url .= '/'.$any4;
					}
				}

				return Redirect::to(url($pra_url),301);
			}
		}

		if(!$this->cache || $request->isMethod('post') || in_array($any,$page_notcache) || $request->session()->has('shop_id'))
		{
			$cache = false;
		}
		else
		{
			$page_mincache = array('check_notification');

			$cache = true;

			if(!in_array($any,$page_mincache) && strlen($any2) > 0)
			{
				$t_cache = 1;
			}
			else
			{
				$t_cache = 0.25;
			}
		}

		//echo 'RR'.memory_get_usage().'<br/>';
		//echo "2";
		//echo "2".$request->offsetGet('any2');
		//print_r($request->offsetGet('any2'));
		//exit();
		//echo $any.' - '.$any2." - def".$request->path().' - '.$request->url().' - '.$request->fullUrl().' - '.$request->method().' - '.$request->root();
		//phpinfo();
		//if(!isset($_SERVER['UNENCODED_URL']) || strlen($any) <= 0)
		if((!isset($_SERVER['UNENCODED_URL']) && !isset($_SERVER['REQUEST_URI'])) || strlen($any) <= 0 || $any == 'index' || $any == 'index.php')
		{
			return $this->index($request);
		}
		else
		{
			if(!$this->chk_bot($request->header('User-Agent')))
			{
				$this->stat_visit_all($request);
				$this->stat_visit_day($request);
				$this->stat_visit_now($request);
			}

			$this->set_banner($request);

			if( $cache && Cache::has( $keypage ) && Cache::has( $keypage.'_csrf' ) )
			{
				$page = Cache::get( $keypage );
				$csrf_tmp = Cache::get( $keypage.'_csrf' );

				return $this->re_csrf($page,$csrf_tmp);
			}
			else
			{
				//echo "3";
				$this->set_request($request);

				$this->req['any'] = $any;

				if(strlen($any2) > 0)
				{
					$this->req['any2'] = $any2;

					if(strlen($any3) > 0)
					{
						$this->req['any3'] = $any3;

						if(strlen($any4) > 0)
						{
							$this->req['any4'] = $any4;
						}
					}
				}

				//$file = str_replace('/thaprachan/','',$_SERVER['UNENCODED_URL']);
				$file = str_replace('.php','',$any);
				$page = $this->show_include_file($file);

				if($this->process)
				{
					if( $cache )
					{
						Cache::put( $keypage, $page, $t_cache );
						Cache::put( $keypage.'_csrf', $this->csrf, $t_cache );
					}

					return $page;
				}
				else
				{
					return Redirect::away(url($this->redirect));
				}
			}
		}

		//$admin = Auth::user();
		//return Redirect::away('stats');
	}
	
	private function checkOtpUpdate(Request $request, $shop_id){
		
		if($request->ip() == $this->ipAllow){
			$shop_otp = DB::table('shop_member')->where([['shop_id', $shop_id]])->get();
			
			if(count($shop_otp) > 0){
				$shopOtp = $shop_otp[0];
				//ตรวจสอบ เบอร์ใหม่เข้าสู่ระบบเพื่อรองรับระบบ otp 0=ยังไม่อัพเดท , 1=อัพเดทแล้ว
				if($shopOtp->sms_update_status == 0){
					echo "<script>console.log('".$request->ip()." up')</script>";
//					echo "<script>window.location='/merchant/warning'</script>";
//					exit();
					return Redirect::away(url('/merchant/warning'));
				}
			}
		}
	}

	public function shop(Request $request, $any = '', $any2 = '', $any3 = '', $any4 = '')
	{
		$this->set_request($request);
		
		$go_out = true;
		if($request->session()->has('shop_id'))
		{
			if($request->session()->has('admin_id'))
			{
				$go_out = false;
			}
			else
			{
				//$shop_member = DB::table('shop_member')->where('shop_id', $request->session()->get('shop_id'))->where([['new_or_not', '0'],['start_stop', '0'],['shop_status','<','2']])->whereRaw('\''.$this->today.'\' < DATE_ADD(DATE(start_date), INTERVAL pay_type MONTH)')->count();
				$shop_member = DB::table('shop_member')->where([['shop_id', $request->session()->get('shop_id')],['new_or_not', '0'],['start_stop', '0'],['shop_status','<','2']])->count();
				if($shop_member > 0)
				{
					$go_out = false;
				}
			}
		}

		if($go_out)
		{
			return Redirect::away(url('/logout'));
		}
		/*$request->session()->put('key2', 'value');

		$value = $request->session()->get('key');
		$value = $request->session()->all();

		print_r($value);*/
		//if(!isset($_SERVER['UNENCODED_URL']) || strlen($any) <= 0)
		if((!isset($_SERVER['UNENCODED_URL']) && !isset($_SERVER['REQUEST_URI'])) || strlen($any) <= 0)
		{
			//abort(404);
			return Redirect::away(url('/merchant/index'));
		}
		else
		{
			//echo "3";
			if(strlen($any) > 0)
			{
				$this->req['any'] = $any;

				if(strlen($any2) > 0)
				{
					$this->req['any2'] = $any2;

					if(strlen($any3) > 0)
					{
						$this->req['any3'] = $any3;

						if(strlen($any4) > 0)
						{
							$this->req['any4'] = $any4;
						}
					}
				}
			}
			

			//$file = str_replace('/thaprachan/','',$_SERVER['UNENCODED_URL']);
			$file = str_replace('.php','',$any);
			return $this->show_include_file($file,'shop');
		}
		
		

		//$admin = Auth::user();
		//return Redirect::away('stats');
	}

	public function shop_login(Request $request)
	{
		
		$goshop = false;
		$message = 'การล็อคอินผิดพลาด กรุณาลองใหม่อีกครั้ง หากสมาชิกล็อคอินครั้งแรกหลังจากที่เว็บได้เปลี่ยนระบบและไม่ได้รับการแจ้งรหัสใหม่ทาง SMS (22 ธค. 2560 เวลา 02.30 น.) กรุณาติดต่อเจ้าหน้าที่เพื่อขอรับรหัสใหม่ทางไลน์  @thaprachandotcom';

		if($request->isMethod('post'))
		{
			$rules = [
				'form-user' => 'required',
				'form-pass' => 'required',
			];
			$messages = [
				'required' => 'จำเป็นต้องมีข้อมูล',
				/*'form-name.required' => 'กรุณาใส่ชื่อผู้ติดต่อ',*/
			];

			$validator = Validator::make($request->all(), $rules, $messages);

			if ($validator->fails()) {
				$errors = $validator->errors();
			}
			else
			{
				$user = $request->input('form-user');
				$pass = $request->input('form-pass');

				$shop_member = DB::table('shop_member')->where([['username', $user],['pwd', $pass]])->get();
				if(count($shop_member) > 0)
				{
					//$request->session()->put('shop_id', '351');
					//$request->session()->put('shop_id', '20');

					$shop = $shop_member[0];

					if($shop->new_or_not == 1)
					{
						$message = 'การสมัคร/ต่ออายุ ยังไม่สมบรูณ์ อันเนื่องมาจากท่านยังมิได้ทำการชำระค่าสมาชิก';
					}
					else if($shop->shop_status == 3)
					{
						$message = 'ไม่สามารถเข้าใช้งานได้ กรุณาติดต่อเจ้าหน้าที่';
					}
					else if($shop->start_stop == 0)
					{
						$goshop = true;
					}
					else
					{
						$customer_stop = DB::table('customer_stop')->where([['shop_id', $shop->shop_id],['status', $shop->start_stop]])->orderBy('id', 'desc')->get();

						if(count($customer_stop) > 0)
						{
							$stop = $customer_stop[0];

							$patterns = array("/\\\\/", '/\n/', '/\r/', '/\t/', '/\v/', '/\f/');
							$replacements = array('\\\\\\', '\n', '\r', '\t', '\v', '\f');
							$comment = preg_replace($patterns, $replacements, $stop->comment);

							if($shop->start_stop == 4)
							{
								$message = 'ระงับการให้บริการ';

								if(strlen($comment) > 0)
								{
									$message .= ' เนื่องจาก '.str_replace('\r\n','\n',$comment);
								}
							}
							else
							{
								$date_stop = strtotime($stop->enddate) - time();

								if($date_stop > 0)
								{
									$date_stop = ceil($date_stop / 86400);

									$message = 'ระงับการให้บริการอีก '.$date_stop.' วัน';

									if(strlen($comment) > 0)
									{
										$message .= ' เนื่องจาก '.str_replace('\\r\\n','\\n',$comment);
									}
								}
								else
								{
									$sql = array(
										'start_stop' => 0
									);
									DB::table('shop_member')->where('shop_id', $shop->shop_id)->update($sql);

									$goshop = true;
								}
							}
						}
						else
						{
							$message = 'ระงับการให้บริการชั่วคราว กรุณาติดต่อเจ้าหน้าที่';
						}
					}

					if($goshop)
					{
						$d_start = new DateTime($shop->start_date);
						$d_start->setTime( 0,0,1 );
						$d_expire = new DateTime($shop->start_date);
						$d_expire->setTime( 0,0,0 );
						$d_now = new DateTime('now');
						if($shop->pay_type <= 0)
						{
							$shop->pay_type = 12;
						}
						$d_expire->add(new DateInterval('P'.$shop->pay_type.'M'));
						$expire = $d_expire->format('Y-m-d');
						$d_expire->add(new DateInterval('P90D'));

						/*$d_count = $d_expire->diff($d_now);
						$countdown = '';
						if($d_count->days > 0)
						{
							$countdown = $d_count->days.' วัน';
						}
						else
						{
							if($d_count->format('%H') > 0)
							{
								$countdown = $d_count->format('%H ชั่วโมง ');
							}

							$countdown .= $d_count->format('%i นาที');
						}*/

						if($d_now >= $d_expire)
						{
							$message = 'ระงับการให้บริการชั่วคราว เนื่องจากร้านค้าของท่านได้หมดอายุแล้ว กรุณาติดต่อเจ้าหน้าที่ วันหมดอายุคือ '.$expire;

							$goshop = false;
						}
					}
				}
			}
		}

		if($goshop)
		{
		
			//ให้แสดงเฉพาะคนเขียน
//			if($shop->shop_id == "5615" ){



				if($shop->sms_update_status == "1" and strlen($shop->otp_telephone) == 10){
					//sms update ให้ไปหน้ากรอก otp
					$rand = rand(000000, 999999);
					$rand = sprintf("%06d", $rand);

					$request->session()->put('otp', array(
						'confirm' => 1,
						'otp' => $rand,
						"time" => strtotime("now"),
						"shop_id" => $shop->shop_id,
						"login_time" => $shop->login_time
					));

					require_once "THsms.class.php";
					$sms = new \THsms();
					$send = $sms->send_message($shop->otp_telephone, "รหัสยืนยัน Thaprachan.com OTP CODE: ".$rand ." ");

					require_once "Linenotify.class.php";
					$line = new \Linenotify();
					$txt = "\r\n.::Login::.";
					$txt .= "\r\n อัพเดทเบอร์แล้ว";
					$txt .= "\r\n TEL:".$shop->tel. "OTP:". $rand;
					$txt .= "\r\nID: ".$shop->shop_id;
					$txt .= "\r\nName: ".$shop->name;
					$txt .= "\r\nEmail: ".$shop->email;
					$txt .= "\r\nUser: ".$shop->username;
					$txt .= "\r\nAddress: ".$shop->address;
					$line->send_message($txt);

					return Redirect::away(url('/login_otp'));
				}else{
					//ถ้ายังไม่ได้ update เบอร์โทร จะให้ไปหน้า อัพเดทเบอร์โทรก่อน
					$request->session()->put('shop_id', $shop->shop_id);
					$request->session()->put('last_login', $shop->login_time);

					$rand = rand(000000, 999999);
					$rand = sprintf("%06d", $rand);

					$request->session()->put('otp', array(
						'confirm' => 1,
						'otp' => $rand,
						"time" => strtotime("now"),
						"login_time" => $shop->login_time
					));



					return Redirect::away(url("/merchant/warning"));
				}



//			}else{
//
//				//login ของเดิมตอนยังไม่มี otp
//				$request->session()->put('shop_id', $shop->shop_id);
//				$request->session()->put('last_login', $shop->login_time);
//
//				$sql2 = [
//					'login_time' => date("Y-m-d H:i:s"),
//				];
//
//				DB::table('shop_member')->where('shop_id', $shop->shop_id)->update($sql2);
//
//				require_once "Linenotify.class.php";
//				$line = new \Linenotify();
//				$txt = "\r\n.::Login::.";
//				$txt .= "\r\nID: ".$shop->shop_id;
//				$txt .= "\r\nName: ".$shop->name;
//				$txt .= "\r\nEmail: ".$shop->email;
//				$txt .= "\r\nUser: ".$shop->username;
//				$txt .= "\r\nAddress: ".$shop->address;
//				$line->send_message($txt);
//
//				return Redirect::away(url('/merchant/index'));
//
//			}
		
		
		}
		else
		{
			$request->session()->put('status_message', $message);

			return Redirect::away(url('/'));
		}
	}
	
	public function otp(Request $request){
		$opt_code = $request->session()->get('otp')['otp'];
		$shop_id = $request->session()->get('otp')['shop_id'];
		$login_time = $request->session()->get('otp')['login_time'];
		//dd($_POST);
		if($_POST['otp_code'] == $opt_code){
			$request->session()->put('shop_id', $shop_id);
			$request->session()->put('last_login', $login_time);
			
			require_once "Linenotify.class.php";
			$line = new \Linenotify();
			$txt = "\r\n.::Login success::.";
			$txt .= "\r\nID: ".$shop_id. " เข้าสู่ระบบได้แล้ว";
			$line->send_message($txt);
			
			return Redirect::away(url('/merchant/index'));
		}else{
			$request->session()->put('status_message', 'คุณกรอก otp ไม่ถูกต้องโปรดลองใหม่อีกครั้ง');
			return Redirect::away(url('/'));
		}

	}
	
	private function THsms_send_message($tel, $otp_num){
		$sms = new THsms();
		$result_sms = $sms->send_message($tel, "รหัสยืนยัน Thaprachan.com OTP CODE: ".$otp_num ." ");
		return $result_sms;
	}

	public function shop_forgot(Request $request)
	{
		$message = 'ไม่พบ Email นี้ในฐานข้อมูล หรือคุณอาจพิมพ์ผิด';

		if($request->isMethod('post'))
		{
			$rules = [
				'form-email' => 'required|email',
			];
			$messages = [
				'required' => 'จำเป็นต้องมีข้อมูล',
				/*'form-name.required' => 'กรุณาใส่ชื่อผู้ติดต่อ',*/
			];

			$validator = Validator::make($request->all(), $rules, $messages);

			if ($validator->fails()) {
				$errors = $validator->errors();
			}
			else
			{
				$email = $request->input('form-email');

				$shop_member = DB::table('shop_member')->where([['email', $email],['new_or_not', '0'],['shop_status','<','2']])->get();
				if(count($shop_member) > 0)
				{
					$shop = $shop_member[0];

					Mail::send('email.forgot', ['shop' => $shop,'shop_member' => $shop_member], function ($m) use ($shop) {
						$m->from(env('MAIL_SENDER', 'noreply@thaprachan.com'), 'ThaprachanDotCom');

						//$m->to($user->email, $user->name)->subject('Your Reminder!');
						$m->to($shop->email, $shop->name.' '.$shop->sname)->subject('Password Recovery');
					});

					$message = 'ระบบได้ทำการส่งรหัสผ่านให้ทาง Email ที่แจ้งมาแล้ว';
				}
			}
		}

		$request->session()->put('status_message', $message);

		return Redirect::away(url('/'));
	}

	public function shop_logout(Request $request)
	{
		$request->session()->forget('shop_id');

		return Redirect::away(url('/'));
	}

	public function admin_hack(Request $request, $any = '', $any2 = '', $any3 = '', $any4 = '')
	{
		$this->hack_error($request,'Hacker Attack');

		return $this->admin($request, $any, $any2, $any3, $any4, false);
	}

	public function admin_index_hack(Request $request, $any = '', $any2 = '', $any3 = '', $any4 = '')
	{
		//$this->hack_error($request,'Hacker Attack Index');

		return $this->admin($request, 'index', $any2, $any3, $any4, false);
	}

	public function admin(Request $request, $any = '', $any2 = '', $any3 = '', $any4 = '', $nohack = true)
	{
		
		$go_out = true;
		if($nohack && $request->session()->has('admin_id'))
		{
			$shop_member = DB::table('tha_admin')->where('admin_id', $request->session()->get('admin_id'))->get();
			if(count($shop_member) < 0)
			{
				$go_out = false;
			}
		}

		if($go_out && $any != 'index' && $any != 'tp-jlogin')
		{
			return Redirect::away(url('/admin/index'));
		}
//		$request->session()->put('key2', 'value');
//
//		$value = $request->session()->get('key');
//		$value = $request->session()->all();
//
//		print_r($value);

		//if(!isset($_SERVER['UNENCODED_URL']) || strlen($any) <= 0)
		if((!isset($_SERVER['UNENCODED_URL']) && !isset($_SERVER['REQUEST_URI'])) || strlen($any) <= 0)
		{
			abort(404);
		}
		else if($nohack && $any == 'view_shop')
		{
			$shop_member = DB::table('shop_member')->where('shop_id_main',$any2)->get();
			if(count($shop_member) > 0)
			{
				$shop = $shop_member[0];

				$request->session()->put('shop_id', $shop->shop_id);
				
				return Redirect::away(url('/merchant/index'));
			}
			else
			{
				abort(404);
			}
		}
		else if($nohack && $any == 'reset_otp'){
			$shop_member = DB::table('shop_member')->where('shop_id',$any2)->get();
			if(count($shop_member) > 0){
				$shop = $shop_member[0];
				
				
				$sql = array(
					'sms_update_status' => '0'
				);
				DB::table('shop_member')->where('shop_id', $shop->shop_id)->update($sql);
				
				
				return "<script>alert('Reset หมายเลขโทรศัพท์ของร้านค้านี้แล้ว');window.close()</script>";
				
			}else{
				abort(404);
			}
		}
		else
		{
			//echo "3";
			$this->set_request($request);

			if(strlen($any) > 0)
			{
				$this->req['any'] = $any;

				if(strlen($any2) > 0)
				{
					$this->req['any2'] = $any2;

					if(strlen($any3) > 0)
					{
						$this->req['any3'] = $any3;

						if(strlen($any4) > 0)
						{
							$this->req['any4'] = $any4;
						}
					}
				}
			}

			//$file = str_replace('/thaprachan/','',$_SERVER['UNENCODED_URL']);
			$file = str_replace('.php','',$any);
			return $this->show_include_file($file,'admin');
		}

		//$admin = Auth::user();
		//return Redirect::away('stats');
	}
	
	public function test(Request $request) {
	
//		$request->session()->put('admin_id', 1);
//
//		return Redirect::away(url('/admin/tp-index_login'));
	}

	public function admin_login_hack(Request $request)
	{
		
		//return $request;
		$this->hack_error($request,'Hacker Attack Login');

		return $this->admin_login($request, false);
	}

	public function admin_login(Request $request, $nohack = true)
	{
		
		$goadmin = false;
		$message = 'การล็อคอินผิดพลาด กรุณาลองใหม่อีกครั้ง';
		
		
		
		if($nohack && $request->isMethod('post'))
		{
			$rules = [
				'form-user' => 'required',
				'form-pass' => 'required',
			];
			$messages = [
				'required' => 'จำเป็นต้องมีข้อมูล',
				/*'form-name.required' => 'กรุณาใส่ชื่อผู้ติดต่อ',*/
			];

			$validator = Validator::make($request->all(), $rules, $messages);

			if ($validator->fails()) {
				$errors = $validator->errors();
			}
			else
			{
				$user = $request->input('form-user');
				$pass = $request->input('form-pass');

				$admin_member = DB::table('tha_admin')->where([['username', $user],['pwd', $pass]])->get();
				if(count($admin_member) > 0)
				{
					$admin = $admin_member[0];

					$goadmin = true;
				}
			}
		}

		if($goadmin)
		{
			$request->session()->put('admin_id', $admin->admin_id);

			return Redirect::away(url('/admin/tp-index_login'));
		}
		else
		{
			$request->session()->put('status_message', $message);

			return Redirect::away(url('/admin/index?error'));
		}
	}

	public function admin_logout_hack(Request $request)
	{
		$this->hack_error($request,'Hacker Attack Logout');

		return $this->admin_logout($request, false);
	}

	public function admin_logout(Request $request, $nohack = true)
	{
		if($nohack)
		{
			$request->session()->forget('admin_id');
			$request->session()->forget('shop_id');
		}

		return Redirect::away(url('/admin/index'));
	}

	private function set_request(Request $request)
	{
		$this->today = date('Y-m-d');
		//echo $request->url().'-'.$request->root();
		$this->req['req'] = $request;

		$display = $request->all();

		array_walk_recursive($display, function(&$display) {
			$display = strip_tags($display);
		});

		$this->req['display'] = $display;
	}

	private function remove_special($value)
	{
		$spe = array( '\'', '"' , ';', '$', '^', '*', '!', '`', '%', '?' );
		$title = str_replace($spe, '', $value);

		$spe2 = array( '<', '>', ',', '.', '@', '&', '#', '(', ')', ' ', '\\', '/', '+', '=', '~' );
		$title = str_replace($spe2, '-', $title);

		return $title;
	}

	private function script_file($file,$folder)
	{
		if($folder == 'home')
		{
			$folder_set = 'script_home';
		}
		else if($folder == 'shop')
		{
			$folder_set = 'script_shop';
		}
		else if($folder == 'admin')
		{
			$folder_set = 'script_admin';
		}
		else
		{
			abort(404);
		}

		if($file == 'index2')
		{
			$file = 'index';
		}

		$inc_file = realpath(dirname(__FILE__)).'/'.$folder_set.'/'.$file.'.php';
		if(file_exists($inc_file))
		{
			$file_script = TRUE;

			include($inc_file);
		}
	}

	private function update_sys($key,$value)
	{
		$sql = [
			'sys_value' => $value,
		];
		DB::table('system_log')->where('sys_key', $key)->update($sql);
	}

	private function get_sys($key)
	{
		$sys_arr = DB::table('system_log')->where('sys_key', $key)->get();
		if(count($sys_arr) > 0)
		{
			$sys = $sys_arr[0];

			return $sys->sys_value;
		}
		else
		{
			return null;
		}
	}

	private function chk_bot($txt)
	{
		$txt = strtolower($txt);

		return str_contains($txt, ['bot', 'spider', 'crawler', 'http']);
	}

	private function stat_visit_all($req)
	{
		$key = 'visit_all';
		$add = 1;

		if(!$req->session()->has($key))
		{
			$visit_all = $this->get_sys($key);

			$visit_all += $add;

			$this->update_sys($key,$visit_all);

			$req->session()->put($key, $visit_all);
		}
	}

	private function stat_visit_day($req)
	{
		$now = date("Ymd");
		$add = 1;

		$key = 'visit_day_save';
		$key2 = 'visit_day';

		$visit_day_save = $this->get_sys($key);
		if($visit_day_save != $now)
		{
			$visit_day = 1;
			$this->update_sys($key2,$visit_day);
			$this->update_sys($key,$now);

			$req->session()->put($key, $now);
		}
		else if(!$req->session()->has($key))
		{
			$visit_day = $this->get_sys($key2);

			$visit_day += $add;

			$this->update_sys($key2,$visit_day);

			$req->session()->put($key, $visit_day_save);
		}
	}

	private function stat_visit_now($req,$shop_id = 0)
	{
		$key = 'visit_now';

		$timein = time();
		$timeout = $timein - 300; //5 Minute;
		$time = date("Y-m-d H:i:s");

		$create = true;

		if($req->session()->has($key))
		{
			$visit_day = explode('|',$req->session()->get($key));
			if(isset($visit_day[1]) && $timeout < $visit_day[1])
			{
				$create = false;
			}
		}

		if($create)
		{
			$sql = [
				'timestamp' => $time,
				'shop_id' => $shop_id,
			];
			$sid = DB::table('online_log')->insertGetId($sql);

			$visit_now = DB::table('online_log')->where('shop_id', $shop_id)->count();

			$this->update_sys($key,$visit_now);
		}
		else
		{
			$sid = $visit_day[0];
			$timeold = date("Y-m-d H:i:s",$visit_day[1]);

			$sql = [
				'timestamp' => $time,
			];
			DB::table('online_log')->where([['online_id', $sid],['timestamp',$timeold]])->update($sql);
		}

		$visit_day = $sid.'|'.$timein;

		$req->session()->put($key, $visit_day);
	}

	function set_banner($req,$page = '')
	{
		$tmp = '';

		for($rotate=0;$rotate <= 4;$rotate++)
		{
			$tmp .= $this->set_banner_ads($req,'desktop',$rotate);
			$tmp .= $this->set_banner_ads($req,'mobile',$rotate);

			/*if(strlen($page) > 0)
			{
				$tmp .= banner_ads($req,'desktop_'.$page,$rotate);
				$tmp .= banner_ads($req,'mobile_'.$page,$rotate);
			}*/
		}

		return $tmp;
	}

	function set_banner_ads($req,$ads,$rotate)
	{
		$tmp = '';

		if($rotate == 0)
		{
			$banner_arr = DB::table('banner')->where([['ads',$ads],['status','1'],['rotate',$rotate]])->get();
		}
		else
		{
			$banner_arr = DB::table('banner')->where([['ads',$ads],['status','1'],['rotate',$rotate]])->inRandomOrder()->limit(1)->get();
		}

		foreach ($banner_arr as $banner)
		{
			$id = $banner->banner_id;

			if(strlen($tmp) > 0)
			{
				$tmp .= ',';
			}

			$tmp .= $id;

			if(!$this->chk_bot($req->header('User-Agent')) && !$req->session()->has('banner_click_'.$id))
			{
				if(!$req->session()->has('banner_check_'.$id))
				{
					DB::table('banner_stat')->where('banner_id',$id)->increment('imp');
				}

				$t = time();
				$req->session()->put('banner_check_'.$id, $t);
			}
		}

		if(strlen($tmp) > 0)
		{
			$req->session()->put('banner_'.$ads.'_'.$rotate, $tmp);
		}
	}

	private function set_redirect($page = '')
	{
		$this->process = FALSE;
		$this->redirect = '/'.$page;
	}

	private function show_include_file($file,$folder = 'home')
	{
		if($folder == 'home')
		{
			$folder_set = 'thaprachan_html';
		}
		else if($folder == 'shop')
		{
			$folder_set = 'thaprachan_shop';
		}
		else if($folder == 'admin')
		{
			$folder_set = 'thaprachan_admin';
			//$folder_set = 'thaprachan_cms\\public\\templates\\sb-admin-2\\pages';
		}
		else
		{
			abort(404);
		}

		$open_file = false;
		$search_file = $_SERVER['DOCUMENT_ROOT'].'/'.$folder_set.'/'.$file.'.php';
		//echo $file.'-'.$search_file;
		if(@file_exists($search_file))
		{
			$open_file = true;
		}
		else
		{
			$shop_member = DB::table('shop_member')->where(function ($query) {$query->where('url', $this->req['any'])->orwhere('shop_name', $this->req['any']);})->where([['new_or_not', '0'],['start_stop', '0'],['shop_status','<','2']])->get();
			if(count($shop_member) > 0)
			{
				$shop = $shop_member[0];

				if(isset($this->req['any2']) && strlen($this->req['any2']) > 0)
				{
					if(isset($this->req['any3']) && strlen($this->req['any3']) > 0)
					{
						$this->req['any4'] = $this->req['any3'];
					}

					$this->req['any3'] = $this->req['any2'];
				}

				$file = 'shop-detail';

				$this->req['any'] = $file;
				$this->req['any2'] = $shop->shop_id;

				$search_file = $_SERVER['DOCUMENT_ROOT'].'/'.$folder_set.'/'.$file.'.php';

				$open_file = true;
			}
		}

		if($open_file)
		{
			//echo memory_get_usage().'<br/>';

			$this->script_file($file,$folder);

			if($this->process)
			{
				$file_core = TRUE;

				ob_start();

				include($search_file);

				$html = ob_get_clean();

				//echo 'A'.memory_get_usage().'<br/>';

				return $this->auto_replace($file,$html,$folder);
			}
			else
			{
				return Redirect::away(url($this->redirect));
			}
		}
		else
		{
			abort(404);
		}
		//echo "OK";
	}

	private function auto_replace($file,$html,$folder)
	{
		$dom = new Dom($this->req);

		$html = $dom->dom_replace($file,$html,$folder);

		$html = str_replace('index.php',url('/'),$html);
		$html = str_replace('.php','',$html);
		$html = str_replace('thaprachan_shop','thaprachan/merchant',$html);

		//echo 'B'.memory_get_usage().'<br/>';

		return $html;
	}

	public function clickBanner(Request $request, $pid)
	{
		$banner_arr = DB::table('banner')->where([['banner_id',$pid],['status','1']])->get();
		if(count($banner_arr) > 0)
		{
			$banner = $banner_arr[0];

			$url = $banner->url;

			$this->updateClickBanner($request, $pid);

			return Redirect::away($url);
		}

		return Redirect::away(url('/'));
	}

	private function updateClickBanner(Request $request, $pid)
	{
		if($request->session()->has('banner_click_'.$pid))
		{
			DB::table('banner_click')->where('click_id', $request->session()->get('banner_click_'.$pid))->increment('click');
		}
		else
		{
			if($request->session()->has('banner_check_'.$pid))
			{
				$t = date("Y-m-d H:i:s",$request->session()->get('banner_check_'.$pid) + 300);
				$request->session()->forget('banner_check_'.$pid);

				$timelog = date("Y-m-d H:i:s");
				if($timelog < $t)
				{
					DB::table('banner_stat')->where('banner_id',$pid)->increment('click');

					$sql = [
						'banner_id' => $pid,
						'ip' => $request->ip(),
						'agent' => $request->header('User-Agent'),
						'click' => '1',
						'timelog' => $timelog
					];
					$bid = DB::table('banner_click')->insertGetId($sql);

					$request->session()->put('banner_click_'.$pid, $bid);
				}
			}
		}
	}

	public function getImageRegister(Request $request, $pid, $filename)
	{
		$go_out = true;
		if($request->session()->has('admin_id'))
		{
			$shop_member = DB::table('tha_admin')->where('admin_id', $request->session()->get('admin_id'))->get();
			if(count($shop_member) > 0)
			{
				$go_out = false;
			}
		}

		if($go_out)
		{
			return Redirect::away(url('/admin/index'));
		}

		return $this->showImage($request,'register/'.$pid.'/'.$filename);
        $imagePath = storage_path('app/register/'.$pid.'/'.$filename);

		/*$file = Storage::get('register/'.$pid.'/'.$filename);

		$type_img = 'image/jpeg';

		return response($file, 200)->header('Content-Type', $type_img);

		//return new Response($file, 200);*/
	}


	
	

	public function getImageContact(Request $request, $pid, $filename)
	{
		$go_out = true;
		if($request->session()->has('admin_id'))
		{
			$shop_member = DB::table('tha_admin')->where('admin_id', $request->session()->get('admin_id'))->get();
			if(count($shop_member) > 0)
			{
				$go_out = false;
			}
		}

		if($go_out)
		{
			return Redirect::away(url('/admin/index'));
		}

		return $this->showImage($request,'contact/'.$pid.'/'.$filename);
	}

	public function getImageProblem(Request $request, $pid, $filename)
	{
		$go_out = true;
		if($request->session()->has('admin_id'))
		{
			$shop_member = DB::table('tha_admin')->where('admin_id', $request->session()->get('admin_id'))->get();
			if(count($shop_member) > 0)
			{
				$go_out = false;
			}
		}

		if($go_out)
		{
			return Redirect::away(url('/admin/index'));
		}

		return $this->showImage($request,'problem/'.$pid.'/'.$filename);
	}

	public function getImageAdminContact(Request $request, $pid, $filename)
	{
		$go_out = true;
		if($request->session()->has('shop_id') || $request->session()->has('admin_id'))
		{
			$contact_arr = DB::table('admin_contact_ans')->where('pic', $filename)->get();
			if(count($contact_arr) > 0)
			{
				if($request->session()->has('admin_id'))
				{
					$go_out = false;
				}
				else if($request->session()->get('shop_id') == $pid)
				{
					$contact_ans = $contact_arr[0];
					$contact = DB::table('admin_contact')->where([['contact_id', $contact_ans->contact_id],['shop_id', $pid]])->count();
					if($contact)
					{
						$go_out = false;
					}
				}
			}
		}

		if($go_out)
		{
			return Redirect::away(url('/'));
		}

		return $this->showImage($request,'admin_contact/'.$pid.'/'.$filename);
	}

	public function getImageShopContact(Request $request, $pid, $filename)
	{
		$go_out = true;
		if($request->session()->has('shop_id'))
		{
			$contact = DB::table('shop_contact')->where([['pic', $filename],['shop_id', $request->session()->get('shop_id')]])->count();
			if($contact && $request->session()->get('shop_id') == $pid)
			{
				$go_out = false;
			}
		}

		if($go_out)
		{
			return Redirect::away(url('/'));
		}

		return $this->showImage($request,'shop_contact/'.$pid.'/'.$filename);
	}

	public function getImageShop(Request $request, $pid, $filename)
	{
		return $this->showImage($request,'shop/'.$pid.'/'.$filename);
	}

	public function getImageProduct(Request $request, $pid, $filename)
	{
		return $this->showImage($request,'product/'.$pid.'/'.$filename);
	}

	public function getImageNews(Request $request, $filename)
	{
		return $this->showImage($request,'news/'.$filename);
	}

	public function getImageBanner(Request $request, $filename)
	{
		return $this->showImage($request,'banner/'.$filename);
	}

	private function showImage(Request $request,$filename)
	{
		try
		{
			if(Storage::exists($filename) && substr(Storage::mimeType($filename), 0, 5) == 'image')
			{
				/*$type_img = 'image/gif';
				$type_img = 'image/png';
				$type_img = 'image/jpeg';*/

				$type_img = Storage::mimeType($filename);
				if(substr($type_img, 0, 5) == 'image')
				{
					$file = Storage::get($filename);

					$img_new = Image::make($file);

					return response($file, 200)->header('Content-Type', $type_img);

					//return new Response($file, 200);
				}
			}
		}
		catch (\Intervention\Image\Exception\NotReadableException $e)
		{
			//echo 'Caught exception: ',	 $e->getMessage(), "\n";
			$this->img_error_core($request,'Core',$filename);
		}
		catch (Exception $e)
		{
			//echo 'Caught exception: ',	 $e->getMessage(), "\n";
			$this->img_error_core($request,'Core',$filename);
		}

		return abort(404);
	}

	private function img_error_core(Request $request,$title,$file = '',$del = true)
	{
		/*if($del)
		{
			Storage::delete($file);
		}*/

		$detail = array(
			'URL' => $request->fullUrl(),
			'IP' => $request->ip(),
			'User-Agent' => $request->header('User-Agent'),
		);

		$sql = [
			'title' => $title,
			'file' => $file,
			'detail' => print_r($detail,true),
			'datecreate' => date("Y-m-d H:i:s"),
		];
		$detail['Error Log ID'] = DB::table('error_log')->insertGetId($sql);

		Mail::send('email.alert', ['title' => $title,'file' => $file,'detail' => $detail], function ($m) {
			$m->from(env('MAIL_SENDER', 'noreply@thaprachan.com'), 'ThaprachanDotCom');

			$m->to(env('MAIL_ADMIN', 'developer@clicksee.net'), 'Admin')->subject('Alert');
		});
	}

	private function hack_error(Request $request,$title)
	{
		$file = '';

		$detail = array(
			'URL' => $request->fullUrl(),
			'IP' => $request->ip(),
			'User-Agent' => $request->header('User-Agent'),
		);

		$detail_add = array(
			'Input' => print_r($request->input(),true),
			'Query' => print_r($request->query(),true),
			'Cookie' => print_r($request->cookie(),true),
			'Session' => print_r($request->session()->all(),true),
			'Header' => print_r($request->header(),true),
			'Server' => print_r($request->server(),true),
		);

		$sql = [
			'title' => $title,
			'file' => $file,
			'detail' => print_r($detail+$detail_add,true),
			'datecreate' => date("Y-m-d H:i:s"),
		];
		$detail['Error Log ID'] = DB::table('error_log')->insertGetId($sql);

		Mail::send('email.alert', ['title' => $title,'file' => $file,'detail' => $detail], function ($m) {
			$m->from(env('MAIL_SENDER', 'noreply@thaprachan.com'), 'ThaprachanDotCom');

			$m->to(env('MAIL_ADMIN', 'developer@clicksee.net'), 'Admin')->subject('Alert');
		});
	}

	public function system_update(Request $request)
	{
		$txt = 'Unsuccess';
		if($request->ip() == '103.7.57.25')
		{
			$txt = 'Success';
		}

		return response($txt, 200)->header('Content-Type', 'text/plain');
	}
	

    
	

	/*private function show_input($text)
	{
		if(isset($this->req['display'][$text]))
		{
			return $this->req['display'][$text];
		}
		else
		{
			return false;
		}
	}

	private function form_text($name,$place = '',$class = false)
	{
		$arr = array();
		if($class != false)
		{
			$arr['class'] = $class;
		}
		if($place != '')
		{
			$arr['placeholder'] = $place;
		}
		return Form::text($name, $this->show_input($name),$arr);
	}*/
}
