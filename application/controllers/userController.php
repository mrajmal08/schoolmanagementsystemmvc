<?php

class userController extends Framework
{
    public $userId;

    /**  default index page  **/
    public function index()
    {
        $this->view('welcomeView');
    }

    /**  Request register page **/
    public function register()
    {

        $data = $this->model('userModel');
        $data = $data->getData();

        $this->view('register', $data);
    }

    /**  Register user  **/
    public function signUp()
    {
        $registerData = $this->model('userModel');

        if (isset($_POST['submitForm'])) {
            $rules = [
                'name' => 'required|max:6',
                'email' => 'email|required',
                'password' => 'required|max:20|min:6'
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $this->view('register', $error);
            } else {
                $name = $this->input('name');
                $email = $this->input('email');
                $password = $this->input('password');
                $address = $this->input('address');
                $contact = $this->input('contact');
                $gender = $this->input('gender');
                $role = $this->input('role');
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
                $result = $registerData->insertData($columns, $values, $data);
                if ($result) {
                    $this->view('login');
                } else {
                    return "Some thing problem during form submission";
                }
            }
        }
    }

    /**  Reguest login page  **/
    public function login()
    {
        $this->view('login');
    }

    /**  Login user  **/
    public function loginUser()
    {

        $loginUser = $this->model('userModel');
        $email = $this->input('email');
        $password = $this->input('password');
        $result = $loginUser->login($email, $password);

        if ($result) {
            $userId = [
                $_SESSION['sess_user_id'],
                $_SESSION['sess_name'],
                $_SESSION['role']
            ];
            $this->view('home', $userId);
        } else {
            return 'Something problem';
        }
    }

    /**  destroy session   **/
    public function logout(){
        $_SESSION['sess_user_id'] = "";
        $_SESSION['sess_name'] = "";
        if (empty($_SESSION['sess_user_id']))
        $this->view('welcomeView');
    }

    /**  Home page with session values  **/
    public function home()
    {
        $userId = getSessionData();
        $this->view('home', $userId);
    }

}