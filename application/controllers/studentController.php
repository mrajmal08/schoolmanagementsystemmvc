<?php

class studentController extends Framework
{
    use Validation;
    use Student;
    protected $tableBody;
    protected $accountModel;
    protected $classModel;
    protected $subjectModel;
    protected $hasClassModel;
    protected $hasSubjectModel;

    /** initialize the constructor */
    public function __construct()
    {
        $this->helper('functions');
        $this->accountModel = $this->model('studentModel');
        $this->classModel = $this->model('classModel');
        $this->subjectModel = $this->model('subjectModel');
        $this->hasClassModel = $this->model('userHasClassModel');
        $this->hasSubjectModel = $this->model('userHasSubjectModel');
        $this->tableBody = $this->tableBody();
    }

    /** get default page of student with session */
    public function index()
    {
        $this->view('student', $this->tableBody);
    }

    /** create principal */
    public function createStudent()
    {
        $sessionRole = $this->getSession('role');
        if ($sessionRole == 1) {
            $status = 1;
        } else {
            $status = 0;
        }
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
                $this->view('student', $this->tableBody, $error);
            } else {
                $name = input('name');
                $email = input('email');
                $password = input('password');
                $address = input('address');
                $contact = input('contact');
                $gender = input('gender');
                $role = 4;
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
                    $this->view('student', $this->tableBody);
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
                $this->view('student', $this->tableBody, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateStudent()
    {
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitStudent']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['id'];
            unset($data['data']['id']);
            $result = $this->accountModel->update($data, $where);
            if ($result) {
                $this->view('student', $this->tableBody);
            }
        }
    }

    public function delete()
    {
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $this->accountModel->delete($where);
                $this->view('student', $this->tableBody);
            }
        }
    }

    public function assignClass()
    {
        if (!empty($_GET['id'])) {
            $user_id = $_GET['id'];
            $where = 'id =' . $user_id;
            $data = $this->accountModel->show(1, $where);
            $classes = $this->classModel->show();
            $user_id = $data['id'];
            $singleUserData = $this->accountModel->user_class_subject($user_id, 'class');
            $this->view('assignClass', $data, '', $classes, $singleUserData);
        }
    }

    public function assignSubject()
    {
        if (!empty($_GET['id'])) {
            $user_id = $_GET['id'];
            $where = 'id =' . $user_id;
            $data = $this->accountModel->show(1, $where);
            $classes = $this->subjectModel->show();
            $user_id = $data['id'];
            $singleUserData = $this->accountModel->user_class_subject($user_id, 'subject');
            $this->view('assignSubject', $data, '', $classes, $singleUserData);
        }
    }

    public function ClassAssignTo()
    {
        if (isset($_POST['submit'])) {
            if (isset($_POST['class_id'])) {
                $user_id = $_POST['user_id'];
                $class_id = $_POST['class_id'];
                $this->hasClassModel->assign_class_subject($user_id, $class_id);

                $where = 'id =' . $user_id;
                $data = $this->accountModel->show(1, $where);
                $classes = $this->classModel->show();
                $user_id = $data['id'];
                $singleUserData = $this->accountModel->user_class_subject($user_id, 'class');
                $this->view('assignClass', $data, '', $classes, $singleUserData);
            }
        }
    }

    public function SubjectAssignTo()
    {
        if (isset($_POST['submit'])) {
            if (isset($_POST['subject_id'])) {
                $user_id = $_POST['user_id'];
                $subject_id = $_POST['subject_id'];
                $this->hasSubjectModel->assign_class_subject($user_id, '', $subject_id);
                $where = 'id =' . $user_id;
                $data = $this->accountModel->show(1, $where);
                $classes = $this->subjectModel->show();
                $user_id = $data['id'];
                $singleUserData = $this->accountModel->user_class_subject($user_id, 'subject');
                $this->view('assignSubject', $data, '', $classes, $singleUserData);
            }
        }
    }

    public function unAssignClass()
    {
        if (isset($_GET['type']) && $_GET['type'] == 'un_assign') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['user_id'];
                $class_id = $_GET['id'];
                $where = "user_id = " . $user_id . " And class_id = " . $class_id;
                $this->hasClassModel->delete($where);
                $where = 'id =' . $user_id;
                $data = $this->accountModel->show(1, $where);
                $classes = $this->classModel->show();
                $user_id = $data['id'];
                $singleUserData = $this->accountModel->user_class_subject($user_id, 'class');
                $this->view('assignClass', $data, '', $classes, $singleUserData);

            }
        }
    }

    public function unAssignSubject()
    {
        if (isset($_GET['type']) && $_GET['type'] == 'un_assign') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['user_id'];
                $class_id = $_GET['id'];
                $where = "user_id = " . $user_id . " And subject_id = " . $class_id;
                $this->hasSubjectModel->delete($where);

                $where = 'id =' . $user_id;
                $data = $this->accountModel->show(1, $where);
                $classes = $this->subjectModel->show();
                $user_id = $data['id'];
                $singleUserData = $this->accountModel->user_class_subject($user_id, 'subject');
                $this->view('assignSubject', $data, '', $classes, $singleUserData);

            }
        }
    }

    /** table body function  */
    public function tableBody(){
        $where = "status = 1 AND role_id = 4";
        $tableBody = $this->accountModel->show(false, $where);
        return $tableBody;
    }

}