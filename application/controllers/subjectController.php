<?php

class subjectController extends Framework
{
    use Validation;
    use Student;
    protected $sessionId;
    protected $tableBody;

    /** initialize the constructor */
    public function __construct()
    {
        $this->sessionId = getSessionData();
        $this->tableBody = $this->model('subjectModel');
        $this->tableBody = $this->tableBody->show();
    }

    public function index()
    {
        $this->view('subjects', $this->sessionId, $this->tableBody);
    }

    /** create principal */
    public function createSubject()
    {
        $create = $this->model('subjectModel');
        if (isset($_POST['submitSubject'])) {
            $rules = [
                'name' => 'required|max:12',
            ];
            $data = $_POST;
            $this->validate($data, $rules);
            if ($this->errors) {
                $error = $this->errors;
                $this->view('subjects', $this->sessionId, $this->tableBody, $error);
            } else {
                $name = input('name');
                $author = input('author');
                $data = [
                    'name' => $name,
                    'author' => $author,
                ];
                $columns = ['name', 'author'];
                $values = [':name', ':author'];
                $result = $create->insert($columns, $values, $data);
                if ($result) {
                    $this->view('subjects', $this->sessionId, $this->tableBody);
                } else {
                    return "Something problem";
                }
            }
        }
    }

    /** edit get user id principal */
    public function edit()
    {
        $edit = $this->model('subjectModel');
        if (isset($_GET['type']) && $_GET['type'] == 'edit') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = 'id =' . $user_id;
                $user = $edit->show(1, $where);
                $this->view('subjects', $this->sessionId, $this->tableBody, '', $user);

            }
        }
    }

    /** Update principal */
    public function updateSubject()
    {
        $update = $this->model('subjectModel');
        if (isset($_POST['edit'])) {
            unset($_POST['edit']);
            unset($_POST['submitSubject']);
            $data['data'] = $_POST;
            $where = "id = " . $_POST['subject_id'];
            unset($data['data']['subject_id']);
            $result = $update->update($data, $where);
            if ($result) {
                $this->view('subjects', $this->sessionId, $this->tableBody);
            }
        }
    }

    /** delete principal */
    public function delete()
    {
        $delete = $this->model('subjectModel');
        if (isset($_GET['type']) && $_GET['type'] == 'delete') {
            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $where = "id = " . $user_id;
                $delete->delete($where);
                $this->view('subjects', $this->sessionId, $this->tableBody);
            }
        }
    }

    /** get my Subjects */
    public function mySubject()
    {
        $subject = $this->model('subjectModel');
        $getSubjects = $subject->user_class_subject($this->sessionId[0], 'subject');
        $this->view('mySubjects', $this->sessionId, $getSubjects);
    }
}