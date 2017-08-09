<?php
    $GET = $filter->sanitizeArray(INPUT_GET);
    
    $pageContent = $page->getPageContent($GET['p']);
    $news = $news_->getPublished();
?>
<div class="banner">
    <img src="./media/<?=$pageContent->filePath?>">
    <div class="bannerText center-align">
        <h2><?=$pageContent->pageTitle?></h2>
        <hr>
        <p><?=$pageContent->pageText?></p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col s6 m4">
            <a href="./index.php?p=instructors">
                <div class="card hoverable">
                    <div class="card-image">
                    <img src="http://placehold.it/300x300">
                    <span class="card-title black-text">Instruktører</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col s6 m4">
            <a href="./index.php?p=styles/index">
                <div class="card hoverable">
                    <div class="card-image">
                    <img src="http://placehold.it/300x300">
                    <span class="card-title black-text">Stilarter</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col s6 m4">
            <a href="./index.php?p=registration">
                <div class="card hoverable">
                    <div class="card-image">
                    <img src="http://placehold.it/300x300">
                    <span class="card-title black-text">Tilmelding</span>
                    </div>
                </div>
            </a>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
            <h2>Nyheder</h2>
        </div>
        <?php
        if(!empty($news)){
            foreach($news as $post){
            ?>
            <div class="col s10">
                <article>
                    <h3><?=$post->newsTitle?></h3>
                    <p>Forfatter: <em><?=$post->firstname . ' ' . $post->lastname?></em> | Udgivet: <?=$post->postedDate?></p>
                    <p><?=html_entity_decode($post->newsContent)?></p>
                </article>
                <hr>
            </div>
            <?php
            }
        }else{
        ?>
            <div class="col s12">
                <p></em>Ingen nyheder at vise</em></p>
            </div>    
        <?php
        }
        ?>
      </div>
</div>
