<?php

class studentModel extends Database
{
    /** get student data  */
    public function getStudent()
    {
        parent::__construct('user');
        $where = "status = 1 AND role_id = 4";
        return $this->show(false, $where);
    }

    /** insert new student */
    public function insertStudent($columns, $values, $data)
    {
        parent::__construct('user');
        return $this->insert($columns, $values, $data);
    }

    /** get student data by student id */
    public function editStudent($user_id)
    {
        parent::__construct('user');
        $where = 'id =' . $user_id;
        return $this->show(1, $where);

    }

    /** update student */
    public function updateStudent($data, $where)
    {
        parent::__construct('user');
        return $this->update($data, $where);
    }

    /** delete student */
    public function deleteStudent($where)
    {
        parent::__construct('user');
        return $this->delete($where);
    }

    /** get single data */
    public function getClass($where)
    {
        parent::__construct('user');
        return $this->show(1, $where);
    }

    /** getting all classess */
    public function getClassDropDown()
    {
        parent::__construct('class');
        return $this->show();
    }

    /** getting all subjects */
    public function getSubjectDropDown()
    {
        parent::__construct('subject');
        return $this->show();
    }

    /** get related class single student */
    public function singleUserDataClass($user_id)
    {
        return $this->user_class_subject($user_id, 'class');
    }

    /** get related subject single student */
    public function singleUserDataSubject($user_id)
    {
        return $this->user_class_subject($user_id, 'subject');
    }

    /** assign class to student */
    public function assignClassTo($user_id, $class_id)
    {
        parent::__construct('user_has_class');
        return $this->assign_class_subject($user_id, $class_id);
    }

    /** assign subject to student */
    public function assignSubjectTo($user_id, $subject_id)
    {
        parent::__construct('user_has_subject');
        return $this->assign_class_subject($user_id, '', $subject_id);
    }

    /** un assign class to student */
    public function un_assign_class($where)
    {
        parent::__construct('user_has_class');
        return $this->delete($where);
    }

    /** un assign subject to student */
    public function un_assign_subject($where)
    {
        parent::__construct('user_has_subject');
        return $this->delete($where);

    }
}
