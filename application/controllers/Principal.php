<?php

class Principal extends Framework
{
    public function index()
    {
        /** get session */
        $userId = getSessionData();
        $tbody = $this->model('principalModel');
        $tbody = $tbody->getPrincipal();
        $this->view('principal', $userId, $tbody);
    }

    /** create principal */
    public function createPrincipal()
    {
        $userId = getSessionData();
        $create = $this->model('principalModel');
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
                $tbody = $create->getPrincipal();
                $this->view('principal', $userId, $tbody, $error);
            } else {
                $name = $this->input('name');
                $email = $this->input('email');
                $password = $this->input('password');
                $address = $this->input('address');
                $contact = $this->input('contact');
                $gender = $this->input('gender');
                $role = 2;
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
                $result = $create->insertPrincipal($columns, $values, $data);
                if ($result) {
                    $tbody = $create->getPrincipal();
                    $this->view('principal', $userId, $tbody);
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
        $edit = $this->model('principalModel');
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $user = $edit->editPrincipal($user_id);
                $body = $edit->getPrincipal();
                $this->view('principal', $userId, $body, '', $user);

            }
        }
    }

    /** Update principal */
    public function updatePrincipal()
    {
        $userId = getSessionData();
        $update = $this->model('principalModel');
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitPrincipal']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['id'];
            unset($data['data']['id']);
            $result = $update->updatePrincipal($data, $where);
            if ($result) {
                $body = $update->getPrincipal();
               $this->view('principal', $userId, $body);
            }
        }
    }

    /** delete principal */
    public function delete(){
        $userId = getSessionData();
        $delete = $this->model('principalModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $delete->deletePrincipal($where);
                $body = $delete->getPrincipal();
                $this->view('principal',$userId, $body);
            }
        }
    }
}