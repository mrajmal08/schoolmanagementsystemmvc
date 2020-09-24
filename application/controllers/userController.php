<?php

class userController extends Framework
{
    use Validation;
    protected $accountModel;
    protected $roleModel;

    /** initializing constructor */
    public function __construct()
    {
        $this->helper('functions');
        $this->accountModel = $this->model('userModel');
        $this->roleModel = $this->model('roleModel');
    }

    /**  default index page  **/
    public function index()
    {
        $this->view('welcome');
    }

    /**  Request register page **/
    public function register()
    {
        $data = $this->roleModel->show();
        $this->view('register', $data);
    }

    /**  Register user  **/
    public function signUp()
    {
        if (isset($_POST['submitForm'])) {
            $rules = [
                'name' => 'required|max:12',
                'email' => 'email|required',
                'password' => 'required|max:20|min:6'
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $this->view('register', $error);
            } else {
                $name = input('name');
                $email = input('email');
                $password = input('password');
                $address = input('address');
                $contact = input('contact');
                $gender = input('gender');
                $role = input('role');
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
                $result = $this->accountModel->insert($columns, $values, $data);
                if ($result) {
                    $this->redirect('userController/login');
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
        $email = input('email');
        $password = input('password');
        $result = $this->accountModel->login_user($email, $password);
        if ($result == true) {
            $this->setSession('id', $_SESSION['sess_user_id']);
            $this->setSession('name', $_SESSION['sess_name']);
            $this->setSession('role', $_SESSION['role']);
            $this->view('home');
        } else {
            $this->view('login');
            return 'Invalid email or password';
        }
    }

    /**  destroy session   **/
    public function logout()
    {
        $this->destroy();
        $this->view('welcome');

    }

    /**  Home page with session values  **/
    public function home()
    {
        $this->view('home');
    }

    /** get requested users*/
    public function requestedUser()
    {
        $data = $this->accountModel->fetch_requested_data();
        $this->view('requestedData', $data);
    }

    /** approve requested user*/
    public function approveUser()
    {
        if (isset($_GET['type']) && $_GET['type'] == 'approve') {
            $user_id = $_GET['id'];
            $this->accountModel->approve_req($user_id);
            $data = $this->accountModel->fetch_requested_data();
            $this->view('requestedData', $data);
        } else {
            $data = $this->accountModel->fetch_requested_data();
            $this->view('requestedData', $data);
        }
    }

    /** un Approve requested user*/
    public function unApproveUser()
    {
        if (isset($_GET['type']) && $_GET['type'] == 'un_approve') {
            $user_id = $_GET['id'];
            $where = "id = " . $user_id;
            $this->accountModel->delete($where);
            $data = $this->accountModel->fetch_requested_data();
            $this->view('requestedData', $data);
        }else{
            $data = $this->accountModel->fetch_requested_data();
            $this->view('requestedData', $data);
        }
    }

}