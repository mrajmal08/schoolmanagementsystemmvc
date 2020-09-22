<?php

class classController extends Framework
{
    public function index()
    {
        /** get session */
        $userId = getSessionData();
        $tbody = $this->model('classModel');
        $tbody = $tbody->getClass();
        $this->view('classes', $userId, $tbody);
    }

    /** create principal */
    public function createClass()
    {
        $userId = getSessionData();
        $create = $this->model('classModel');
        if (isset($_POST['submitClass'])) {
            $rules = [
                'name' => 'required|max:12',
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $tbody = $create->getClass();
                $this->view('classes', $userId, $tbody, $error);
            } else {
                $name = $_POST['name'];
                $number = $_POST['number'];
                $data = [
                    'name' => $name,
                    'number' => $number,
                ];
                $columns = ['name', 'number'];
                $values = [':name', ':number'];
                $result = $create->insertClass($columns, $values, $data);
                if ($result){
                    $tbody = $create->getClass();
                    $this->view('classes',$userId, $tbody);
                }else{
                    return "Something problem";
                }
            }
        }
    }

    /** edit get user id principal */
    public function edit()
    {
        $userId = getSessionData();
        $edit = $this->model('classModel');
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $user = $edit->editClass($user_id);
                $body = $edit->getClass();
                $this->view('classes', $userId, $body, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateClass()
    {
        $userId = getSessionData();
        $update = $this->model('classModel');
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitClass']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['class_id'];
            unset($data['data']['class_id']);
            $result = $update->updateClass($data, $where);
            if ($result) {
                $body = $update->getClass();
                $this->view('classes', $userId, $body);
            }
        }
    }

    /** delete principal */
    public function delete()
    {
        $userId = getSessionData();
        $delete = $this->model('classModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = ". $user_id;
                $delete->deleteClass($where);
                $body = $delete->getClass();
                $this->view('classes', $userId, $body);
            }
        }
    }
}