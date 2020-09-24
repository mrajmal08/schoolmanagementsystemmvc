<?php

class teacherController extends Framework
{
    use Validation;
    protected $tableBody;
    protected $accountModel;

    /** initialize the constructor */
    public function __construct()
    {
        $this->helper('functions');
        $this->accountModel = $this->model('teacherModel');
        $this->tableBody = $this->tableBody();
    }

    /** load default method with session and all teachers */
    public function index()
    {
        $this->view('teacher', $this->tableBody);
    }

    /** create principal */
    public function createTeacher()
    {
        $sessionRole = $this->getSession('role');
        if ($sessionRole == 1) {
            $status = 1;
        } else {
            $status = 0;
        }
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
                $this->view('teacher', $this->tableBody, $error);
            } else {
                $name = input('name');
                $email = input('email');
                $password = input('password');
                $address = input('address');
                $contact = input('contact');
                $gender = input('gender');
                $role = 3;
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'address' => $address,
                    'contact' => $contact,
                    'gender' => $gender,
                    'role' => $role,
                    'status' => $status
                ];
                $columns = ['name', 'email', 'password', 'address',
                    'contact', 'gender', 'role_id', 'status'];
                $values = [':name', ':email', ':password', ':address',
                    ':contact', ':gender', ':role', ':status'];
                $result = $this->accountModel->insert($columns, $values, $data);
                if ($result) {
                    $this->view('teacher', $this->tableBody);
                } else {
                    return "Some thing problem during form submission";
                }
            }
        }
    }

    /** edit get user id principal */
    public function edit()
    {
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = 'id =' . $user_id;
                $user = $this->accountModel->show(1, $where);
                $this->view('teacher', $this->tableBody, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateTeacher()
    {
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitTeacher']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['id'];
            unset($data['data']['id']);
            $result = $this->accountModel->update($data, $where);
            if ($result) {
                $this->view('teacher', $this->tableBody);
            }
        }
    }

    public function delete()
    {
        $delete = $this->model('teacherModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $this->accountModel->delete($where);
                $this->view('teacher', $this->tableBody);
            }
        }
    }

    /** table body function  */
    public function tableBody()
    {
        $where = "status = 1 AND role_id = 3";
        $tableBody = $this->accountModel->show(false, $where);
        return $tableBody;
    }

}