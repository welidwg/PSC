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
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
    $user = mysqli_num_rows(mysqli_query($connect, "SELECT * from useraccounts where Email like '$email'"));
    if ($user == 1) {
        return true;
    }
    return false;
}
function sendMail($email, $subject, $body)
{
    include("./Mailer/src/PHPMailer.php");
    include("./Mailer/src/SMTP.php");
    require("./Mailer/src/Exception.php");


    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->CharSet = "UTF-8";
    $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
    $mail->Host = 'smtp.gmail.com'; // Spécifier le serveur SMTP
    $mail->SMTPAuth = true; // Activer authentication SMTP
    $mail->SMTPSecure = 'ssl';
    $mail->Username = 'Mediatheque.Monastir@gmail.com';
    $mail->Password = 'Barcelona1899';
    $mail->Port = 465;
    $mail->SetFrom("Mediatheque.Monastir@gmail.com", "Médiathèque Régionale de Monastir");
    $mail->AddAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $body;
    $mail->send();
}
function GetEMPR($id)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from empr where id_empr = $id"));
    if ($user) {
        return $user;
    } else {
        return false;
    }
    # code...
}

function GetDocById($id)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from empr where id_empr = $id"));
    if ($user) {
        return $user;
    } else {
        return false;
    }
    # code...
}
function GetDocByRef($ref)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from empr where empr_cb = '$ref'"));
    if ($user) {
        return $user;
    } else {
        return false;
    }
    # code...
}
function GetNoticeById($id)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from notices where notice_id = $id"));
    if ($user) {
        return $user;
    } else {
        return false;
    }
    # code...
}
function GetNoticeByISBN($isbn)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from notices where code = '$isbn'"));
    if ($user) {
        return $user;
    } else {
        return false;
    }
    # code...
}
function GetAuthorById($id)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from authors where author_id = $id"));
    if ($user) {
        return $user;
    } else {
        return false;
    }


    # code...
}

function GetCollectionById($id)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from collections where collection_id = $id"));
    if ($user) {
        return $user;
    } else {
        return false;
    }
    # code...
}
function GetNumRows($req)
{
    $connect = Connect();
    return mysqli_num_rows(mysqli_query($connect, $req));
}
function GetUser($id)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from useraccounts where idUser = '$id'"));
    return $user;
    # code...
}
function GetUserByEmail($email)
{
    $connect = Connect();
    $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from useraccounts where Email = '$email'"));
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
