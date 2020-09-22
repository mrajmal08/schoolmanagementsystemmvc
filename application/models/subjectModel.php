<?php

class subjectModel extends Database
{
    public function getSubject()
    {
        parent::__construct('subject');
        return $this->show();
    }

    public function insertSubject($columns, $values, $data)
    {
        parent::__construct('subject');
        return $this->insert($columns, $values, $data);
    }

    public function editSubject($user_id)
    {
        parent::__construct('subject');
        $where = 'id =' . $user_id;
        return $this->show(1, $where);

    }

    public function updateSubject($data, $where)
    {
        parent::__construct('subject');
        return $this->update($data, $where);
    }

    public function deleteSubject($where)
    {
        parent::__construct('subject');
        return $this->delete($where);
    }
}
