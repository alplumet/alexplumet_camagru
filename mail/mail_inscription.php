<?php

    function    send_the_confirmation_mail($db, $login, $email, $key){
        $req = $db->prepare("UPDATE user SET keymail = ? WHERE login = ?");
        $req->execute(array ($key, $login));
        
        $destinataire = $email;
        $sujet = "Activer votre compte" ;
        $entete = "From: camagru" ;

        // Le lien d'activation est composé du login(log) et de la clé(cle)
        $message = 'Bienvenue sur Camagru,

        Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
        ou copier/coller dans votre navigateur Internet.

        http://localhost:8080/camagru/mail/mail_activation.php?log='.urlencode($login).'&cle='.urlencode($key).'


        ---------------
        Ceci est un mail automatique, Merci de ne pas y repondre.';
        mail($destinataire, $sujet, $message, $entete);
    }

?>