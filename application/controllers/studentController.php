<?php

class studentController extends Framework
{
    use Validation;
    use Student;
    protected $sessionId;
    protected $tableBody;

    /** initialize the constructor */
    public function __construct()
    {
        $this->sessionId = getSessionData();
        $this->tableBody = $this->model('studentModel');
        $where = "status = 1 AND role_id = 4";
        $this->tableBody = $this->tableBody->show(false, $where);
    }

    /** get default page of student with session */
    public function index()
    {
        $this->view('student', $this->sessionId, $this->tableBody);
    }

    /** create principal */
    public function createStudent()
    {
        $create = $this->model('studentModel');
        $sessionRole = $this->sessionId[2];
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
                $this->view('student', $this->sessionId, $this->tableBody, $error);
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
                $result = $create->insert($columns, $values, $data);
                if ($result) {
                    $this->view('student', $this->sessionId, $this->tableBody);
                } else {
                    return "Some thing problem during form submission";
                }
            }
        }
    }

    /** edit get user id principal */
    public function edit()
    {
        $edit = $this->model('studentModel');
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = 'id =' . $user_id;
                $user = $edit->show(1, $where);
                $this->view('student', $this->sessionId, $this->tableBody, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateStudent()
    {
        $update = $this->model('studentModel');
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitStudent']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['id'];
            unset($data['data']['id']);
            $result = $update->update($data, $where);
            if ($result) {
                $this->view('student', $this->sessionId, $this->tableBody);
            }
        }
    }

    public function delete()
    {
        $delete = $this->model('studentModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $delete->delete($where);
                $this->view('student', $this->sessionId, $this->tableBody);
            }
        }
    }

    public function assignClass()
    {
        $Class = $this->model('studentModel');
        $getClass = $this->model('classModel');
        if (!empty($_GET['id'])) {
            $user_id = $_GET['id'];
            $where = 'id =' . $user_id;
            $data = $Class->show(1, $where);
            $classes = $getClass->show();
            $user_id = $data['id'];
            $singleUserData = $Class->user_class_subject($user_id, 'class');
            $this->view('assignClass', $this->sessionId, $data, '', $classes, $singleUserData);
        }
    }

    public function assignSubject()
    {
        $Subject = $this->model('studentModel');
        $getSubject = $this->model('subjectModel');
        if (!empty($_GET['id'])) {
            $user_id = $_GET['id'];
            $where = 'id =' . $user_id;
            $data = $Subject->show(1, $where);
            $classes = $getSubject->show();
            $user_id = $data['id'];
            $singleUserData = $Subject->user_class_subject($user_id, 'subject');
            $this->view('assignSubject', $this->sessionId, $data, '', $classes, $singleUserData);
        }
    }

    public function ClassAssignTo()
    {
        $assignTo = $this->model('studentModel');
        $getClass = $this->model('classModel');
        $assignClass = $this->model('userHasClassModel');
        if (isset($_POST['submit'])) {
            if (isset($_POST['class_id'])) {
                $user_id = $_POST['user_id'];
                $class_id = $_POST['class_id'];
                $assignClass->assign_class_subject($user_id, $class_id);

                $where = 'id =' . $user_id;
                $data = $assignTo->show(1, $where);
                $classes = $getClass->show();
                $user_id = $data['id'];
                $singleUserData = $assignTo->user_class_subject($user_id, 'class');
                $this->view('assignClass', $this->sessionId, $data, '', $classes, $singleUserData);
            }
        }
    }

    public function SubjectAssignTo()
    {
        $assignTo = $this->model('studentModel');
        $getSubject = $this->model('subjectModel');
        $assignSubject = $this->model('userHasSubjectModel');
        if (isset($_POST['submit'])) {
            if (isset($_POST['subject_id'])) {
                $user_id = $_POST['user_id'];
                $subject_id = $_POST['subject_id'];
                $assignSubject->assign_class_subject($user_id, '', $subject_id);
                $where = 'id =' . $user_id;
                $data = $assignTo->show(1, $where);
                $classes = $getSubject->show();
                $user_id = $data['id'];
                $singleUserData = $assignTo->user_class_subject($user_id, 'subject');
                $this->view('assignSubject', $this->sessionId, $data, '', $classes, $singleUserData);
            }
        }
    }

    public function unAssignClass()
    {
        $unAssign = $this->model('studentModel');
        $getClass = $this->model('classModel');
        $unAssignClass = $this->model('userHasClassModel');
        if (isset($_GET['type']) && $_GET['type'] == 'un_assign') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['user_id'];
                $class_id = $_GET['id'];
                $where = "user_id = " . $user_id . " And class_id = " . $class_id;
                $unAssignClass->delete($where);
                $where = 'id =' . $user_id;
                $data = $unAssign->show(1, $where);
                $classes = $getClass->show();
                $user_id = $data['id'];
                $singleUserData = $unAssign->user_class_subject($user_id, 'class');
                $this->view('assignClass', $this->sessionId, $data, '', $classes, $singleUserData);

            }
        }
    }

    public function unAssignSubject()
    {
        $unAssign = $this->model('studentModel');
        $getSubject = $this->model('subjectModel');
        $unAssignSubject = $this->model('userHasSubjectModel');
        if (isset($_GET['type']) && $_GET['type'] == 'un_assign') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['user_id'];
                $class_id = $_GET['id'];
                $where = "user_id = " . $user_id . " And subject_id = " . $class_id;
                $unAssignSubject->delete($where);

                $where = 'id =' . $user_id;
                $data = $unAssign->show(1, $where);
                $classes = $getSubject->show();
                $user_id = $data['id'];
                $singleUserData = $unAssign->user_class_subject($user_id, 'subject');
                $this->view('assignSubject', $this->sessionId, $data, '', $classes, $singleUserData);

            }
        }

    }

}