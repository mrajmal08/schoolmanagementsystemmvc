<?php

class principalModel extends Database
{
    public function getPrincipal()
    {
        parent::__construct('user');
        $where = "status = 1 AND role_id = 2";
        return $this->show(false, $where);
    }

    public function insertPrincipal($columns, $values, $data)
    {
        parent::__construct('user');
        return $this->insert($columns, $values, $data);
    }

    public function editPrincipal($user_id)
    {
        parent::__construct('user');
        $where = 'id =' . $user_id;
        return $this->show(1, $where);

    }

    public function updatePrincipal($data, $where)
    {
        parent::__construct('user');
        return $this->update($data, $where);
    }

    public function deletePrincipal($where)
    {
        parent::__construct('user');
        return $this->delete($where);
    }
}
