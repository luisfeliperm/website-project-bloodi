<?php
require $_SERVER['DOCUMENT_ROOT']."/php/config/config.php";
require $_SERVER['DOCUMENT_ROOT']."/php/config/re-captcha.php";

function gerar_hash($senha){
    $salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
    $output = hash_hmac('md5', $senha, $salt);
    return $output;
}

if (!isset($_POST["re_captcha"])) {
    save_log('warning.log',_CLIENT_ADDR.' [Signup.Ajax] re-captcha vazio');
    die(0);
}

$secret=_CAPTCHA_SECRETKEY;
$response= $_POST["re_captcha"];

$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
$captcha_success=json_decode($verify);
if ($captcha_success->success!==true) {
    save_log("error.log","[Signup.Ajax] Captcha retornou FALSE");
    die("<b>Erro: </b>Responda o captcha!");
}


if( !isset($_POST['user'],$_POST['pass'], $_POST['mail']) ){
    die("<b>Erro:</b> Preencha todos os campos!"); 
}

$data['mail'] = trim(strtolower($_POST['mail']));
$data['user'] = trim(strtolower($_POST['user']));



if (mb_strlen($data['user'], 'utf8') < 4 OR mb_strlen($data['user'], 'utf8') > 16) {
    die('<b>Aviso:</b>O usuario deve ter 4-16 caracteres!');
}
if (mb_strlen($_POST['pass'], 'utf8') < 4 OR mb_strlen($_POST['pass'], 'utf8') > 16) {
    die('A senha deve ter entre 4-16 caracteres!');
}

$data['pass'] = gerar_hash($_POST['pass']);


if(!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)){die('Email incorreto');}
$allow_email = false;

$white_mail = array("gmail.com", "outlook.com", "hotmail.com");
foreach ($white_mail as $arraystr) {
    $len = strlen($arraystr); 
    if ($len == 0) { return true; } 
    if (substr($data['mail'], -$len) === $arraystr){
        $allow_email = true;
    }
}
if ($allow_email === false) {
    die('<b>Email:</b> só é permitido o uso do gmail, outlook e hotmail');
}



try {
    $conn = new PDO("pgsql:host="._DB_HOST.";port="._DB_PORT.";dbname="._DB_NAME, _DB_USER, _DB_PASS); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT login,email from contas where ( lower(email) = :mail OR lower(login) = :user ) limit 1; ";
    $stmt = $conn->prepare($sql); 
    $stmt->bindValue(':mail', $data['mail']);
    $stmt->bindValue(':user', $data['user']);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $x = $stmt->fetch(PDO::FETCH_ASSOC);
        if($x['login'] == $data['user']){
            die("<b>Atenção:</b> Usuario já em uso!");
        }
        if($x['email'] == $data['mail']){
            die("<b>Atenção:</b> Email já em uso!");
        }
    }
    $stmt = null;


    $token = md5($data['user'].$dataLocal);

    $stmt = $conn->prepare("INSERT INTO site_accounts_confirm (email,login,password,ip,token) 
    VALUES (:mail, :user, :pass, :ip, :token)");

    $stmt->bindValue(':mail', $data['mail']);
    $stmt->bindValue(':user', $data['user']);
    $stmt->bindValue(':pass', $data['pass']);
    $stmt->bindValue(':ip', _CLIENT_ADDR);
    $stmt->bindValue(':token', $token);

    if($stmt->execute()){
        

        $mail_config = (parse_ini_file($_SERVER['DOCUMENT_ROOT']."/php/config/email.ini"));

        require $_SERVER['DOCUMENT_ROOT'].'/php/class/PHPMailer-5.2-stable/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $mail_config['usuario'];
            $mail->Password = $mail_config['senha'];
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->IsHTML(true);
            $mail->From = $mail_config['remetente'];
            $mail->FromName = $mail_config['nomeRemetente'];
            $mail->addAddress($data['mail']);
            $mail->Subject = $mail_config['assunto'];
            $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
            <meta charset="utf-8">
            <title>Ativar conta</title>
            </head>
            <body>
            <h1>Ative sua conta</h1>
            <p>Para confirmar seu cadastro, entre link no abaixo</p><a href="'.$mail_config['dominio'].'cadastro/confirmar/'.$token.'/">'.$mail_config['dominio'].'cadastro/confirmar/'.$token.'/</a>
            <hr>
            <address>'.$mail_config['descricao'].'</address>
            <style>*{font-family:arial;}</style>
            </body>
            </html>';

            if($mail->Send()){
                die("1"); // Sucess
            }else{
                save_log('error.log',_CLIENT_ADDR.' Falha ao enviar email -> '.$mail->ErrorInfo);
            }
        } catch (Exception $e) {
            save_log('error.log',_CLIENT_ADDR.'[MAIL] Falha ao enviar email -> '.$e->errorMessage());
        } catch (\Exception $e) { 
            save_log('error.log',_CLIENT_ADDR.'[MAIL] Falha ao enviar email -> '.$e->getMessage());
        }
        echo '<b>Erro: </b> falha ao enviar o email para <address>'.$data['mail'].'</address> ';
        $sql = "DELETE FROM site_accounts_confirm WHERE token = '$token' ";
        query($sql);


    }else{
        save_log('error.log',_CLIENT_ADDR.'Falha ao registrar usuario -> '.$data);
        die("0");
    }
    $stmt = null;

}catch(PDOException $e){
    echo $e->getMessage();
    save_log("error.log","Error: " . $e->getMessage());
}
$conn = null;
