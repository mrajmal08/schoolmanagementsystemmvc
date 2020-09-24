<?php

class principalController extends Framework
{
    use Validation;
    protected $tbody;
    protected $accountModel;

    /** initialize the constructor */
    public function __construct()
    {
        $this->helper('functions');
        $this->accountModel = $this->model('principalModel');
        $this->tbody = $this->tableBody();
    }

    /** getting default page of principal with data and session */
    public function index()
    {
        $this->view('principal', $this->tbody);
    }

    /** create principal */
    public function createPrincipal()
    {
        $sessionRole = $this->getSession('role');
        if ($sessionRole == 1) {
            $status = 1;
        } else {
            $status = 0;
        }
        if (isset($_POST['submitPrincipal'])) {
            $rules = [
                'name' => 'required|max:6',
                'email' => 'email|required',
                'password' => 'required|max:20|min:6'
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $this->view('principal', $this->tbody, $error);
            } else {
                $name = input('name');
                $email = input('email');
                $password = input('password');
                $address = input('address');
                $contact = input('contact');
                $gender = input('gender');
                $role = 2;
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
                    $this->view('principal', $this->tbody);
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
                $user = $this->accountModel-> show(1, $where);
                $this->view('principal', $this->tbody, '', $user);

            }
        }
    }

    /** Update principal */
    public function updatePrincipal()
    {
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitPrincipal']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['id'];
            unset($data['data']['id']);
            $result = $this->accountModel->update($data, $where);
            if ($result) {
               $this->view('principal', $this->tbody);
            }
        }
    }

    /** delete principal */
    public function delete(){
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $this->accountModel->delete($where);
                $this->view('principal', $this->tbody);
            }
        }
    }

    /** table body function  */
    public function tableBody(){
        $where = "status = 1 AND role_id = 2";
        $tableBody = $this->accountModel->show(false, $where);
        return $tableBody;
    }
}