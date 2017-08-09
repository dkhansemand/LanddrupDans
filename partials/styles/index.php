<?php
$styles = $content->getStyles();
?>


<div class="container">
    <h2>Stilarter</h2>
    <hr>
    <div class="row">
        <?php
        foreach ($styles as $styleType) {
            $stylesPicture = !empty($styleType->filepath) ? './media/'.$styleType->filepath : '//placehold.it/85x85';
            ?>
            <div class="col s6 m4">
              <a href="./index.php?p=Styles/Details&id=<?=$styleType->stylesId?>">
                <div class="card hoverable">
                    <div class="card-image">
                         <img src="<?=$stylesPicture?>" class="responsive-img">
                        <span class="card-title black-text"><?=$styleType->stylesName?></span>
                    </div>
                    <div class="card-content black-text">
                        <p><?=$styleType->stylesDescription?></p>
                    </div>
                </div>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</div>