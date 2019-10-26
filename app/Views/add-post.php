<?php require 'header.php'?>
    <div class="container">
        <main>
            <h1>Создать задачу</h1>
            <form method="post" action="/save/">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Имя">
                </div>
                <div class="form-group">
                    <label for="desc">Описание задачи</label>
                    <textarea class="form-control" name="description" id="desc" rows="4"></textarea>
                </div>
                <input class="btn btn-success" type="submit" value="Сохранить">
            </form>
        </main>
    </div>
<?php require 'footer.php'?>