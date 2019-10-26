<?php


namespace app\Controllers;


use app\Core\Contoller;
use app\Models\PostModel;
use app\Models\UserModel;

class MainController extends Contoller
{

    private $logged;

    public function __construct()
    {
        $user = new UserModel();
        $this->logged = $user->hasLogged();

        parent::__construct();
    }

    public function index()
    {
        $model = new PostModel();

        $model->setValidationList(
            [
                'offset'=>[
                    'sanitize' => 'int',
                ],
                'page'=>[
                    'sanitize' => 'int',
                ],
                'sort'=>[
                    'sanitize' => 'sort'
                ],
                'direction'=>[
                    'sanitize' => 'direction'
                ],
            ]
        );

        $data = array();

        if(isset($_GET['page'])) {
            $data['offset'] = ($_GET['page'] - 1) * 3;
        }


        if(isset($_GET['sort']) && isset($_GET['direction'])) {
            $data['sort'] = $_GET['sort'];
            $data['direction'] = $_GET['direction'];

            if($model->load($data) && $model->validate()){
                $data = $model->getAllPostsBySort();
            }
        }else {
            if(!isset($data['offset'])) {
                $data['offset'] = 0;
            }
            if($model->load($data) && $model->validate()){
                $data = $model->getAllPosts();
            }
        }

        $countPosts = $model->getAllPostsCount();

        return $this->view->render('index', ['posts' => $data, 'count' => $countPosts, 'logged' => $this->logged]);
    }

    public function addPost()
    {
        return $this->view->render('add-post');
    }

    public function editPost()
    {
        if(!$this->logged || !isset($_GET['id'])) {
            return $this->redirect('');
        }

        $model = new PostModel();
        $model->setValidationList(
            [
                'id'=>[
                    'sanitize' => 'int',
                    'rule' => ['required'],
                ]
            ]
        );
        $data['id'] = $_GET['id'];

        if($model->load($data) && $model->validate()){
            $viewData = $model->getPostById();
            return $this->view->render('edit-post', $viewData);
        }

        return $this->redirect('');
    }

    public function save()
    {
        if (!empty($_POST)) {
            $model = new PostModel();
            $model->setValidationList(
                [
                    'name'=>[
                        'sanitize' => 'string',
                        'rule' => ['required'],
                        'error_msg' => 'Имя обязательно'
                    ],
                    'email'=>[
                        'sanitize' => 'email',
                        'rule' => ['email','required'],
                        'error_msg' => 'Неправильный email'
                    ],
                    'id'=>[
                        'sanitize' => 'int',
                    ],
                    'status'=>[
                        'sanitize' => 'int',
                    ],
                    'description'=>[
                        'sanitize' => 'string',
                        'rule' => ['required'],
                        'error_msg' => 'Описание задачи обязательно'
                    ],
                    'created_at'=>[
                        'created_at' => 'string',
                    ],
                    'updated_at'=>[
                        'created_at' => 'string',
                    ]
                ]
            );
            $errors = array();

            if(isset($_POST['id'])) {
                if(!$this->logged) {
                    return $this->redirect('');
                }

                $data = [
                    'description' => $_POST['description'],
                    'updated_at' => date('y-m-d h:i:s'),
                    'status' => isset($_POST['status']) ? 1 : 0,
                    'id' => (int)$_POST['id']
                ];



                if($model->load($data) && $model->validate($errors)){
                    $model->update($data);
                }

                if(!empty($errors)) return $this->view->json($errors);

            }else {
                $date = [
                    'created_at' => date('y-m-d h:i:s'),
                    'updated_at' => date('y-m-d h:i:s')
                ];

                $data = array_merge($_POST,$date);

                if($model->load($data) && $model->validate($errors)){
                    $model->save($data);
                }

                if(!empty($errors)) return $this->view->json($errors);
            }
            return $this->view->json(['status'=>'ok']);
        }

        return $this->redirect('add-post/');
    }
}