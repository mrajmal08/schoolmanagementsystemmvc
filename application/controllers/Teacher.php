<?php

class Teacher extends Framework{

    public function index()
    {
        /** get session */
        $userId = getSessionData();
        $tbody = $this->model('teacherModel');
        $tbody = $tbody->getTeacher();
        $this->view('teacher', $userId, $tbody);
    }

    /** create principal */
    public function createTeacher()
    {
        $userId = getSessionData();
        $create = $this->model('teacherModel');
        if (isset($_POST['submitTeacher'])) {
            $rules = [
                'name' => 'required|max:6',
                'email' => 'email|required',
                'password' => 'required|max:20|min:6'
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $tbody = $create->getTeacher();
                $this->view('teacher', $userId, $tbody, $error);
            } else {
                $name = $this->input('name');
                $email = $this->input('email');
                $password = $this->input('password');
                $address = $this->input('address');
                $contact = $this->input('contact');
                $gender = $this->input('gender');
                $role = 3;
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'address' => $address,
                    'contact' => $contact,
                    'gender' => $gender,
                    'role' => $role,

                ];
                $columns = ['name', 'email', 'password', 'address',
                    'contact', 'gender', 'role_id'];
                $values = [':name', ':email', ':password', ':address',
                    ':contact', ':gender', ':role'];
                $result = $create->insertTeacher($columns, $values, $data);
                if ($result) {
                    $tbody = $create->getTeacher();
                    $this->view('teacher', $userId, $tbody);
                } else {
                    return "Some thing problem during form submission";
                }
            }
        }
    }

    /** edit get user id principal */
    public function edit()
    {
        $userId = getSessionData();
        $edit = $this->model('teacherModel');
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $user = $edit->editTeacher($user_id);
                $body = $edit->getTeacher();
                $this->view('teacher', $userId, $body, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateTeacher()
    {
        $userId = getSessionData();
        $update = $this->model('teacherModel');
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitTeacher']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['id'];
            unset($data['data']['id']);
            $result = $update->updateTeacher($data, $where);
            if ($result) {
                $body = $update->getTeacher();
                $this->view('teacher', $userId, $body);
            }
        }
    }

    public function delete(){
        $userId = getSessionData();
        $delete = $this->model('teacherModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $delete->deleteTeacher($where);
                $body = $delete->getTeacher();
                $this->view('teacher',$userId, $body);
            }
        }
    }

}