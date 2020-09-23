<?php

class userController extends Framework
{
    use Validation;
    protected $sessionId;

    /** initialize the constructor */
    public function __construct()
    {
        $this->sessionId = getSessionData();
    }

    /**  default index page  **/
    public function index()
    {
        $this->view('welcome');
    }

    /**  Request register page **/
    public function register()
    {
        $data = $this->model('roleModel');
        $data = $data->show();
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
                $result = $registerData->insert($columns, $values, $data);
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
        $email = input('email');
        $password = input('password');
        $result = $loginUser->login_user($email, $password);
//        var_dump($result); exit;

        if ($result == true) {
            $userId = [
                $_SESSION['sess_user_id'],
                $_SESSION['sess_name'],
                $_SESSION['role']
            ];
            $this->view('home', $userId);
        } else {
            $this->view('login');
            return 'Invalid email or password';
        }
    }

    /**  destroy session   **/
    public function logout()
    {
        $this->sessionId = '';
        if (empty($this->sessionId)) {
            $this->view('welcome');
        }
    }

    /**  Home page with session values  **/
    public function home()
    {
        $this->view('home', $this->sessionId);
    }

    /** get requested users*/
    public function requestedUser()
    {
        $data = $this->model('userModel');
        $data = $data->fetch_requested_data();
        $this->view('requestedData', $this->sessionId, $data);
    }

    /** approve requested user*/
    public function approveUser()
    {
        $approve = $this->model('userModel');
        if (isset($_GET['type']) && $_GET['type'] == 'approve') {
            $user_id = $_GET['id'];
            $approve->approve_req($user_id);
            $data = $approve->fetch_requested_data();
            $this->view('requested_data', $this->sessionId, $data);
        } else {
            $data = $approve->fetch_requested_data();
            $this->view('requestedData', $this->sessionId, $data);
        }
    }

    /** un Approve requested user*/
    public function unApproveUser()
    {
        $approve = $this->model('userModel');
        if (isset($_GET['type']) && $_GET['type'] == 'un_approve') {
            $user_id = $_GET['id'];
            $where = "id = " . $user_id;
            $approve->delete($where);
            $data = $approve->fetch_requested_data();
            $this->view('requestedData', $this->sessionId, $data);
        }else{
            $data = $approve->fetch_requested_data();
            $this->view('requestedData', $this->sessionId, $data);
        }
    }

}