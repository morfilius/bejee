<?php


namespace app\Controllers;


use app\Core\Contoller;
use app\Models\UserModel;

class UserController extends Contoller
{
    public function login()
    {
        if(isset($_POST['login']) || isset($_POST['password'])) {
            $model = new UserModel();
            $model->setValidationList(
                [
                    'login'=>[
                        'sanitize' => 'string',
                        'rule' => ['required'],
                        'error_msg' => 'Обязательное поле Логин'
                    ],
                    'password'=>[
                        'sanitize' => 'string',
                        'rule' => ['required'],
                        'error_msg' => 'Обязательное поле Пароль'
                    ]
                ]
            );

            $data['login'] = $_POST['login'];
            $data['password'] = $_POST['password'];

            $errors = array();

            if($model->load($data) && $model->validate($errors)){
                if(!$model->login()){
                    return $this->view->json([
                        'status'=> 'error',
                        'fields' => [
                            'login' => 'Неправильные логин или пароль',
                            'password' => 'Неправильные логин или пароль'
                        ]
                    ]);
                }

            }

            if(!empty($errors)) return $this->view->json($errors);
        }

        return $this->view->render('user/login');
    }
}