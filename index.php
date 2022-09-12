<?php
error_reporting(0);

// 変数の初期化
$value = "";

$title = "";

$result = "";

$key = "";

$cipher = 'AES-256-CBC';

$iv = "";



// htmlファイル取得
$html = file_get_contents("index.html");


// POSTで帰ってきたら
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $select = $_POST['select'];

    if($_POST['iv'] !== ''){
        $iv = $_POST['iv'] ;
    }

    // 鍵の値エンコード
    if($_POST['key'] === ''){
        $result  = '「共通鍵」を入力してくださいな';
    }else{
        $key = $_POST['key'];
        unset($_POST['key']);
    

        // 入力値なし
        if($_POST['str'] === ''){
            if($select === 1){
                $result  = '「暗号化する文字」を入力してくださいな';
            }else{
                $result  = '「復号する文字」を入力してくださいな';
            }
            unset($_POST['str']);
        }
        // あり
        else{
            // 入力値の取得
            $value = htmlspecialchars($_POST['str']);

            if($select === "1"){
                $result = openssl_encrypt($value, $cipher, $key,$options=0,$iv);
                $title .= "暗号化前の文字：";
            }else{
                $result = openssl_decrypt($value, $cipher, $key,$options=0,$iv);
                $title .= "復号前の文字：";
            }
            $title .= htmlspecialchars($value);
            unset($_POST['str']);
        }
    }

        $html = str_replace("{value}",htmlspecialchars($value),$html);

        $html = str_replace("{key}",htmlspecialchars($key),$html);
        
        $html = str_replace("{title}",htmlspecialchars($title),$html);

        $html = str_replace("{iv}",htmlspecialchars($iv),$html);
        
        $html = str_replace("{result}",htmlspecialchars($result),$html);
    
}
else{

    $html = str_replace("{value}",htmlspecialchars($value),$html);

    $html = str_replace("{key}",htmlspecialchars($key),$html);

    $html = str_replace("{title}",htmlspecialchars($title),$html);

    $html = str_replace("{iv}",htmlspecialchars($iv),$html);

    $html = str_replace("{result}",htmlspecialchars($result),$html);

}

    
printf($html);

