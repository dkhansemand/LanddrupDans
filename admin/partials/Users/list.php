<?php

$user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Dashboard');

    $users = $user->getAllUsers();

?>
<div class="row">
    <div class="col s12">
        <h4>Brugere</h4>
        <a href="./index.php?p=home&view=Users/Create" class="btn-floating btn-large waves-effect waves-light teal right"><i class="material-icons">add</i></a>
        <table class="bordered highlight striped responsive-table">
            <thead>
                <tr>
                    <th>Fornavn</th>
                    <th>Efternavn</th>
                    <th>E-mail</th>
                    <th>Tlf.</th>
                    <th>Adresse</th>
                    <th>Rolle</th>
                    <th>Oprret (Dato)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($users as $user){
                    if($_SESSION['userId'] !== $user->userId){
                ?>
                    <tr>
                        <td><?=$user->firstname?></td>
                        <td><?=$user->lastname?></td>
                        <td><?=$user->userEmail?></td>
                        <td><?=$user->phone?></td>
                        <td><?=$user->street . ', ' . $user->zipcode . ' ' . $user->city?></td>
                        <td><?=$user->roleName?></td>
                        <td><?=$user->dateCreated?></td>
                        <td>
                        <?php
                            if($_SESSION['roleLevel'] >= $user->roleLevel) {
                        ?>
                            <a href="./index.php?p=home&view=Users/Edit&id=<?=$user->userId?>" class=""><i class="material-icons">mode_edit</i></a>
                        <?php
                                if($_SESSION['roleLevel'] >= 90){
                        ?>
                                    <a href="#deleteModal" class="btnUserDelete red-text" data-userid="<?=$user->userId?>"><i class="material-icons">delete</i></a>
                        <?php
                                }
                        ?>
                        <?php } ?>
                        </td>
                    </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <!-- User delete modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
            <h4>Slet bruger</h4>
            <p>Er du helt sikker på, at bruger skal slettes?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Anullér</a>
                <a href="./index.php?p=home&view=Users/Delete&id=" id="btnDel" class="red lighten-2 white-text waves-effect waves-green btn">SLET</a>
            </div>
        </div>
    </div>
</div>