<?php

class teacherModel extends Database
{
    public function getTeacher()
    {
        parent::__construct('user');
        $where = "status = 1 AND role_id = 3";
        return $this->show(false, $where);
    }

    public function insertTeacher($columns, $values, $data)
    {
        parent::__construct('user');
        return $this->insert($columns, $values, $data);
    }

    public function editTeacher($user_id)
    {
        parent::__construct('user');
        $where = 'id =' . $user_id;
        return $this->show(1, $where);

    }

    public function updateTeacher($data, $where)
    {
        parent::__construct('user');
        return $this->update($data, $where);
    }

    public function deleteTeacher($where)
    {
        parent::__construct('user');
        return $this->delete($where);
    }

}
