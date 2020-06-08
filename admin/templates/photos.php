<?php
 
// Nếu đăng nhập
if ($user)
{
  
    echo '<h3>Hình ảnh</h3>';
    // Lấy tham số ac
    if (isset($_GET['ac']))
    {
        $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
    }
    else
    {
        $ac = '';
    }
 
 
    // Nếu có tham số ac
    if ($ac != '') 
    {
        // Trang upload hình ảnh
        if ($ac == 'add')
        {
            // Dãy nút của upload hình ảnh
            echo
            '
                <a href="' . $_DOMAIN . 'photos" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                </a> 
            ';
 
            // Content upload hình ảnh
            echo 
            '
                <p class="form-up-img">
                    <div class="alert alert-info">Mỗi lần upload tối đa 20 file ảnh. Mỗi file có dung lượng không vượt quá 5MB và có đuôi định dạng là .jpg, .png.gif., </div>
                    <form action="' . $_DOMAIN . 'photos.php"method="POST" id="formUpImg" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="form-group">
                            <label>Chọn hình ảnh</label>
                            <input type="file" class="form-control" accept="" name="img_up[]" multiple="true" id="img_up" onchange="preUpImg();">
                        </div>
                        <div class="form-group box-pre-img hidden">
                            <p><strong>Ảnh xem trước</strong></p>
                        </div>
                        <div class="form-group hidden box-progress-bar">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button class="btn btn-default" type="reset">Chọn lại</button>
                        </div>
                        <div class="alert alert-danger hidden"></div>
                    </form>
                </p>
            ';
        }     
    }
    // Ngược lại không có tham số ac
    // Trang danh sách hình ảnh
    else
    {
        // Dãy nút của danh sách hình ảnh
        echo
        '
            <a href="' . $_DOMAIN . 'photos/add" class="btn btn-default">
                <span class="glyphicon glyphicon-plus"></span> Thêm
            </a> 
            <a href="' . $_DOMAIN . 'photos" class="btn btn-default">
                <span class="glyphicon glyphicon-repeat"></span> Reload
            </a> 
            <a class="btn btn-danger" id="del_img_list">
                <span class="glyphicon glyphicon-trash"></span> Xoá
            </a> 
        ';
 
        // Content danh sách hình ảnh
    }
}
// Ngược lại chưa đăng nhập
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}
 
?>