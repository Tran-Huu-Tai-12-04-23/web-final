<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL.'assets/images/logo.png';?>" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous" />
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/reset.css';?>" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/component.css';?>" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/custom.css';?>" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/root.css';?>" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/loader/style.css';?>" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo BASE_URL.'assets/js/index.js'?>">
</script>



<?php 
    $Util = new Utils();
    $Middleware = new Middleware();
    session_start(); // start the session
    $isLogin = isset($_SESSION['isLogin']) ? $_SESSION['isLogin'] : False;
    $userName = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
    $avatar = isset($_SESSION['avatar']) ? $_SESSION['avatar'] : '';
    if( str_contains($avatar,'http')) {
        $avatar = $Util->getAvatar($avatar);
    }else {
        $avatar= BASE_URL.substr($avatar,1, strlen($avatar));
    }
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
?>
<script>
    $(document).ready(function() {
        <?php 
            $url = $_GET['url']??'';
            if( $url != 'search') {
            ?>
            renderSubMenuSearchHistory();
        <?php }?>
    })
</script>