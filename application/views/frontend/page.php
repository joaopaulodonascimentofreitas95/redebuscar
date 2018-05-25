
<?php
extract($page[0]);
?>
<article class="single_page">
    <header class="masthead" style="background-image: url('<?= (!empty($page_cover) ? base_url("assets/uploads/{$page_cover}")  : null );?>')">
        <div class="overlay"></div>
        <div class="container">           
            <div class="post-heading text-white">
                <h1><?= $page_title; ?></h1>
                <p class="subheading"><?= $page_subtitle; ?></p>            
            </div>           
        </div>
    </header>
    <div class="container">
        <div class="htmlchars">
            <?= $page_content; ?>
        </div>
    </div>
</article>