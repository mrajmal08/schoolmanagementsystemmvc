<?php

class subjectController extends Framework
{
    public function index()
    {
        /** get session */
        $userId = getSessionData();
        $tbody = $this->model('subjectModel');
        $tbody = $tbody->getSubject();
        $this->view('subjects', $userId, $tbody);
    }

    /** create principal */
    public function createSubject()
    {
        $userId = getSessionData();
        $create = $this->model('subjectModel');
        if (isset($_POST['submitSubject'])) {
            $rules = [
                'name' => 'required|max:12',
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $tbody = $create->getSubject();
                $this->view('subjects', $userId, $tbody, $error);
            } else {
                $name = $_POST['name'];
                $author = $_POST['author'];
                $data = [
                    'name' => $name,
                    'author' => $author,
                ];
                $columns = ['name', 'author'];
                $values = [':name', ':author'];
                $result = $create->insertSubject($columns, $values, $data);
                if ($result){
                    $tbody = $create->getSubject();
                    $this->view('subjects',$userId, $tbody);
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
        $edit = $this->model('subjectModel');
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $user = $edit->editSubject($user_id);
                $body = $edit->getSubject();
                $this->view('subjects', $userId, $body, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateSubject()
    {
        $userId = getSessionData();
        $update = $this->model('subjectModel');
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitSubject']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['subject_id'];
            unset($data['data']['subject_id']);
            $result = $update->updateSubject($data, $where);
            if ($result) {
                $body = $update->getSubject();
                $this->view('subjects', $userId, $body);
            }
        }
    }

    /** delete principal */
    public function delete()
    {
        $userId = getSessionData();
        $delete = $this->model('subjectModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = ". $user_id;
                $delete->deleteSubject($where);
                $body = $delete->getSubject();
                $this->view('subjects', $userId, $body);
            }
        }
    }
}