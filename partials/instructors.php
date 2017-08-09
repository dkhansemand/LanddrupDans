<?php
$users = $user->getInstructors();
?>

            <div class="container">
                <h2>Instruktører</h2>
                <div class="row">
                    <?php
                    foreach ($users as $instr){
                        ?>
                        <div class="col s6 m4 l3">
                            <div class="card small">
                                <div class="card-image">
                                    <img src="./media/<?=$instr->filePath?>">
                                    <span class="card-title"><?=$instr->firstname?> &nbsp;<?=$instr->lastname?></span>
                                </div>
                                <div class="card-content">
                                    <p>I am a very simple card. I am good at containing small bits of information.
                                        I am convenient because I require little markup to use effectively.</p>
                                </div>
                                <div class="card-action">
                                    <a href="#">This is a link</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
