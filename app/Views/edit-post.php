<?php require 'header.php'?>
    <div class="container">
        <main>
            <h1>Редактировать задачу</h1>
            <form method="post" action="/save/">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input disabled type="text" name="email" value="<?php echo $email?>" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input disabled type="text" name="name" value="<?php echo $name?>" class="form-control" id="name" placeholder="Имя">
                </div>
                <div class="form-group">
                    <label for="desc">Описание задачи</label>
                    <textarea class="form-control" name="description" id="desc" rows="4"><?php echo $description?></textarea>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" <?php echo ($status)? 'checked':''?> type="checkbox" name="status" value="1" id="status">
                        <label class="form-check-label" for="status">
                            Выполнено
                        </label>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $id?>">
                <input class="btn btn-success" type="submit" value="Сохранить">
            </form>
        </main>
    </div>
<?php require 'footer.php'?>