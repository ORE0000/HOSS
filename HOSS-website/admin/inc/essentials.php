<?php
    //frontend process data 
    define('SITE_URL','http://127.0.0.1/HOSS-website/');
    define('ABOUT_IMG_PATH',SITE_URL.'images/about/');





    //backend upload process data 
    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/HOSS-website/images/');
    define('ABOUT_FOLDER','about/');

        function adminLogin(){
            session_start();
            if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
                echo"
                <script>window.location.href='index.php'</script>
            
            ";
            exit;
            }

        }

    function redirect($url){
        echo"
            <script>window.location.href='$url'</script>
        
        ";
        exit;

    }

    function alert($type,$msg){
        $bs_class = ($type =="sucess") ? "alert-sucess" : "alert-danger";
        echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        alert;
    }

    function uploadImage($image,$folder){
        $valid_mime = ['image/jpeg','image/png','image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime,$valid_mime)){
            return 'inv_img'; //invalid image mime or format
        }
        else if(($image['size']/(1024*1024))>2){
            return 'inv_img'; // invalid size greater than 2 mb
        }
        else{
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,999999).".$ext";
            
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else{
                return 'upd_failed';
            }

        }
    }


    function deleteImage($image,$folder){
        if (unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
            return true;
        }
        else{
            return false;
        }
    }

?>