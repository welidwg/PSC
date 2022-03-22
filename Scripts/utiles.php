<?php
function Connect()
{
    $servername = "localhost";
    $username = "root";
    $password = '';
    $db = "bibli";
    $connect = mysqli_connect($servername, $username, $password, $db) or die("Connection Error");
    mysqli_set_charset($connect, 'utf8');
    return $connect;
}
function RandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function runQuery($query)
{
    $connect = Connect();
    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $resultset[] = $row;
    }
    if (!empty($resultset))
        return $resultset;
}
function checkEmail($email)
{
    $connect = Connect();
    $user = mysqli_num_rows(mysqli_query($connect, "SELECT * from userAccounts where Email like '$email'"));
    if ($user == 1) {
        return true;
    }
    return false;
}
function GetEMPR($id)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from empr where id_empr = $id"));
    return $user;
    # code...
}
function GetUser($id)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from userAccounts where idUser = $id"));
    return $user;
    # code...
}
function translate($q, $sl, $tl)
{
    $res = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&ie=UTF-8&oe=UTF-8&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&dt=at&sl=" . $sl . "&tl=" . $tl . "&hl=hl&q=" . urlencode($q), $_SERVER['DOCUMENT_ROOT'] . "/transes.html");
    $res = json_decode($res);
    return $res[0][0][0];
}
function CheckAr($char)
{
    return preg_match('/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u', $char);
}
