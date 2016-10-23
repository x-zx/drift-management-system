<?php
/**
*   CODE       STATE
*      0       success
*      1       no date
*      2       not base64
*      3       file type not allowed
**/
$save_path = 'files\\';
$file_path = 'files/';
$allow_ext = ['jpg','png','bmp','jpeg'];
$code = null;
$url  = null;
if(isset($_POST['data'])){
    $base64_url  = $_POST['data'];
    if(preg_match('/\w+;base64/',$base64_url)){
        preg_match('/\/(\w+);/',$base64_url,$m);
        $file_ext = isset($m[1]) ? $m[1] : '';
        if(in_array($file_ext,$allow_ext)){
            $base64_body = substr(strstr($base64_url,','),1);
            $data = base64_decode($base64_body);
            $file_name = uniqid() . '.' .$file_ext;
            file_put_contents($save_path . $file_name,$data);
            $url = $file_path . $file_name;
            $code = 0;
        }else{
            $code = 3;
        }
    }else{
        $code = 2;
    } 
}else{
    $code = 1;
}

echo json_encode(['code' => $code , 'url' => $url]);
//或$image = imagecreatefromstring($data);
 