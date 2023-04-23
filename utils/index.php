<?php 
   
    class Utils {
        function __construct(){
            
        }
     
        public function formatTime($timeStr) {
            $time = strtotime($timeStr);
            $diff = abs(time() - $time);
            $units = array('Seconds ago', 'Minutes ago', 'Hours ago', 'Days ago', 'Months ago', 'Years ago');
            $intervals = array(60, 60, 24, 30, 12);
            $pow = 0;
            
            while ($diff >= $intervals[$pow] && $pow < count($intervals) - 1) {
                $diff /= $intervals[$pow];
                $pow++;
            }
            
            return round($diff) . ' ' . $units[$pow];
        }
        
        public function getThumbnail($link) {
            if( str_contains( $link,'http' ) == true) return $link;
            if( file_exists($link)) {
                return $link;
            }else {
                return 'https://visionsserviceadventures.com/wp-content/uploads/2021/11/video_default_thumb.png';
            }
        }

        public function getAvatar($avatar) {
            if( str_contains($avatar, 'http') == true) return $avatar;
            if( str_contains($avatar, 'assets/upload_img') ) {
                return BASE_URL_IMG . $avatar;
            }else {
                return 'https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-portrait-176256935.jpg';
            }
        }

        public function getFill($data){
            if( $data ) {
                return $data;
            }else {
                return '';
            }
        }
        public function getPrevUrl() {
            $prevUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            // Get the previous previous URL
            $prevPrevUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            if (!empty($prevUrl)) {
                $prevUrlArr = parse_url($prevUrl);
                if (isset($prevUrlArr['query'])) {
                    parse_str($prevUrlArr['query'], $params);
                    if (isset($params['previous'])) {
                        $prevPrevUrl = $params['previous'];
                    }
                }
            }
            return $prevPrevUrl;
        }

    }
   
    
?>