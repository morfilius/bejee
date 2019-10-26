<?php use app\Helpers\UrlHelper;

require 'header.php'?>
<div class="container">
    <main>
        <h1>Список задач</h1>
        <div class="row">
            <div class="col-md-2">
                <span>ИМЯ</span>
                <p>
                    <span>Сортировка</span><br>
                    <a href="<?php echo UrlHelper::getLink('/', array(
                            'sort' => 'name',
                            'direction' => 'ASC'
                    ))?>">По возрастанию</a><br><a href="<?php echo UrlHelper::getLink('/', array(
                        'sort' => 'name',
                        'direction' => 'DESC'
                    ))?>">По убыванию</a>
                </p>
            </div>
            <div class="col-md-2">
                <span>EMAIL</span>
                <p>
                    <span>Сортировка</span><br>
                    <a href="<?php echo UrlHelper::getLink('/', array(
                        'sort' => 'email',
                        'direction' => 'ASC'
                    ))?>">По возрастанию</a><br><a href="<?php echo UrlHelper::getLink('/', array(
                        'sort' => 'email',
                        'direction' => 'DESC'
                    ))?>">По убыванию</a>
                </p>
            </div>
            <div class="col-md-5">
                <span>Описание задачи</span>
                <p>
                    <span>Сортировка</span><br>
                    <a href="<?php echo UrlHelper::getLink('/', array(
                        'sort' => 'description',
                        'direction' => 'ASC'
                    ))?>">По возрастанию</a><br><a href="<?php echo UrlHelper::getLink('/', array(
                        'sort' => 'description',
                        'direction' => 'DESC'
                    ))?>">По убыванию</a>
                </p>
            </div>
            <div class="col-md-2">
                <span>Статус</span>
            </div>
        </div>
        <?php if(is_array($posts) && !empty($posts)):?>
            <div class="articles">
                <?php foreach($posts as $post):?>
                    <article>
                        <div class="row">
                            <div class="col-md-2"><?php echo $post['name']?></div>
                            <div class="col-md-2"><?php echo $post['email']?></div>
                            <div class="col-md-5"><?php echo $post['description']?></div>
                            <div class="col-md-2"><?php echo ($post['status']) ? 'Выполнено' : 'Не выполнено'?></div>
                            <?php if($logged):?>
                                <div class="col-md-1"><a href="/edit-post/?id=<?php echo $post['id']?>">Ред.</a></div>
                            <?php endif;?>
                        </div>
                    </article>
                <?php endforeach;?>
            </div>
        <?php endif;?>
        <a href="/add-post/" class="btn btn-success">Добавить задачу</a>
        <a href="/user/login/" class="btn btn-success">Войти</a>
        <p aria-label="Page navigation example">
            <?php if(ceil($count/3) > 1):?>
                <ul class="pagination">
                    <?php for($i = 1; $i <= ceil($count/3); $i++):?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo UrlHelper::getLink('/', array('page' => $i))?>"><?php echo $i?></a>
                        </li>
                    <?php endfor;?>
                </ul>
            <?php endif;?>
        </p>
    </main>
</div>
<?php require 'footer.php'?>