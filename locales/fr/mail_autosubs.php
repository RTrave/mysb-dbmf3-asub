<?php
    global $mail;

    $mail->subject = _G('DBMF_autosubs_notifysubj');

    $mail->body = 'Bonjour,<br><br>
vous vous êtes inscrit en tant que:<br>
'.$mail->data['body'].'<br>
<br>
merci et à très bientôt.';

?>
