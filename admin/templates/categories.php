<?php

// Nếu đăng nhập
if ($user)
{
    // Nếu tài khoản là tác giả
    if ($data_user['position'] == 0)
    {
        echo '<div class="alert alert-danger">Bạn không có đủ quyền để vào trang này.</div>';
    }
    // Ngược lại tài khoản là admin
    else if ($data_user['position'] == 1)
    {
        echo '<h3>Danh mục tin tức</h3>';
        // Lấy tham số ac
        if (isset($_GET['ac']))
        {
            $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
        }
        else
        {
            $ac = '';
        }

        // Lấy tham số id
        if (isset($_GET['id']))
        {
            $id = trim(addslashes(htmlspecialchars($_GET['id'])));
        }
        else
        {
            $id = '';
        }

        // Nếu có tham số ac
        if ($ac != '') 
        {
            // Trang thêm danh mục
            if ($ac == 'add')
            {
                // Dãy nút của thêm danh mục
                echo 
                '
                    <a href="' . $_DOMAIN . 'categories" class="btn btn-default">
                        <span ></span> Trở về
                    </a> 
                ';

                // Content thêm danh mục
                echo 
                '   
                    <p class="form-add-cate">
                        <form method="POST" id="formAddCate" onsubmit="return false;">
                            <div class="form-group">
                                <label>Tên danh mục</label>
                                <input type="text" class="form-control title" id="label_add_cate">
                            </div>
                            <div class="form-group">
                                <label>URL danh mục</label>
                                <input type="text" class="form-control slug" placeholder="Nhấp vào để tự tạo" id="url_add_cate">
                            </div>
                            <div class="form-group">
                                <label>Loại danh mục</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="type_add_cate" value="1" checked class="type-add-cate-1"> Lớn
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="type_add_cate" value="2" class="type-add-cate-2"> Vừa
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="type_add_cate" value="3" class="type-add-cate-3"> Nhỏ
                                    </label>
                                </div>
                            </div>
                            <div class="form-group hidden parent-add-cate">
                                <label>Parent danh mục</label>
                                <select id="parent_add_cate" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sort danh mục</label>
                                <input type="text" class="form-control" id="sort_add_cate">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Tạo</button>
                            </div>
                            <div class="alert alert-danger hidden"></div>
                        </form>
                    </p>
                ';
            } 
            // Trang chỉnh sửa danh mục
            else if ($ac == 'edit')
            {
                $sql_check_id_cate = "SELECT id_cate FROM categories WHERE id_cate = '$id'";
                // Nếu tồn tại tham số id trong table
                if ($db->num_rows($sql_check_id_cate)) 
                {
                    // Dãy nút của chỉnh sửa danh mục
                    echo 
                    '
                        <a href="' . $_DOMAIN . 'categories" class="btn btn-default">
                            <span ></span> Trở về
                        </a> 
                        <a class="btn btn-danger" id="del_cate" data-id="' . $id . '">
                            <span ></span> Xoá
                        </a> 
                    ';  

                    // Content chỉnh sửa danh mục
                    $sql_get_data_cate = "SELECT * FROM categories WHERE id_cate = '$id'";
                    if ($db->num_rows($sql_get_data_cate))
                    {
                        $data_cate = $db->fetch_assoc($sql_get_data_cate, 1);

                        // Chỉnh sửa loại danh mục
                        $checked_type_1 = '';
                        $checked_type_2 = '';
                        $checked_type_3 = '';
                        $parent_edit_cate = '';

                        if ($data_cate['type'] == 1)
                        {
                            $checked_type_1 = 'checked';
                                    $parent_edit_cate .= 
                            '
                                <div class="form-group parent-edit-cate hidden">
                                    <label>Parent danh mục</label>
                                    <select id="parent_edit_cate" class="form-control">
                                    </select>
                                </div>
                            ';
                        }
                        else if ($data_cate['type'] == 2)
                        {
                            $checked_type_2 = 'checked';
                            $parent_edit_cate .= 
                            '
                                <div class="form-group parent-edit-cate">
                                    <label>Parent danh mục</label>
                                    <select id="parent_edit_cate" class="form-control">
                            ';

                            $sql_get_cate_parent = "SELECT * FROM categories WHERE type = '1'";
                            if ($db->num_rows($sql_get_cate_parent))
                            {
                                // In danh sách các danh mục cha loại 1
                                foreach ($db->fetch_assoc($sql_get_cate_parent, 0) as $key => $data_cate_parent)
                                {
                                    if ($data_cate['parent_id'] == $data_cate_parent['id_cate'])
                                    {
                                        $parent_edit_cate .= '<option value="' . $data_cate_parent['id_cate'] . '" selected>' . $data_cate_parent['label'] . '</option>';
                                    }
                                    else
                                    {
                                        $parent_edit_cate .= '<option value="' . $data_cate_parent['id_cate'] . '">' . $data_cate_parent['label'] . '</option>';
                                    }
                                }
                            }
                            else
                            {
                                echo '<option value="0">Hiện chưa có danh mục cha nào</option>';
                            }

                            $parent_edit_cate .= 
                            '
                                    </select>
                                </div>
                            ';
                        }
                        else if ($data_cate['type'] == 3)
                        {
                            $checked_type_3 = 'checked';
                            $parent_edit_cate .= 
                            '
                                <div class="form-group parent-edit-cate">
                                    <label>Parent danh mục</label>
                                    <select id="parent_edit_cate" class="form-control">
                            ';
                                                
                            $sql_get_cate_parent = "SELECT * FROM categories WHERE type = '2'";
                            if ($db->num_rows($sql_get_cate_parent))
                            {
                                // In danh sách các danh mục cha loại 2
                                foreach ($db->fetch_assoc($sql_get_cate_parent, 0) as $key => $data_cate_parent)
                                {
                                    if ($data_cate['parent_id'] == $data_cate_parent['id_cate'])
                                    {
                                        $parent_edit_cate .= '<option value="' . $data_cate_parent['id_cate'] . '" selected>' . $data_cate_parent['label'] . '</option>';
                                    }
                                    else
                                    {
                                        $parent_edit_cate .= '<option value="' . $data_cate_parent['id_cate'] . '">' . $data_cate_parent['label'] . '</option>';
                                    }
                                }
                            }
                            else
                            {
                                echo '<option value="0">Hiện chưa có danh mục cha nào</option>';
                            }

                            $parent_edit_cate .= 
                            '
                                    </select>
                                </div>
                            ';
                        }

                        echo
                        '   <p class="form-edit-cate">
                                <form method="POST" id="formEditCate" data-id="' . $data_cate['id_cate'] . '" onsubmit="return false;" class="form-cate">
                                    <div class="form-group">
                                        <label>Tên danh mục</label>
                                        <input type="text" class="form-control title" value="' . $data_cate['label'] . '" id="label_edit_cate">
                                    </div>
                                    <div class="form-group">
                                        <label>URL danh mục</label>
                                        <input type="text" class="form-control slug" value="' . $data_cate['url'] . '" id="url_edit_cate">
                                    </div>
                                    <div class="form-group">
                                        <label>Loại danh mục</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type_edit_cate" value="1" class="type-edit-cate-1" ' . $checked_type_1 . '> Lớn
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type_edit_cate" value="2" class="type-edit-cate-2" ' . $checked_type_2 . '> Vừa
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type_edit_cate" value="3" class="type-edit-cate-3" ' . $checked_type_3 . '> Nhỏ
                                            </label>
                                        </div>
                                    </div>
                                                    ' . $parent_edit_cate . '
                                    <div class="form-group">
                                        <label>Sort danh mục</label>
                                        <input type="text" class="form-control" value="' . $data_cate['sort'] . '" id="sort_edit_cate">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    </div>
                                    <div class="alert alert-danger hidden"></div>
                                </form>
                            </p>
                        ';
                    }
                }
                else
                {
                    // Hiển thị thông báo lỗi
                    echo 
                    '
                        <div class="alert alert-danger">ID danh mục đã bị xoá hoặc không tồn tại.</div>
                    ';
                }
            }
        }
        // Ngược lại không có tham số ac
        // Trang danh sách danh mục
        else
        {
            // Dãy nút của danh sách danh mục
            echo 
            '
                <a href="' . $_DOMAIN . 'categories/add" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus"></span> Thêm
                </a> 
                <a href="' . $_DOMAIN . 'categories" class="btn btn-default">
                    <span ></span> Reload
                </a> 
                <a class="btn btn-danger" id="del_cate_list">
                    <span></span> Xoá
                </a> 
            ';

            // Content danh sách danh mục
            $sql_get_list_cate = "SELECT * FROM categories ORDER BY id_cate DESC";
            // Nếu có danh mục
            if ($db->num_rows($sql_get_list_cate))
            {
                echo 
                '
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped list" id="list_cate">
                            <tr>
                                <td><input type="checkbox"></td>
                                <td><strong>ID</strong></td>
                                <td><strong>Tên danh mục</strong></td>
                                <td><strong>Loại</strong></td>
                                <td><strong>Danh mục cha</strong></td>
                                <td><strong>Sort</strong></td>
                                <td><strong>Chỉnh sửa</strong></td>
                            </tr>
                ';

                // In danh sách danh mục
                foreach ($db->fetch_assoc($sql_get_list_cate, 0) as $key => $data_cate)
                {
                    // Hiển thị danh mục cha
                    $sql_get_cate_parent = "SELECT * FROM categories WHERE id_cate = '$data_cate[parent_id]'";
                    if ($db->num_rows($sql_get_cate_parent))
                    {
                        $data_cate_parent = $db->fetch_assoc($sql_get_cate_parent, 1);

                        if ($data_cate_parent['type'] == '1' && $data_cate['type'] == '3')
                        {
                            $label_cate_parent = '<p class="text-danger">Lỗi</p>';
                        }
                        else if ($data_cate_parent['type'] == '3' && $data_cate['type'] == '2') 
                        {
                            $label_cate_parent = '<p class="text-danger">Lỗi</p>';
                        }
                        else if ($data_cate_parent['type'] == '3' && $data_cate['type'] == '1') 
                        {
                            $label_cate_parent = '<p class="text-danger">Lỗi</p>';
                        }
                        else if ($data_cate_parent['type'] == $data_cate['type']) 
                        {
                            $label_cate_parent = '<p class="text-danger">Lỗi</p>';
                        }
                        else
                        {
                            $label_cate_parent = $data_cate_parent['label'];
                        }
                    }
                    else
                    {
                          $label_cate_parent = '';
                    }

                    // Hiển thị loại danh mục
                    if ($data_cate['type'] == 1)
                    {
                        $data_cate['type'] = 'Lớn';
                    }
                    else if ($data_cate['type'] == 2)
                    {
                        $data_cate['type'] = 'Vừa';
                    }
                    else if ($data_cate['type'] == 3)
                    {
                        $data_cate['type'] = 'Nhỏ';
                    }

                    echo 
                    '
                        <tr>
                            <td><input type="checkbox" name="id_cate[]" value="' . $data_cate['id_cate'] .'"></td>
                            <td>' . $data_cate['id_cate'] .'</td>
                            <td><a href="' . $_DOMAIN . 'categories/edit/' . $data_cate['id_cate'] .'">' . $data_cate['label'] . '</a></td>
                            <td>' . $data_cate['type'] . '</td>
                            <td>' . $label_cate_parent . '</td>
                            <td>' . $data_cate['sort'] . '</td>
                            <td>
                                <a href="' . $_DOMAIN . 'categories/edit/' . $data_cate['id_cate'] .'" class="btn btn-primary btn-sm">
                                    <span >Sửa</span>
                                </a>
                                <a class="btn btn-danger btn-sm del-cate-list" data-id="' . $data_cate['id_cate'] . '">
                                    <span>Xoá</span>
                                </a>
                            </td>
                        </tr>
                    ';
                }

                echo 
                '
                        </table>
                    </div>
                ';
            }
            // Nếu không có danh mục
            else
            {
                echo '<br><br><div class="alert alert-info">Bạn chưa có danh mục nào.</div>';
            }
        }
    }
}
// Ngược lại chưa đăng nhập
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}

?>
<?php
 
// Nhận giá trị slug của chuyên mục
$sc = trim(htmlspecialchars(addslashes($_GET['sc'])));
 
// Lấy id của chuyên mụcs
$sql_get_id_cate = "SELECT id_cate, url FROM categories WHERE url = '$sc'";
 
// Chuyên mục tồnta5i
if ($db->num_rows($sql_get_id_cate)) {
    $id_cate = $db->fetch_assoc($sql_get_id_cate, 1)['id_cate'];
 
?>
<div class="container">
    <div class="row">
    <?php
 
    // Lấy số hàng trong table
    $sqlGetCountPost = "SELECT id_post FROM posts WHERE cate_1_id = '$id_cate' OR cate_2_id = '$id_cate' OR cate_3_id = '$id_cate' AND status = '1'";
    $countPost = $db->num_rows($sqlGetCountPost);
 
    // Lấy tham số trang
    if (isset($_GET['p'])) {
      $page = trim(htmlspecialchars(addslashes($_GET['p'])));
 
      if (preg_match('/\d/', $page)) {
        $page = $page;
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }
 
    $limit = 20; // Giới hạn số bài viết hiển thị trong 1 trang
    $totalPage = ceil($countPost / $limit); // Tổng số trang sau khi tính toán
         
    // Validate tham số page    
    if ($page > $totalPage) {
      $page = $totalPage;
    } else if ($page < 1) {
      $page = 1;
    }
       
    $start = ($page - 1) * $limit;
 
    $sql_get_latest_news = "SELECT * FROM posts WHERE status = '1' AND cate_1_id = '$id_cate' OR cate_2_id = '$id_cate' OR cate_3_id = '$id_cate' ORDER BY id_post DESC LIMIT $start, $limit";
    if ($db->num_rows($sql_get_latest_news)) {
        foreach ($db->fetch_assoc($sql_get_latest_news, 0) as $data_post) {
            echo '
                <div class="col-md-3">
                    <div class="thumbnail">
                        <a href="' . $_DOMAIN . $data_post['slug'] . '-' . $data_post['id_post'] . '.html">
                            <img src="' . $data_post['url_thumb'] . '">
                        </a>
                        <div class="caption">
                            <h3><a href="' . $_DOMAIN . $data_post['slug'] . '-' . $data_post['id_post'] . '.html">' . $data_post['title'] . '</a></h3>
                            <p>' . $data_post['descr'] . '</p>
                        </div>
                    </div>
                </div>
            ';
        }
 
        echo '</div>';
 
        echo '
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group">
        ';
 
        # Pagination button
        if ($page > 1 && $totalPage > 1) {
            echo '
                <a href="' . $_DOMAIN . ($page - 1 ) . '" class="btn btn-default">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
            ';
        }
        
        for ($i = 1; $i <= $totalPage; $i++) {
            if ($i == $page){
                echo '<a class="btn btn-primary">' . $i . '</a>';
            } else {
                echo '
                    <a href="' . $_DOMAIN . $i . '" class="btn btn-default">
                        ' . $i . '
                    </a>
                ';
            }
        }
        
        if ($page < $totalPage && $totalPage > 1) {
            echo '
                <a href="' . $_DOMAIN . ($page + 1 ) . '" class="btn btn-default">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            ';
        }
 
        echo '
                </div>
            </div>
        ';
    } else {
        echo '<div class="well well-lg">Chưa có bài viết nào cho chuyên mục này.</div>';
    }
 
    ?>
</div>
<?php
 
// Chuyên mục không tồn tại
} else {
    require 'templates/404.php';
}
 
?>