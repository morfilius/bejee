<?php require __DIR__.'/../header.php'?>
    <div class="container">
        <main>
            <h1>Войти</h1>
            <form method="post" action="/user/login/">
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" name="login" value="" class="form-control" id="login" placeholder="Логин">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="text" name="password" value="" class="form-control" id="password" placeholder="Пароль">
                </div>
                <input class="btn btn-success" type="submit" value="Войти">
            </form>
        </main>
    </div>
<?php require __DIR__.'/../footer.php'?>