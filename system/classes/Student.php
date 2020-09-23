<?php

trait Student
{

    /**
     * this function returns the user class details and also user subject details
     * according to their type
     * @param $user_id
     * @param null $type
     * @return mixed
     */
    public function user_class_subject($user_id, $type = null)
    {
        switch ($type) {
            case 'class':
                $query = "SELECT class.id as id, class.name as classname, class.number as classnumber
                  FROM `user_has_class` 
                  INNER JOIN user ON user_has_class.user_id = user.id 
                  INNER JOIN class ON user_has_class.class_id = class.id WHERE user_id = $user_id";
                return $this->get_data_for_query($query);
                break;
            case 'subject':
                $query = "SELECT subject.id as id, subject.name as subjectname, subject.author as
                  authorname 
                  FROM `user_has_subject` INNER JOIN user ON user_has_subject.user_id = user.id
                  INNER JOIN subject ON user_has_subject.subject_id = subject.id WHERE
                  user_id = $user_id";
                return $this->get_data_for_query($query);
                break;
            default:
        }
    }

    /**
     * this function used for assigning the class or subject to the user
     * @param $user_id
     * @param null $class_id
     * @param null $subject_id
     * @return string
     */
    public function assign_class_subject($user_id, $class_id = null, $subject_id = null)
    {
        if (!empty($class_id)) {
            try {
                //ids for show data
                $data = [
                    'user_id' => $user_id,
                    'class_id' => $class_id,
                ];
                //getting columns and values for insert query
                $where = "user_id = " . $user_id . " AND class_id = " . $class_id;
                $result = $this->show(false, $where);
                if (!empty($result)) {
                    return "<span style='color: red'>class already asssigned</span>";
                } else {
                    //getting columns and values for insert query
                    $columns = ['user_id', 'class_id'];
                    $values = [':user_id', ':class_id'];

                    $this->insert($columns, $values, $data);
                }
            } catch (PDOException $e) {
                return "Error : " . $e->getMessage();
            }
        } elseif (!empty($subject_id)) {
            try {
                //ids for show data
                $data = [
                    'user_id' => $user_id,
                    'subject_id' => $subject_id,
                ];
                //getting columns and values for insert query
                $where = "user_id = " . $user_id . " AND subject_id = " . $subject_id;
                $result = $this->show(false, $where);
                if (!empty($result)) {
                    return "<span style='color: red'>class already asssigned</span>";
                } else {
                    //getting columns and values for insert query
                    $columns = ['user_id', 'subject_id'];
                    $values = [':user_id', ':subject_id'];
                    $this->insert($columns, $values, $data);
                }
            } catch (PDOException $e) {
                return "Error : " . $e->getMessage();
            }
        } else {
            return "<span style='color: red'>Missing class_id || subject_id || user_id </span>";
        }
    }

    /**
     * this function used only for query execution
     * @param $query
     * @return mixed
     */
    protected function get_data_for_query($query)
    {
        if (!empty($query)) {
            $data = $this->conn->query($query);
            return $data->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}