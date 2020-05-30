<?php
 
// Kết nối database và thông tin chung
require_once 'core/init.php';
 
// Nếu đăng nhập
if ($user) 
{
    // Nếu tồn tại POST action
    if (isset($_POST['action']))
    {
        // Xử lý POST action
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));
 
        // Tải chuyên mục cha trong chức năng thêm chuyên mục
        if ($action == 'load_add_parent_cate')
        {
            // Xử lý giá trị
            $type_add_cate = trim(addslashes(htmlspecialchars($_POST['type_add_cate'])));
 
            // Nếu type đúng dạng số
            if (!preg_match('/\D/', $type_add_cate)) 
            {
                $type_add_parent_cate = $type_add_cate - 1; // Lấy type parent
                $sql_get_cate = "SELECT * FROM categories WHERE type = '$type_add_parent_cate'";
                if ($db->num_rows($sql_get_cate))
                {
                    // In danh sách các chuyên mục cha theo type parent
                    foreach ($db->fetch_assoc($sql_get_cate, 0) as $key => $data_cate)
                    {
                        echo '<option value="' . $data_cate['id_cate'] . '">' . $data_cate['label'] . '</option>';
                    }
                }
                else
                {
                    echo '<option value="0">Hiện chưa có chuyên mục cha nào</option>';
                }
            }
        }
        // Tạo chuyên mục
        else if ($action == 'add_cate')
        {
            // Xử lý các giá trị
            $label_add_cate = trim(addslashes(htmlspecialchars($_POST['label_add_cate'])));
            $url_add_cate = trim(addslashes(htmlspecialchars($_POST['url_add_cate'])));
            $type_add_cate = trim(addslashes(htmlspecialchars($_POST['type_add_cate'])));
            $parent_add_cate = trim(addslashes(htmlspecialchars($_POST['parent_add_cate'])));
            $sort_add_cate = trim(addslashes(htmlspecialchars($_POST['sort_add_cate'])));
 
 
            // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddCate .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddCate .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddCate .alert").attr("class", "alert alert-success");</script>';
 
            // Nếu các giá trị rỗng
            if ($label_add_cate == '' || $url_add_cate == '' || $type_add_cate == '' || $sort_add_cate == '')
            {
                echo $show_alert.'Vui lòng điền đầy đủ thông tin';
            }
            // Ngược lại
            else
            {
                // Nếu type chuyên mục không phải số
                if (preg_match('/\D/', $type_add_cate))
                {
                    echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau.';
                }
                // Nếu sort chuyên mục không phải số nguyên dương
                else if (preg_match('/\D/', $sort_add_cate) || $sort_add_cate < 1)
                {
                    echo $show_alert.'Sort chuyên mục phải là một số nguyên dương.';
                }
                // Nếu id parent chuyên mục không phải số
                else if (preg_match('/\D/', $parent_add_cate))
                {
                    echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau.1';
                }
                // Nếu đúng 
                else
                {
                    // Thực thi tạo chuyên mục
                    $sql_add_cate = "INSERT INTO categories VALUES (
                        '',
                        '$label_add_cate',
                        '$url_add_cate',
                        '$type_add_cate',
                        '$sort_add_cate',
                        '$parent_add_cate',
                        '$date_current'
                    )";
                    $db->query($sql_add_cate);
                    echo $show_alert.$success.'Tạo chuyên mục thành công.';
                    $db->close(); // Giải phóng
                    new Redirect($_DOMAIN.'categories'); // Trở về trang danh sách chuyên mục
                }
            }
        }
        // Tải chuyên mục cha trong chức năng chinh sửa chuyên mục
        // Chỉnh sửa chuyên mục
    }
    // Ngược lại không tồn tại POST action
    else
    {
        new Redirect($_DOMAIN);
    }
}
// Nếu không đăng nhập
else
{
    new Redirect($_DOMAIN);
}
 
?>