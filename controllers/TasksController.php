<?php

namespace controllers;

use components\Authorization;
use components\Controller;
use components\Request;
use models\Tasks;
use library\Task;

class TasksController extends Controller
{
    public function indexAction() {
        $model = new Tasks();

        $params = Request::getParams();
        $allowed_params = array('username', 'email', 'status');

        foreach ($allowed_params as $allowed_param) {
            if (in_array($allowed_param, array_keys($params))) {
                $this->view->tasks = $model->getAllWhere(
                    $allowed_param, urldecode($params[$allowed_param])
                );
            }
        }

        if (in_array('username', array_keys($params))) {
            $this->view->tasks = $model->getAllWhere('username', $params['username']);
        } elseif (in_array('email', array_keys($params))) {
            $this->view->tasks = $model->getAllWhere('email', $params['email']);
        } elseif (in_array('status', array_keys($params))) {
            $this->view->tasks = $model->getAllWhere('status', $params['status']);
        } else {
            $this->view->tasks = $model->getAll();
        }

        $this->view->page = 'index';

        $this->view->render();
    }

    public function newAction() {
        if (Request::isPost()) {
            $model = new Tasks();

            $params = Request::getParams();
            unset($params['id']); // prevent update
            $params['status'] = 0;

            $task = new Task($params);
            $this->view->task_id = $model->saveToDatabase($task);
            $this->view->task_added = 1;
        }

        $this->view->page = 'new';
        $this->view->render();
    }

    public function editAction() {
        if (!Authorization::isAdmin()) {
            $this->view->render('layout/403');
        } else {
            $model = new Tasks();
            if (Request::isPost()) {
                $params = Request::getParams();

                $task = new Task($params);
                $model->saveToDatabase($task);

                $this->view->task_edited = 1;
                $this->view->task_id = $task->getId();
            }

            $task_id = Request::getParam('id');

            $this->view->task = $model->getById($task_id);
            $this->view->page = 'edit';

            $this->view->render();
        }
    }

    public function singleAction() {
        $model = new Tasks();
        $task_id = Request::getParam('id');

        $this->view->task = $model->getById($task_id);
        $this->view->page = 'single';

        $this->view->render();
    }
}