$_DOMAIN = 'http://localhost:8080/WebTinTuc/admin/';
 
// Đăng nhập
$('#formSignin button').on('click', function() {
    $this = $('#formSignin button');
    $this.html('Đang tải ...');
 
    // Gán các giá trị trong các biến
    $user_signin = $('#formSignin #user_signin').val();
    $pass_signin = $('#formSignin #pass_signin').val();
 
    // Nếu các giá trị rỗng
    if ($user_signin == '' || $pass_signin == '')
    {
        $('#formSignin .alert').removeClass('hidden');
        $('#formSignin .alert').html('Vui lòng điền đầy đủ thông tin.');
        $this.html('Đăng nhập');
    }
    // Ngược lại
    else
    {
        $.ajax({
            url : $_DOMAIN + 'signin.php',
            type : 'POST',
            data : {
                user_signin : $user_signin,
                pass_signin : $pass_signin
            }, success : function(data) {
                $('#formSignin .alert').removeClass('hidden');
                $('#formSignin .alert').html(data);
                $this.html('Đăng nhập');
            }, error : function() {
                $('#formSignin .alert').removeClass('hidden');
                $('#formSignin .alert').html('Không thể đăng nhập vào lúc này, hãy thử lại sau.');
                $this.html('Đăng nhập');
            }
        });
    }
}); 
// Tự động tạo slug
function ChangeToSlug()
{
    var title, slug;
    title = $('.title').val();
    slug = title.toLowerCase();
 
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    $('.slug').val(slug);
}

$('.slug').on('click', function() {
    ChangeToSlug();
});

// Tải danh mục cha ở chức năng thêm danh mục
$('#formAddCate input[type="radio"]').on('click', function() {
    if ($('#formAddCate .type-add-cate-1:checked').prop("checked") == true) 
    {
        $('.parent-add-cate').addClass('hidden');
        $('.parent-add-cate select').html('');
    }
    else if ($('#formAddCate .type-add-cate-2:checked').prop("checked") == true) 
    {
        $type_add_cate = $('#formAddCate .type-add-cate-2').val();

        $.ajax({
            type : 'POST',
            url : $_DOMAIN + 'categories.php',
            data : {
                action : 'load_add_parent_cate',
                type_add_cate : $type_add_cate
            }, success : function(data) {
                $('.parent-add-cate').removeClass('hidden');
                $('.parent-add-cate select').html(data);
            }, error : function() {
                $('.parent-add-cate').removeClass('hidden');
                $('.parent-add-cate').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    } 
    else if ($('#formAddCate .type-add-cate-3:checked').prop("checked") == true) 
    {
        $type_add_cate = $('#formAddCate .type-add-cate-3').val();
        $.ajax({
            type : 'POST',
            url : $_DOMAIN + 'categories.php',
            data : {
                action : 'load_add_parent_cate',
                type_add_cate : $type_add_cate
            }, success : function(data) {
                $('.parent-add-cate').removeClass('hidden');
                $('.parent-add-cate select').html(data);
            }, error : function() {
                $('.parent-add-cate').removeClass('hidden');
                $('.parent-add-cate').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    }
});

// Thêm danh mục
$('#formAddCate button').on('click', function() {
    $this = $('#formAddCate button');
    $this.html('Đang tải ...');

    // Gán các giá trị trong các biến
    $label_add_cate = $('#formAddCate #label_add_cate').val();
    $url_add_cate = $('#formAddCate #url_add_cate').val();
    $type_add_cate = $('#formAddCate input[name="type_add_cate"]:radio:checked').val();
    $parent_add_cate = $('#formAddCate #parent_add_cate').val();
    $sort_add_cate = $('#formAddCate #sort_add_cate').val();

    // Nếu các giá trị rỗng
    if ($label_add_cate == '' || $url_add_cate == '' || $type_add_cate == '' || $sort_add_cate == '')
    {
        $('#formAddCate .alert').removeClass('hidden');
        $('#formAddCate .alert').html('Vui lòng điền đầy đủ thông tin.');
        $this.html('Tạo');
    }
    // Ngược lại
    else
    {
        $.ajax({
            url : $_DOMAIN + 'categories.php',
            type : 'POST',
            data : {
                label_add_cate : $label_add_cate,
                url_add_cate : $url_add_cate,
                type_add_cate : $type_add_cate,
                parent_add_cate : $parent_add_cate,
                sort_add_cate : $sort_add_cate,
                action : 'add_cate'
            }, success : function(data) {
                $('#formAddCate .alert').removeClass('hidden');
                $('#formAddCate .alert').html(data);
                $this.html('Tạo');
            }, error : function() {
                $('#formAddCate .alert').removeClass('hidden');
                $('#formAddCate .alert').html('Không thể tạo danh mục vào lúc này, hãy thử lại sau.');
                $this.html('Tạo');
            }
        });
    }
});

// Tải danh mục cha ở chức năng chỉnh sửa danh mục
$('#formEditCate input[type="radio"]').on('click', function() {
    $id_edit_cate = $('#formEditCate').attr('data-id');
    if ($('#formEditCate .type-edit-cate-1:checked').prop("checked") == true) 
    {
        $('.parent-edit-cate').addClass('hidden');
        $('.parent-edit-cate select').html('');
    }
    else if ($('#formEditCate .type-edit-cate-2:checked').prop("checked") == true) 
    {
        $type_edit_cate = $('#formEditCate .type-edit-cate-2').val();

        $.ajax({
            type : 'POST',
            url : $_DOMAIN + 'categories.php',
            data : {
                action : 'load_edit_parent_cate',
                type_edit_cate : $type_edit_cate,
                id_edit_cate : $id_edit_cate
            }, success : function(data) {
                $('.parent-edit-cate').removeClass('hidden');
                $('.parent-edit-cate select').html(data);
            }, error : function() {
                $('.parent-edit-cate').removeClass('hidden');
                $('.parent-edit-cate').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    } 
    else if ($('#formEditCate .type-edit-cate-3:checked').prop("checked") == true) 
    {
        $type_edit_cate = $('#formEditCate .type-edit-cate-3').val();
        $.ajax({
            type : 'POST',
            url : $_DOMAIN + 'categories.php',
            data : {
                action : 'load_edit_parent_cate',
                type_edit_cate : $type_edit_cate,
                id_edit_cate : $id_edit_cate
            }, success : function(data) {
                $('.parent-edit-cate').removeClass('hidden');
                $('.parent-edit-cate select').html(data);
            }, error : function() {
                $('.parent-edit-cate').removeClass('hidden');
                $('.parent-edit-cate').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    }
});

// Chỉnh sửa danh mục
$('#formEditCate button').on('click', function() {
    $this = $('#formEditCate button');
    $this.html('Đang tải ...');

    // Gán các giá trị trong các biến
    $label_edit_cate = $('#formEditCate #label_edit_cate').val();
    $url_edit_cate = $('#formEditCate #url_edit_cate').val();
    $type_edit_cate = $('#formEditCate input[name="type_edit_cate"]:radio:checked').val();
    $parent_edit_cate = $('#formEditCate #parent_edit_cate').val();
    $sort_edit_cate = $('#formEditCate #sort_edit_cate').val();
    $id_edit_cate = $('#formEditCate').attr('data-id');

    // Nếu các giá trị rỗng
    if ($label_edit_cate == '' || $url_edit_cate == '' || $type_edit_cate == '' || $sort_edit_cate == '')
    {
        $('#formEditCate .alert').removeClass('hidden');
        $('#formEditCate .alert').html('Vui lòng điền đầy đủ thông tin.');
        $this.html('Lưu thay đổi');
    }
    // Ngược lại
    else
    {
        $.ajax({
            url : $_DOMAIN + 'categories.php',
            type : 'POST',
            data : {
                label_edit_cate : $label_edit_cate,
                url_edit_cate : $url_edit_cate,
                type_edit_cate : $type_edit_cate,
                parent_edit_cate : $parent_edit_cate,
                sort_edit_cate : $sort_edit_cate,
                id_edit_cate : $id_edit_cate,
                action : 'edit_cate'
            }, success : function(data) {
                $('#formEditCate .alert').removeClass('hidden');
                $('#formEditCate .alert').html(data);
                $this.html('Lưu thay đổi');
            }, error : function() {
                $('#formEditCate .alert').removeClass('hidden');
                $('#formEditCate .alert').html('Không thể chỉnh sửa danh mục vào lúc này, hãy thử lại sau.');
                $this.html('Lưu thay đổi');
            }
        });
    }
});

// Checkbox all
$('.list input[type="checkbox"]:eq(0)').change(function() {
    $('.list input[type="checkbox"]').prop('checked', $(this).prop("checked"));
});

// Xoá nhiều danh mục cùng lúc
$('#del_cate_list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá các danh mục đã chọn không?');
    if ($confirm == true)
    {
        $id_cate = [];

        $('#list_cate input[type="checkbox"]:checkbox:checked').each(function(i) {
            $id_cate[i] = $(this).val();
        });

        if ($id_cate.length === 0)
        {
            alert('Vui lòng chọn ít nhất một danh mục.');
        }
        else
        {
            $.ajax({
                url : $_DOMAIN + 'categories.php',
                type : 'POST',
                data : {
                    id_cate : $id_cate,
                    action : 'delete_cate_list'
                },
                success : function(data) {
                    location.reload();
                }, error : function() {
                    alert('Đã có lỗi xảy ra, hãy thử lại.');
                }
            });
        }
    }
    else
    {
        return false;
    }
});

// Xoá danh mục chỉ định trong bảng danh sách
$('.del-cate-list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá danh mục này không?');
    if ($confirm == true)
    {
        $id_cate = $(this).attr('data-id');

        $.ajax({
            url : $_DOMAIN + 'categories.php',
            type : 'POST',
            data : {
                id_cate : $id_cate,
                action : 'delete_cate'
            },
            success : function() {
                location.reload();
            }
        });
    }
    else
    {
        return false;
    }
});

// Xoá danh mục chỉ định trong trang chỉnh sửa
$('#del_cate').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá danh mục này không?');
    if ($confirm == true)
    {
        $id_cate = $(this).attr('data-id');

        $.ajax({
            url : $_DOMAIN + 'categories.php',
            type : 'POST',
            data : {
                id_cate : $id_cate,
                action : 'delete_cate'
            },
            success : function() {
                location.href = $_DOMAIN + 'categories/';
            }
        });
    }
    else
    {
        return false;
    }
});

// Xem ảnh trước
function preUpImg() {
    img_up = $('#img_up').val();
    count_img_up = $('#img_up').get(0).files.length;
    $('#formUpImg .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
    $('#formUpImg .box-pre-img').removeClass('hidden');

    // Nếu đã chọn ảnh
    if (img_up != '')
    {
        $('#formUpImg .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
        $('#formUpImg .box-pre-img').removeClass('hidden');
        for (i = 0; i <= count_img_up - 1; i++)
        {
               // URL.createjectURL():Hàm API của brower, dùng để tạo các URL file.
            $('#formUpImg .box-pre-img').append('<img src="' + URL.createObjectURL(event.target.files[i]) + '" style="border: 1px solid #ddd; width: 50px; height: 50px; margin-right: 5px; margin-bottom: 5px;"/>');
        }
    } 
    // Ngược lại chưa chọn ảnh
    else
    {
        $('#formUpImg .box-pre-img').html('');
        $('#formUpImg .box-pre-img').addClass('hidden');
    }
}

// Nút reset form  hình ảnh
$('#formUpImg button[type=reset]').on('click', function() {
    $('#formUpImg .box-pre-img').html('');
    $('#formUpImg .box-pre-img').addClass('hidden');
});

// Upload hình ảnh
$('#formUpImg').submit(function(e) {
    img_up = $('#img_up').val();
    count_img_up = $('#img_up').get(0).files.length;
    error_size_img = 0;
    error_type_img = 0;
    $('#formUpImg button[type=submit]').html('Đang tải hình ảnh ...');

    // Nếu có chọn ảnh
    if (img_up) {
        e.preventDefault();
        
        // Kiểm tra dung lượng ảnh
        for (i = 0; i <= count_img_up - 1; i++)
        {
            size_img_up = $('#img_up')[0].files[i].size;
            if (size_img_up > 5242880) { // 5242880 byte = 5MB 
                error_size_img += 1; // Lỗi
            } else {
                error_size_img += 0; // Không lỗi
            }
        }

        // Kiểm tra định dạng ảnh
        for (i = 0; i <= count_img_up - 1; i++)
        {
            type_img_up = $('#img_up')[0].files[i].type;
            if (type_img_up == 'image/jpeg' || type_img_up == 'image/png' || type_img_up == 'image/gif') {
                error_type_img += 0;
            } else {
                error_type_img += 1;
            }
        }

        // Nếu lỗi về size ảnh
        if (error_size_img >= 1) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Một trong các tệp đã chọn có dung lượng lớn hơn mức cho phép.');
        // Nếu số lượng ảnh vượt quá 20 file
        } else if (count_img_up > 20) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Số file upload cho mỗi lần vượt quá mức cho phép.');
        } else if (error_type_img >= 1) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Một trong những file ảnh không đúng định dạng cho phép.');
        } else {
            $(this).ajaxSubmit({ 
                beforeSubmit: function() {
                    target:   '#formUpImg .alert', 
                    $("#formUpImg .box-progress-bar").removeClass('hidden');
                    $("#formUpImg .progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){ 
                    $("#formUpImg .progress-bar").animate({width: percentComplete + '%'});
                    $("#formUpImg .progress-bar").html(percentComplete + '%');
                },
                success: function (data) {     
                    $('#formUpImg button[type=submit]').html('Upload');
                    $('#formUpImg .alert').attr('class', 'alert alert-success'); 
                    $('#formUpImg .alert').html(data);
                },
                error: function() {
                    $('#formUpImg button[type=submit]').html('Upload');
                    $('#formUpImg .alert').removeClass('hidden');  
                    $('#formUpImg .alert').html('Không thể upload hình ảnh vào lúc này, hãy thử lại sau.');
                },
                resetForm: true 
            }); 
            return false;
        }
    // Ngược lại không chọn ảnh
    } else {
        $('#formUpImg button[type=submit]').html('Upload');
        $('#formUpImg .alert').removeClass('hidden');
        $('#formUpImg .alert').html('Vui lòng chọn tệp hình ảnh.');
    }
});