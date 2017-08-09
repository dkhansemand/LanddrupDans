<?php
$user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Dashboard');
$agegroups = $content->getAgeGroups();
?>
<div class="row">
    <div class="col s12">
        <h4>Aldersgrupper</h4>
        <a href="./index.php?p=home&view=Agegroups/Create" class="btn-floating btn-large waves-effect waves-light teal right"><i class="material-icons">add</i></a>
        <table class="bordered highlight striped responsive-table">
            <thead>
            <tr>
                <th>Aldersgruppe</th>
                <th>Edit/Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($agegroups as $agegroup){
                ?>
                <tr>
                    <td><?=$agegroup->ageGrpName?></td>
                    <td>
                        <?php
                        if($_SESSION['roleLevel'] >= 50) {
                            ?>
                            <a href="./index.php?p=home&view=Agegroups/Edit&id=<?=$agegroup->ageGrpId?>" class=""><i class="material-icons">mode_edit</i></a>
                            <?php
                            if($_SESSION['roleLevel'] >= 90){
                                ?>
                                <a href="#deleteModal" class="btnAgeDelete red-text" data-ageid="<?=$agegroup->ageGrpId?>"><i class="material-icons">delete</i></a>
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
                <h4>Slet aldersgruppe</h4>
                <p>Er du helt sikker på, at aldersgruppen skal slettes?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Anullér</a>
                <a href="./index.php?p=home&view=Agegroups/Delete&id=" id="btnDel" class="red lighten-2 white-text waves-effect waves-green btn">SLET</a>
            </div>
        </div>
    </div>
</div>