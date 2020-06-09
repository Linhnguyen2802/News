<!DOCTYPE html>
<html>
<head>
	<title>Login Admin</title>
</head>
<body>
	<div class="container">
  		<div class="row">
      		  <div class="col-md-6">
           		 <p>Vui lòng đăng nhập để tiếp tục.</p><br>
           		 <form method="POST" id="formSignin" onsubmit="return false;">
              	  <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span >Tài khoản</span></span>
                        <input type="text" class="form-control" placeholder="Tên đăng nhập" id="user_signin">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span >Mật Khẩu</span></span>
                        <input type="password" class="form-control" placeholder="Mật khẩu" id="pass_signin">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </div>
                <div class="alert alert-danger hidden"></div>
            </form>
        </div>
    </div>
	</div>

</body>
</html>