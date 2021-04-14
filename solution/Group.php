<?php
/** @var mysqli $mysqli */
include_once "config.php";
include "solution/Validator.php";

class Group
{
    private $id;
    private $name;
    private $description;
    private $users;

    public function __construct($id)
    {
        $this->id = $id;
        $this->loadUser($id);
    }

    private function loadUser($id) {
        global $mysqli;
        $isValid = true;
        //get name and description
        $sql = "SELECT name, description FROM groups WHERE groupid = ?";//fetch data about group

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s",$param_groupid);

            $param_groupid = $id;
            $group_err = "";

            if($stmt->execute()) {
                $stmt->store_result();
                if($stmt->num_rows == 0){
                    $group_err = "Error: Group not found";
                } else {
                    $stmt->bind_result($name,$description);
                    if($stmt->fetch()) {
                        $this->name = $name;
                        $this->description = $description;
                    }
                }
            } else {
                $group_err = "Oops! Something went wrong! " . $mysqli->error;
            }
        } else {
            $group_err = "Oops! Something went wrong! " .  $mysqli->error;
        }

        if(!empty($group_err)) {
            throw new Exception($group_err);
        }
    }
    public function get_id() {
        return $this->id;
    }

    public function get_name() : string {
        return $this->name;
    }

    public function set_name($name) : void {
        $this->name = $name;
    }

    public function get_description() : string {
        return $this->description;
    }

    public function set_description($description) : void {
        $this->description = $description;
    }

    public function get_users() : array {
        return $this->users;
    }

    public function add_user($user_id) : void {
        global $mysqli;
        $sql = "INSERT INTO usergroups (userid,groupid) VALUES (". $user_id . "," . $this->id  .");";

        $valid = $this->is_member($user_id);
        if($valid === true) {
            if ($mysqli->query($sql)) {
                echo "You've successfully joined this group";
            } else {
                throw new Exception("$mysqli->error");
            }
        } else {
            throw new Exception($valid);
        }
    }

    public function is_member($user_id) : bool {
            global $mysqli;
            $sql = "SELECT userid FROM usergroups WHERE userid = $user_id AND groupid=$this->id;";

            if($result = $mysqli->query($sql)) {
                if($result->num_rows > 0)
                {
                    return "You're already part of this group..";
                }
                return true;
            } else {
                return "Oops! Something went wrong! $mysqli->error";
            }
            }
}

?>