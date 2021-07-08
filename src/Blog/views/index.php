<?= $renderer->render('header'); ?>

<h1>Welcome to my blog</h1>
<ul>

    <li>rticle A</li>
    <li>Article 2</li>
    <li>Article 3</li>
    <li>Article 4</li>
    <li><a href="<?= $router->getGeneratedUri('blog.show',['slug'=>'article-5adz'])?>">Article 4</a></li>

</ul>

<?= $renderer->render('footer') ?>
