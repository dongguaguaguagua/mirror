<?php
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once("php/PHPMailer.php");
require_once("php/Exception.php");
require_once("php/POP3.php");
require_once("php/SMTP.php");
require_once("email.php");
class email
{
    public static function send($head,$html,$text,$addr,
                                $mail_host,
                                $mail_user,
                                $mail_pass,
                                $mail_port,
                                $mail_from,
                                $mail_name,
                                $mail_dbug)
    {
        $mail = new PHPMailer(true);
        try {
            echo $mail_pass; 
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
            $mail->isSMTP();                                     
            $mail->Host       = $mail_host;             
            $mail->SMTPAuth   = true;                            
            $mail->Username   = $mail_user;             
            $mail->Password   = $mail_pass;                       
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
            $mail->Port       = $mail_port;                             
            $mail->setFrom($mail_from,$mail_name);
            $mail->addAddress($addr);
            //-----------------------------------------------------
            //$mail->addAddress('joe@example.net', 'Joe User');
            //$mail->addAddress('ellen@example.com'); 
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            //$mail->addAttachment('/var/tmp/file.tar.gz');
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 
            //-----------------------------------------------------
            $mail->isHTML(true);
            $mail->Subject = $head;
            $mail->Body    = $html;
            $mail->AltBody = $text;
            $mail->send();
            echo '<br />['.$mail_dbug.']发送了一封邮件：'.$addr;
            return '['.$mail_dbug.']发送了一封邮件：'.$addr;
        } 
        catch (Exception $e) {
            echo '<br />['.$mail_dbug.']邮件未能够发送：'.$addr;
            echo '<br />['.$mail_dbug.']失败原因：'.$mail->ErrorInfo;
            return '['.$mail_dbug.']邮件未能够发送：'.$addr;
        }
    }
}
if($_POST['name']== '' )
{
    echo "<script>alert('请输入姓名')</script>";
    echo "<script>history.go(-1);</script>";  
}
elseif ( $_POST['pnum'] == '') {
    echo "<script>alert('请输入手机')</script>";
    echo "<script>history.go(-1);</script>";   
}
elseif ( $_POST['mail'] == '') {
    echo "<script>alert('请输入邮箱')</script>";
    echo "<script>history.go(-1);</script>";   
}
elseif ( $_POST['qqid'] == '') {
    echo "<script>alert('请输入qq号')</script>";
    echo "<script>history.go(-1);</script>";   
}
elseif ( $_POST['text'] == '') {
    echo "<script>alert('请输入内容')</script>";
    echo "<script>history.go(-1);</script>";   
}
else{
    $title = "【飞扬官网】你收到了一份来自飞扬官网联系请求";
    $htmls = "<h1>飞扬官网：来自".$_POST['name']."的联系请求</h1>"
             ."<br />姓名：".$_POST['name']
             ."<br />电话：".$_POST['pnum']
             ."<br />邮箱：".$_POST['mail']
             ."<br />QQ号：".$_POST['qqid']
             ."<br />部门：".$_POST['selt']
             ."<br />内容：".$_POST['text'];
    $plain = "";
        if($_POST['selt']=='维修部')$email = $selt_wxbm;
    elseif($_POST['selt']=='研发部')$email = $selt_yfbm;
    elseif($_POST['selt']=='行政部')$email = $selt_xzbm;
    elseif($_POST['selt']=='设计部')$email = $selt_sjbm;
    elseif($_POST['selt']=='编辑部')$email = $selt_bjbm;
    else                            $email = $selt_alls;
    $posts = email::send($title,
                         $htmls,
                         $plain,
                         $email,
                         $mail_host,
                         $mail_user,
                         $mail_pass,
                         $mail_port,
                         $mail_from,
                         $mail_name,
                         $mail_dbug);
    echo "<script>alert('提交成功！')</script>";
    echo "<script>history.go(-1);</script>";
}

?>