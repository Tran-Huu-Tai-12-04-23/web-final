<?php
require_once './config/config.php';
class Controller {
    private $db;
    public function __construct() {
        $database = new DB();
        $this->db = $database->getInstance();
    }
    public function model($model){
        if( gettype($model) == 'array'){
            foreach ($model as $mod ) {
                include './models/'.$mod.'.php';
            }
        }
        else if (file_exists('./models/'.$model.'.php')) {
            include './models/'.$model.'.php';
            // $Data = new $model();
            // video
        }
    }

    //method gọi view
    public function view($view, $data = []){
        $view = strtolower($view);
        if(file_exists('./views/'.$view)){
            include './views/'.$view;
            // home
        }else {
            echo 'Page not found ^^^ 404';
        }
    }

    public function getDataFrom($query) {
        $result = $this->db->query($query);
        if ($result !== false && $result->num_rows > 0) {
            $row = mysqli_fetch_array($result);
            return $row;
        } else {
           return null;
        }
    }
    public function returnHome() {
        $root = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/";
        echo "<script>window.location.href = '".BASE_URL."'</script>";
    }
    public function reject($link = '') {
        echo '<script>window.location.href ="'.BASE_URL.$link.'"</script>';
    }

    public function addNotAvailable() {
        ob_end_clean();
        echo json_encode(array('status'=>false , 'message'=> 'Api not available!!!'));
    }
}
?>