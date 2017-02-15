<?php

namespace controllers;

use components\Authorization;
use components\Controller;
use components\Request;
use components\Uploader;
use library\Task;
use models\Users;

class AjaxController extends Controller
{
    public function previewAction() {
        $params = Request::getParams();
        if ($params) {
            $this->view->page = 'preview';
            $this->view->task = new Task($params);
            $this->view->render('_partials/task', true);
        } else {
            echo 'Произошла ошибка :(';
        }
    }

    public function loginAction() {
        $params = Request::getParams();

        $response = (object) array(
            'status' => 1,
            'statuses' => (object) array(
                'ok' => 0,
                'error' => 1
            )
        );

        if (!empty($params['username']) && !empty($params['password'])) {
            $users_model = new Users();
            $user = $users_model->getUserByUserName($params['username']);

            if ($user && $user->getPassword() == $params['password']) {
                Authorization::logIn($user->getUsername());
                $response->status = $response->statuses->ok;
            }
        }

        echo json_encode($response);
    }

    public function logoutAction() {
        Authorization::logOut();
    }

    public function uploadAction() {
        $image = Uploader::saveImage();

        $response = (object) array(
            'status' => 1,
            'statuses' => (object) array(
                'ok' => 0,
                'error' => 1
            )
        );

        if ($image) {
            $response->status = $response->statuses->ok;
            $response->image = $image;
        }

        echo json_encode($response);
    }
}