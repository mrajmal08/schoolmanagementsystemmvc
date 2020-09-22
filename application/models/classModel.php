<?php

class classModel extends Database
{
    public function getClass()
    {
        parent::__construct('class');
        return $this->show();
    }

    public function insertClass($columns, $values, $data)
    {
        parent::__construct('class');
        return $this->insert($columns, $values, $data);
    }

    public function editClass($user_id)
    {
        parent::__construct('class');
        $where = 'id =' . $user_id;
        return $this->show(1, $where);

    }

    public function updateClass($data, $where)
    {
        parent::__construct('class');
        return $this->update($data, $where);
    }

    public function deleteClass($where)
    {
        parent::__construct('class');
        return $this->delete($where);
    }
}
