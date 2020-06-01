<!DOCTYPE html>
<html>
<head>
	 <meta charset="UTF-8"/>
	<title>Trang tin tuc</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
     <!-- Liên kết Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>bootstrap/css/bootstrap.min.css"/> 
 
    <!-- Liên kết thư viện jQuery -->
    <script src="<?php echo $_DOMAIN; ?>js/jquery.min.js"></script>    

</head>
<body>
	<body>
    <?php
 
    // Nếu chưa đăng nhập
    if (!$user)
    {
        echo
        '
            <div class="container">
                <div class="page-header">
                    <h1>News</h1>
                </div<!-- div.page-header -->
            </div>
        ';
    }
    // Nếu đăng nhập
    else
    {
        echo
        '
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="' . $_DOMAIN . '">News Admin</a>
                    </div>
                </div>
        ';
    }
 
    ?>

</body>
</html>