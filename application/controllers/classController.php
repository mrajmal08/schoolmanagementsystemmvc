<?php

class classController extends Framework
{
    use Validation;
    use Student;
    protected $sessionId;
    protected $tableBody;

    public function __construct()
    {
        $this->sessionId = getSessionData();
        $this->tableBody = $this->model('classModel');
        $this->tableBody = $this->tableBody->show();
    }
    public function index()
    {
        $this->view('classes', $this->sessionId, $this->tableBody);
    }

    /** create principal */
    public function createClass()
    {
        $create = $this->model('classModel');
        if (isset($_POST['submitClass'])) {
            $rules = [
                'name' => 'required|max:12',
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $this->view('classes', $this->sessionId, $this->tableBody, $error);
            } else {
                $name = input('name');
                $number = input('number');
                $data = [
                    'name' => $name,
                    'number' => $number,
                ];
                $columns = ['name', 'number'];
                $values = [':name', ':number'];
                $result = $create->insert($columns, $values, $data);
                if ($result) {
                    $this->view('classes', $this->sessionId, $this->tableBody);
                } else {
                    return "Something problem";
                }
            }
        }
    }

    /** edit get user id principal */
    public function edit()
    {
        $edit = $this->model('classModel');
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = 'id =' . $user_id;
                $user = $edit->show(1, $where);
                $this->view('classes', $this->sessionId, $this->tableBody, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateClass()
    {
        $update = $this->model('classModel');
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitClass']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['class_id'];
            unset($data['data']['class_id']);
            $result = $update->update($data, $where);
            if ($result) {
                $this->view('classes', $this->sessionId, $this->tableBody);
            }
        }
    }

    /** delete principal */
    public function delete()
    {
        $delete = $this->model('classModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $delete->delete($where);
                $this->view('classes', $this->sessionId, $this->tableBody);
            }
        }
    }

    /** get all the related classes*/
    public function myClass()
    {
        $class = $this->model('classModel');
        $getClasses = $class->user_class_subject($this->sessionId[0], 'class');
        $this->view('myClasses', $this->sessionId, $getClasses);
    }
}