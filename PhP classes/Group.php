<?php
/** @var mysqli $mysqli */
include_once "config.php";
include "PhP classes/Validator.php";

class Group
{
    private $id;
    private $name;
    private $description;
    private $users;

    public function __construct($id)
    {
        $this->id = $id;
        $this->loadGroup($id);
    }

    private function loadGroup($id) {
        global $mysqli;
        //get name and description
        $sql = "SELECT name, description FROM groups WHERE groupid = ?";

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
        if($valid !== true) {
            if ($mysqli->query($sql)) {
                echo "You've successfully joined this group";
            } else {
                throw new Exception("$mysqli->error");
            }
        } else {
            throw new Exception($valid);
        }
    }

    public function remove_user($user_id) : void {
        global $mysqli;
        if(!$this->is_member($user_id)) {
            throw new Exception("Not a member");
        }

        $sql = "SELECT usergroups_id FROM usergroups WHERE userid = $user_id AND groupid = $this->id";

        if($result = $mysqli->query($sql)) {
            $usergroups_id = $result->fetch_assoc()["usergroups_id"];
        } else {
            echo "error" . $mysqli->error;
        }

        $sql = "DELETE FROM usergroups WHERE usergroups_id = $usergroups_id";
        if(!$mysqli->query($sql)) throw new Exception("$mysqli->error");

    }

    public function is_member($user_id){
            global $mysqli;
            $sql = "SELECT userid FROM usergroups WHERE userid = $user_id AND groupid=$this->id;";

            if($result = $mysqli->query($sql)) {
                if($result->num_rows ==0)
                {
                    return false;
                }
                return true;
            } else {
                return "Oops! Something went wrong! $mysqli->error";
            }
    }

    /**
     * @return array returns array of all members of the group. returns empty array if group has no members
     */
    public function get_members(){
        global $mysqli;
        $members = array(); //initialise an array for returning
        $sql = "SELECT u.userid, u.username FROM users u, usergroups ug
            where u.userid = ug.userid AND ug.groupid = " . $this->id . ";";

        if($result = $mysqli->query($sql)) {
            while($row = $result->fetch_assoc()) {
                    $members[$row["userid"]] = $row["username"];
                }
        }
        return $members;
    }

    public function getGroupPic(){
        global $mysqli;
        $sql = "SELECT name FROM grouppictures WHERE groupid = $this->id;";

        if ($result = $mysqli->query($sql)) {
            if($result->num_rows ==0) return "";
            $row = $result->fetch_assoc();
            return "uploads/group_pictures/" . $row["name"];
        } else {
            return $mysqli->error;
        }
    }

    public function groupDisplay(){
        return <<<HTML
            <div class="col-md-4 py-3">
                <div class="card h-100 box-shadow shadow">
                    <img class="card-img-top" style="height:200px" src="{$this->getGroupPic()}">
                    <div class="card-header text-center"><h5>{$this->name}</h5></div>
                    <div class="card-body d-flex flex-column">
                        <p class="card-text text-muted">{$this->description}</p>
                        <a href="group-page.php?groupid={$this->id}" class="btn btn-sm btn-outline-secondary mt-auto" role="button">View Group</a>
                        </div>
                </div>
            </div>
            HTML;
    }

}

?>