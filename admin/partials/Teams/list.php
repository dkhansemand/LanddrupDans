<?php
    $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Dashboard');
    $teamsList = $teams->getAllTeams();
?>
<div class="row">
    <div class="col s12">
        <h4>Hold</h4>
        <a href="./index.php?p=home&view=Teams/Create" class="btn-floating btn-large waves-effect waves-light teal right"><i class="material-icons">add</i></a>
        <table class="bordered highlight striped responsive-table">
            <thead>
            <tr>
                <th>Hold navn</th>
                <th>Stilart</th>
                <th>Aldersgruppe</th>
                <th>Niveau</th>
                <th>Instruktør</th>
                <th>Pris</th>
                <th>Tilmeldte</th>
                <th>Edit/Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($teamsList as $team){
                ?>
                <tr>
                    <td><?=$team->teamName?></td>
                    <td><?=$team->stylesName?></td>
                    <td><?=$team->ageGrpName?></td>
                    <td><?=$team->levelName?></td>
                    <td><?=$team->firstname . ' ' . $team->lastname?></td>
                    <td><?=$team->teamPrice?> kr.</td>
                    <td><a href="./index.php?p=home&view=Teams/Subscribers&teamid=<?=$team->teamId?>"><?=$teams->getTeamSubscribtions($team->teamId)?></a></td>
                    <td>
                        <?php
                        if($_SESSION['roleLevel'] >= 50) {
                            ?>
                            <a href="./index.php?p=home&view=Teams/Edit&id=<?=$team->teamId?>" class=""><i class="material-icons">mode_edit</i></a>
                            <?php
                            if($_SESSION['roleLevel'] >= 90){
                                ?>
                                <a href="#deleteModal" class="btnTeamDelete red-text" data-teamid="<?=$team->teamId?>"><i class="material-icons">delete</i></a>
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
                <h4>Slet hold</h4>
                <p>Er du helt sikker på, at holdet skal slettes?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Anullér</a>
                <a href="./index.php?p=home&view=Teams/Delete&id=" id="btnDel" class="red lighten-2 white-text waves-effect waves-green btn">SLET</a>
            </div>
        </div>
    </div>
</div>