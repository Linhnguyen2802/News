<div class="col-md-9 content">
    <?php
 
    // Phân trang content
    // Lấy tham số tab
    if (isset($_GET['tab']))
    {
        $tab = trim(addslashes(htmlspecialchars($_GET['tab'])));
    }
    else
    {
        $tab = '';
    }
 
    // Nếu có tham số tab
    if ($tab != '')
    {
        // Hiển thị template chức năng theo tham số tab
        if ($tab == 'profile')
        {
            // Hiển thị template hồ sơ cá nhân
            require_once 'templates/profile.php';
        }
        else if ($tab == 'posts')
        {
            // Hiển thị template bài viết
            require_once 'templates/posts.php';
        }
        else if ($tab == 'photos')
        {
            // Hiển thị template hình ảnh
            require_once 'templates/photos.php';
        }
        else if ($tab == 'categories')
        {
            // Hiển thị template danh mục
            require_once 'templates/categories.php';
        }
        else if ($tab == 'setting')
        {
            // Hiển thị template cài đặt chung
            require_once 'templates/setting.php';
        }

        else if ($tab == 'accounts')
        {
        // Hiển thị template tài khoản
        require_once 'templates/accounts.php';
        }
    }
    // Ngược lại không có tham số tab
    else
    {
        // Hiển thị template bảng điều khiển
        require_once 'templates/dashboard.php';
    }
 
    ?>
</div><!-- div.content -->
<?php
 
// Trang nội dung bài viết
if (isset($_GET['sp']) && isset($_GET['id'])) {
    require 'templates/posts.php';
// Trang chuyên mục
} else if (isset($_GET['sc'])) {
    require 'templates/categories.php';
// Trang tìm kiếm
} else if (isset($_GET['s'])) {
    require 'templates/search.php';
// Trang chủ
} else {
 // code
    require 'templates/latest-news.php';
}
 
?>