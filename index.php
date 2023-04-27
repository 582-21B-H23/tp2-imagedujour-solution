<?php
	$module = 'image';
    require('lib/util.lib.php');
	require("lib/$module-controleur.lib.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= dateFormatee($image['jour']); ?> :: IdJ</title>
    <link rel="shortcut icon" href="ressources/images/favicon.png" type="image/png">
    <link rel="stylesheet" href="ressources/css/idj.css">
    <style>
        /* L'image du jour est placée avec CSS comme "fond d'écran" */
        html {
            background-image: url(ressources/photos/<?= $image['fichier'] ?>);
        }
    </style>
</head>
<body>
    <?php 
        if(isset($_GET['msg']) && isset(MSG_UI[$_GET['msg']])): 
            $toast = MSG_UI[$_GET['msg']];
    ?>
    <div class="conteneur-toast">
        <input type="checkbox" id="cc-msg-toast">
        <label 
            for="cc-msg-toast" 
            class="msg-toast msg-<?= $toast['type']; ?>" 
            title="Cliquez pour fermer"
        >
            <?= $toast['texte'] ?>
        </label>
    </div>
    <?php endif ?>
    <div class="etiquette aime">
        <!-- Seul un utilisateur connecté peut soumettre un plébiscite -->
        <a 
            href="plebiscite.php?op=plebisciter&iid=<?= $image['id']; ?>&etat=<?= $plebiscite['etat']; ?>" 
            class="btn-aime"
        >
            <img src="ressources/images/aime-<?= $plebiscite['etat']; ?>.png" alt="">
        </a>
        <?= $plebiscite['decompte']; ?>
    </div>
    <aside>
        <!-- Seulement si utilisateur n'est pas connecté -->
        <!-- Connexion -->
        <?php if(!$util) : ?>
        <form method="post" action="utilisateur.php?op=connexion" class="connexion">
            <input type="text" name="pseudo" placeholder="Pseudo">
            <input type="password" name="mdp" placeholder="Mot de passe">
            <button type="submit" title="Connexion">&#x279C;</button>
        </form>
        <?php endif; ?>
        <!-- Seulement si utilisateur connecté -->
        <?php if($util) : ?>
        <div class="gestion-util">
            <!-- Profil utilisateur et déconnexion -->
            <div class="utilisateur-courant">
                <span class="util"><?= $util['pseudo']; ?></span>
                <a href="utilisateur.php?op=deconnexion" title="Déconnexion">
                    <img src="ressources/images/logout.png" alt="logout">
                </a>
            </div>
            <!-- Ajout de commentaire -->
            <form 
                class="commentaire" 
                action="commentaire.php?op=ajouter&iid=<?= $image['id']; ?>" 
                method="post"
            >
                <textarea name="texte" id="commentaire"></textarea>
                <button type="submit" title="Envoyer">&#x279C;</button>
            </form>    
        </div>
        <?php endif; ?>
        <ul class="commentaires">
            <?php foreach ($commentaires as $com) : ?>
            <li style="opacity: clamp(0.4,<?= $com['taux'] ?>,0.9)">
                <!-- Seulement si ce commentaire appartient à l'utilisateur connecté -->
                <?php if($util && $com['utilisateur_id']==$util['id']): ?>
                    <a 
                        href="commentaire.php?op=supprimer&cid=<?= $com['id']; ?>" 
                        class="btn-supprimer-commentaire" 
                        title="Supprimer ce commentaire"
                    >&#x2716;</a>
                <?php endif; ?>
                <span class="util"><?= $com['pseudo']; ?></span>
                <span class="texte"><?= $com['texte']; ?></span>
                <div class="vote">
                    <a href="vote.php?op=voter&updown=1&cid=<?= $com['id']; ?>">
                        <span class="up"><?= $com['approbateurs']; ?></span>
                    </a>
                    <a href="vote.php?op=voter&updown=-1&cid=<?= $com['id']; ?>">
                        <span class="down"><?= $com['desapprobateurs']; ?></span>
                    </a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <div class="info">
        <div class="date">
            <span class="premier">
                <?php if($image['jour']>$jourMin) : ?>
                    <a 
                        title="Premier jour disponible (<?= dateFormatee($jourMin) ?>)" 
                        href="index.php?op=afficher&jour=<?= $jourMin ?>"
                    >&#x21E4;</a>
                <?php ;else: ?>
                    <a class="lien-inactif">&#x21E4;</a>
                <?php endif ?>
            </span>
            <span class="prec">
                <?php if(isset($prec)) : ?>
                    <a 
                        title="Jour précédent (<?= dateFormatee($prec) ?>)" 
                        href="index.php?op=afficher&jour=<?= $prec; ?>"
                    >&#x2B60;</a>
                <?php ;else: ?>
                    <a class="lien-inactif">&#x2B60;</a>
                <?php endif ?>
            </span>
            <span class="suiv">
                <?php if(isset($suiv)) : ?>
                    <a 
                        title="Jour suivant (<?= dateFormatee($suiv) ?>)" 
                        href="index.php?op=afficher&jour=<?= $suiv; ?>"
                    >&#x2B62;</a>
                <?php ;else: ?>
                    <a class="lien-inactif">&#x2B62;</a>
                <?php endif ?>
            </span>
            <span class="dernier">
                <?php if($image['jour']<$jourMax) : ?>
                    <a 
                        title="Aujourd'hui (<?= dateFormatee($jourMax) ?>)" 
                        href="index.php?op=afficher&jour=<?= $jourMax; ?>"
                    >&#x2B72;</a>
                <?php ;else: ?>
                    <a class="lien-inactif">&#x2B72;</a>
                <?php endif ?>
            </span>
            <i><?= dateFormatee($image['jour']); ?></i>
        </div>
        <?php if($image['description'] && $image['description'] != '') : ?>
            <div class="etiquette etiquette-etendue description">
                <?= $image['description']; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>