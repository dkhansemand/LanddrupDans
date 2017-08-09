<?php
$user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Dashboard');
$styles = $content->getStyles();
?>
<div class="row">
    <div class="col s12">
        <h4>Stilarter</h4>
        <a href="./index.php?p=home&view=Styles/Create" class="btn-floating btn-large waves-effect waves-light teal right"><i class="material-icons">add</i></a>
        <table class="bordered highlight striped responsive-table">
            <thead>
            <tr>
                <th>Billede</th>
                <th>Stilart</th>
                <th>Filnavn</th>
                <th>Edit/Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($styles as $style){
                $stylesPicture = !empty($style->filepath) ? '../media/'.$style->filepath : '//placehold.it/85x85';
                ?>
                <tr>
                    <td><img class="responsive-img" src="<?=$stylesPicture?>" height="85" width="85"></td>
                    <td><?=$style->stylesName?></td>
                    <td><?=$style->filepath?></td>
                    <td>
                        <?php
                        if($_SESSION['roleLevel'] >= 50) {
                            ?>
                            <a href="./index.php?p=home&view=Styles/Edit&id=<?=$style->stylesId?>" class=""><i class="material-icons">mode_edit</i></a>
                            <?php
                            if($_SESSION['roleLevel'] >= 90){
                                ?>
                                <a href="#deleteModal" class="btnStylesDelete red-text" data-styleid="<?=$style->stylesId?>"><i class="material-icons">delete</i></a>
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
        <!-- User delete modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <h4>Slet stilart</h4>
                <p>Er du helt sikker på, at stilarten skal slettes?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Anullér</a>
                <a href="./index.php?p=home&view=Styles/Delete&id=" id="btnDel" class="red lighten-2 white-text waves-effect waves-green btn">SLET</a>
            </div>
        </div>
    </div>
</div>