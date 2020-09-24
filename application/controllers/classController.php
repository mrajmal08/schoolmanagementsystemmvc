<?php

class classController extends Framework
{
    use Validation;
    use Student;
    protected $tableBody;
    protected $accountModel;

    public function __construct()
    {
        $this->helper('functions');
        $this->accountModel = $this->model('classModel');
        $this->tableBody = $this->accountModel->show();
    }
    public function index()
    {
        $this->view('classes', $this->tableBody);
    }

    /** create principal */
    public function createClass()
    {
        if (isset($_POST['submitClass'])) {
            $rules = [
                'name' => 'required|max:12',
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $this->view('classes', $this->tableBody, $error);
            } else {
                $name = input('name');
                $number = input('number');
                $data = [
                    'name' => $name,
                    'number' => $number,
                ];
                $columns = ['name', 'number'];
                $values = [':name', ':number'];
                $result = $this->accountModel->insert($columns, $values, $data);
                if ($result) {
                    $this->view('classes', $this->tableBody);
                } else {
                    return "Something problem";
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
                $this->view('classes', $this->tableBody, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateClass()
    {
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitClass']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['class_id'];
            unset($data['data']['class_id']);
            $result = $this->accountModel->update($data, $where);
            if ($result) {
                $this->view('classes', $this->tableBody);
            }
        }
    }

    /** delete principal */
    public function delete()
    {
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $this->accountModel->delete($where);
                $this->view('classes', $this->tableBody);
            }
        }
    }

    /** get all the related classes*/
    public function myClass()
    {
        $getClasses = $this->accountModel->user_class_subject($this->getSession('id'), 'class');
        $this->view('myClasses', $getClasses);
    }
}