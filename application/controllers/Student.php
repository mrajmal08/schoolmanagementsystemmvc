<?php

class Student extends Framework
{

    public function index()
    {
        /** get session */
        $userId = getSessionData();
        $tbody = $this->model('studentModel');
        $tbody = $tbody->getStudent();
        $this->view('student', $userId, $tbody);
    }

    /** create principal */
    public function createStudent()
    {
        $userId = getSessionData();
        $create = $this->model('studentModel');
        if (isset($_POST['submitStudent'])) {
            $rules = [
                'name' => 'required|max:6',
                'email' => 'email|required',
                'password' => 'required|max:20|min:6'
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $tbody = $create->getStudent();
                $this->view('student', $userId, $tbody, $error);
            } else {
                $name = $this->input('name');
                $email = $this->input('email');
                $password = $this->input('password');
                $address = $this->input('address');
                $contact = $this->input('contact');
                $gender = $this->input('gender');
                $role = 4;
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
                $result = $create->insertStudent($columns, $values, $data);
                if ($result) {
                    $tbody = $create->getStudent();
                    $this->view('student', $userId, $tbody);
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
        $edit = $this->model('studentModel');
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $user = $edit->editStudent($user_id);
                $body = $edit->getStudent();
                $this->view('student', $userId, $body, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateStudent()
    {
        $userId = getSessionData();
        $update = $this->model('studentModel');
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitStudent']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['id'];
            unset($data['data']['id']);
            $result = $update->updateStudent($data, $where);
            if ($result) {
                $body = $update->getStudent();
                $this->view('student', $userId, $body);
            }
        }
    }

    public function delete()
    {
        $userId = getSessionData();
        $delete = $this->model('studentModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $delete->deleteStudent($where);
                $body = $delete->getStudent();
                $this->view('student', $userId, $body);
            }
        }
    }

    public function assignClass()
    {
        $userId = getSessionData();
        $Class = $this->model('studentModel');
        if (!empty($_GET['id'])) {
            $user_id = $_GET['id'];
            $where = 'id =' . $user_id;
            $data = $Class->getClass($where);
            $classes = $Class->getClassDropDown();
            $user_id = $data['id'];
            $singleUserData = $Class->singleUserDataClass($user_id);
            $this->view('assign_class', $userId, $data, '', $classes, $singleUserData);
        }
    }

    public function assignSubject()
    {
        $userId = getSessionData();
        $Subject = $this->model('studentModel');
        if (!empty($_GET['id'])) {
            $user_id = $_GET['id'];
            $where = 'id =' . $user_id;
            $data = $Subject->getClass($where);
            $classes = $Subject->getSubjectDropDown();
            $user_id = $data['id'];
            $singleUserData = $Subject->singleUserDataSubject($user_id);
            $this->view('assign_subject', $userId, $data, '', $classes, $singleUserData);
        }
    }

    public function ClassAssignTo()
    {
        $userId = getSessionData();
        $assignTo = $this->model('studentModel');
        if (isset($_POST['submit'])) {
            if (isset($_POST['class_id'])) {
                $user_id = $_POST['user_id'];
                $class_id = $_POST['class_id'];
                $assignTo->assignClassTo($user_id, $class_id);

                $where = 'id =' . $user_id;
                $data = $assignTo->getClass($where);
                $classes = $assignTo->getClassDropDown();
                $user_id = $data['id'];
                $singleUserData = $assignTo->singleUserDataClass($user_id);
                $this->view('assign_class', $userId, $data, '', $classes, $singleUserData);
            }
        }
    }

    public function SubjectAssignTo(){
        $userId = getSessionData();
        $assignTo = $this->model('studentModel');
        if (isset($_POST['submit'])) {
            if (isset($_POST['subject_id'])) {
                $user_id = $_POST['user_id'];
                $subject_id = $_POST['subject_id'];
                $assignTo->assignSubjectTo($user_id, $subject_id);
                $where = 'id =' . $user_id;
                $data = $assignTo->getClass($where);
                $classes = $assignTo->getSubjectDropDown();
                $user_id = $data['id'];
                $singleUserData = $assignTo->singleUserDataSubject($user_id);
                $this->view('assign_subject', $userId, $data, '', $classes, $singleUserData);
            }
        }

    }

    public function unAssignClass()
    {
        $userId = getSessionData();
        $unAssign = $this->model('studentModel');
        if (isset($_GET['type']) && $_GET['type'] == 'un_assign') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['user_id'];
                $class_id = $_GET['id'];
                $where = "user_id = " . $user_id . " And class_id = " . $class_id;
                $unAssign->un_assign_class($where);
                $where = 'id =' . $user_id;
                $data = $unAssign->getClass($where);
                $classes = $unAssign->getClassDropDown();
                $user_id = $data['id'];
                $singleUserData = $unAssign->singleUserDataClass($user_id);
                $this->view('assign_class', $userId, $data, '', $classes, $singleUserData);

            }
        }
    }

    public function unAssignSubject(){
        $userId = getSessionData();
        $unAssign = $this->model('studentModel');
        if (isset($_GET['type']) && $_GET['type'] == 'un_assign') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['user_id'];
                $class_id = $_GET['id'];
                $where = "user_id = " . $user_id . " And subject_id = " . $class_id;
                $unAssign->un_assign_subject($where);

                $where = 'id =' . $user_id;
                $data = $unAssign->getClass($where);
                $classes = $unAssign->getSubjectDropDown();
                $user_id = $data['id'];
                $singleUserData = $unAssign->singleUserDataSubject($user_id);
                $this->view('assign_subject', $userId, $data, '', $classes, $singleUserData);

            }
        }

    }

}