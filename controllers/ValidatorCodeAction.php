<?php
header("Content-Type:text/html; charset=utf-8");
require_once('../config/config_global.php');

$pubkey = $_GET['pubkey'];

if($pubkey) {
    $sql = "SELECT publickey FROM db_tdcaptcha WHERE publickey='$pubkey'";
    mysql_query($sql);

    if(mysql_affected_rows() < 1) {
        echo "no";    
    }
}

$inputcode = $_POST['tdcaptcha_challenge_field'];
$pubkeytw = $_POST['pubkey'];
$privkey = $_POST['privkey'];

if($pubkeytw) {
    $sql = "SELECT captcha FROM db_tdcaptcha WHERE publickey='$pubkeytw'";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
        $code = $row['captcha'];
    }

    if($code == null) {
        echo "Please refresh code!";
    }else {
        $sql = "SELECT privatekey FROM db_tdcaptcha WHERE privatekey='$privkey'";
        mysql_query($sql);
        if(mysql_affected_rows() < 1) {
            echo "The privatekey you used is not exists! Please check it.";
        }else {
            if($code == $inputcode) {
                echo "true";
            }else {
                echo 'The error code: '.$inputcode;
            }   
        } 
    }
}
