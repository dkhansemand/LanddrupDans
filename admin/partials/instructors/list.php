<?php

    $user->checkAuth(50, $_SESSION['userId']) ? null : header('Location: ./index.php?p=home&view=Dashboard');

    $instructors = $user->getInstructors();
?>

<div class="row">
    <div class="col s12">
        <h4>Instruktører</h4>
        <a href="./index.php?p=home&view=Instructors/Create" class="btn-floating btn-large waves-effect waves-light teal right"><i class="material-icons">add</i></a>
        <table class="bordered highlight striped responsive-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Fornavn</th>
                    <th>Efternavn</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($instructors as $instructor){
                   
                ?>
                    <tr>
                        <td><img src="../media/<?=$instructor->filePath?>" alt="" class="circle responsive-img" height="95" width="80"></td>
                        <td><?=$instructor->firstname?></td>
                        <td><?=$instructor->lastname?></td>
                        <td>
                        <?php
                            if($_SESSION['roleLevel'] >= 50) {
                        ?>
                            <a href="./index.php?p=home&view=Instructors/Edit&id=<?=$instructor->insId?>" class=""><i class="material-icons">mode_edit</i></a>
                        <?php
                                if($_SESSION['roleLevel'] >= 90){
                        ?>
                                    <a href="#deleteModal" class="btnInstructorDelete red-text" data-userid="<?=$instructor->insId?>"><i class="material-icons">delete</i></a>
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
            <h4>Slet Instruktør</h4>
            <p>Er du helt sikker på, at instruktøren skal slettes?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Anullér</a>
                <a href="./index.php?p=home&view=Instructors/Delete&id=" id="btnDel" class="red lighten-2 white-text waves-effect waves-green btn">SLET</a>
            </div>
        </div>
    </div>
</div>