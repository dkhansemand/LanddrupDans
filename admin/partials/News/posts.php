<?php
    $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Dashboard');
    $news = $news_->getAll();
?>
<div class="row">
    <div class="col s12">
        <h4>Nyheder</h4>
        <a href="./index.php?p=home&view=News/Add" class="btn-floating btn-large waves-effect waves-light teal right"><i class="material-icons">add</i></a>
        <table class="bordered highlight striped responsive-table">
            <thead>
            <tr>
                <th>Overskrift</th>
                <th>Forfatter</th>
                <th>Udgivet dato</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($news as $post){
                ?>
                <tr>
                    <td><?=$post->newsTitle?></td>
                    <td><?=$post->firstname . ' ' . $post->lastname?></td>
                    <td><?= $post->newsPublish == 1 ? 'Udgivet' : 'Kladde'?></td>
                    <td>
                        <?php
                        if($_SESSION['roleLevel'] >= 50) {
                            ?>
                            <a href="./index.php?p=home&view=News/Edit&id=<?=$post->newsId?>" class=""><i class="material-icons">mode_edit</i></a>
                            <?php
                            if($_SESSION['roleLevel'] >= 90){
                                ?>
                                <a href="#deleteModal" class="btnPostDelete red-text" data-postid="<?=$post->newsId?>"><i class="material-icons">delete</i></a>
                                <?php
                            }
                            ?>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <h4>Slet nyhed</h4>
                <p>Er du helt sikker på, at nyheden skal slettes?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Anullér</a>
                <a href="./index.php?p=home&view=News/Delete&id=" id="btnDel" class="red lighten-2 white-text waves-effect waves-green btn">SLET</a>
            </div>
        </div>
    </div>
</div>