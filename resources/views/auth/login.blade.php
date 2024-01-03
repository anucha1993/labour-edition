<!doctype html>
<html lang="en">
  <head>
  	<title>Foreign worker data collection program</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="{{ URL::asset('login-form-20/css/style.css')}}">

	</head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap');

        /* เปลี่ยน font-family ทั้งหมดเป็น 'Kanit', sans-serif */
        body {
            font-family: 'Kanit', sans-serif;
            /* ส่วนอื่นๆ ของ CSS ที่เคยใส่มาก่อนได้คงไว้เดิม */
            /* ... */
        }
        h1,h2,h3,h4,h5,h6
        {
            font-family: 'Kanit', sans-serif;
        }
        /* ... */
    </style>
    
	<body class="img js-fullheight" style="background-image: url(login-form-20/images/bg.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">
                        Foreign worker data collection program </h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">ยินดีต้อนรับสู่ระบบ</h3>
		      	<form action="{{ route('login') }}" class="signin-form" method="post">
                    @csrf
                    @method('post')
		      		<div class="form-group">
		      			<input type="text" name="username" class="form-control" placeholder="Username" required>
		      		</div>
	            <div class="form-group">
	              <input id="password-field" name="password" type="password" class="form-control" placeholder="Password" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">ลงชื่อเข้าใช้</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">จดจำรหัสผ่าน
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="https://docs.google.com/forms/d/e/1FAIpQLSewJToevw56poUKKqOF-qkXj4jt1h8o7zT6Uy7AMTUAl8SUnw/viewform" style="color: #fff">ลืมรหัสผ่าน</a>
								</div>
	            </div>
	          </form>
	          <p class="w-100 text-center">&mdash; แจ้งเหตุระบบ &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="https://docs.google.com/forms/d/e/1FAIpQLSewJToevw56poUKKqOF-qkXj4jt1h8o7zT6Uy7AMTUAl8SUnw/viewform" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span>คำขอใช้งานระบบ</a>
	          	<a href="https://docs.google.com/forms/d/e/1FAIpQLSewJToevw56poUKKqOF-qkXj4jt1h8o7zT6Uy7AMTUAl8SUnw/viewform" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span>แจ้งปัญหา</a>
	          </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

 <script src="{{ URL::asset('login-form-20/js/jquery.min.js')}}"></script>
 <script src="{{ URL::asset('login-form-20/js/popper.js')}}"></script>
 <script src="{{ URL::asset('login-form-20/js/bootstrap.min.js')}}"></script>
 <script src="{{ URL::asset('login-form-20/js/main.js')}}"></script>



	</body>
</html>

