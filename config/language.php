<?php 
    class Language
    {
        private $type ;

        public function __construct()
        {
            $this->type = 'en';
        }
  
        public function setType($type) {
            $this->type = $type;
        }

        public function getData() {
            if( $this->type === 'vi') {
                return array('home'=>'Trang Chủ', 'login'=>'Đăng Nhập', 'register'=>'Đăng Ký',
                 'join'=>'Tham Gia', 'username'=>'Tên Đăng Nhập', 'start'=>'Bắt đầu', 
                 'create-new-account'=>'Tạo Tài Khoản Mới', 'already-member'=>'Đã Có Tài Khoản', 
                 'email'=>'Email', 'password'=>'Mật Khẩu','confirm-password'=>'Nhập Lại Mật Khẩu', 
                 'create'=>"Tạo", 'no-account'=>'Bạn Chưa Có Tài Khoản', 'watch'=> 'Xem',
                'auto-play'=>'Tự Động Phát', 'followed'=>'Người đã đăng ký', 'follow'=>'Đăng Ký', 
                'edit'=>'Chỉnh Sửa', 'remove'=>'Xóa', 'cancel'=>'Hủy Bỏ', 'save'=>'Lưu Lại', 
                'login-to-comment' => 'Đăng nhập để bình luận','watch-reply-comment'=>'Xem trả lời', 
                'close-reply-comment'=>'Đóng', 'setting'=>'Cài đặt', 
                'sologan-setting'=>'Trang này cho phép bạn thay đổi cấu hình những gì bạn đã thực hiện',
                'profile'=>'trang cá nhân','language'=>'Ngôn ngữ','theme'=>'Chủ đề','Cancel Subscribe'=> 'Hủy Đăng ký Kênh'
            );
            }else {
                return array('home'=>'Home', 'login'=>'Log In', 'register'=>'Register', 'join'=>'Join', 
                'username'=>'Username', 'start'=>'Start','create-new-account'=>'Create New Account',
                'already-member'=>'Already A Member', 'email'=>'Email', 'password' => 'Password', 
                'confirm-password'=>'Confirm Password', 'create'=>'Create', 'no-account'=>"You don't have account", 
                 'watch'=>'Watch', 'auto-play'=>'Auto Play',  'followed'=>'Followed', 'follow'=>'Subscribe', 
                 'edit'=> 'Edit', 'remove'=>'Remove', 'cancel'=>'Cancel', 'save'=>'Save',
                  'login-to-comment' =>'Login to Comment', 'watch-reply-comment' =>'Watch reply',
                'close-reply-comment'=>'Close', 'setting'=>'Setting', 
                'sologan-setting'=>'This page allow you change configuration what you have made',
                'profile'=>'Profile','language'=>'Language','theme'=>'Theme', 'Cancel Subscribe'=> 'Cancel Subscribe'
                );
            }
        }
    }
?>