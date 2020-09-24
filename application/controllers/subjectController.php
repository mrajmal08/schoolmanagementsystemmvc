<?php

class subjectController extends Framework
{
    use Validation;
    use Student;
    protected $tableBody;
    protected $accountModel;

    /** initialize the constructor */
    public function __construct()
    {
        $this->helper('functions');
        $this->accountModel = $this->model('subjectModel');
        $this->tableBody = $this->accountModel->show();
    }

    public function index()
    {
        $this->view('subjects', $this->tableBody);
    }

    /** create principal */
    public function createSubject()
    {
        if (isset($_POST['submitSubject'])) {
            $rules = [
                'name' => 'required|max:12',
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $this->view('subjects', $this->tableBody, $error);
            } else {
                $name = input('name');
                $author = input('author');
                $data = [
                    'name' => $name,
                    'author' => $author,
                ];
                $columns = ['name', 'author'];
                $values = [':name', ':author'];
                $result = $this->accountModel->insert($columns, $values, $data);
                if ($result) {
                    $this->view('subjects', $this->tableBody);
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
                $this->view('subjects', $this->tableBody, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateSubject()
    {
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitSubject']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['subject_id'];
            unset($data['data']['subject_id']);
            $result = $this->accountModel->update($data, $where);
            if ($result) {
                $this->view('subjects', $this->tableBody);
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
                $this->view('subjects', $this->tableBody);
            }
        }
    }

    /** get my Subjects */
    public function mySubject()
    {
        $getSubjects = $this->accountModel->user_class_subject($this->getSession('id'), 'subject');
        $this->view('mySubjects', $getSubjects);
    }
}