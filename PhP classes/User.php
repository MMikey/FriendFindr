<?php


class User
{
    private $id;
    private $username;
    private $email;
    private $location;
    private $bio;
    private $created_at;
    private $date_of_birth;
    private $hobbies;


    public function __construct($id) {
        $this->id = $id;
        $this->loadUser($id);
    }

    private function loadUser($id) {
        global $mysqli;

        $sql = "SELECT username, email, location, bio, created_at, DateOfBirth FROM users WHERE userid=?;";
        $user_err = "";

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_userid);

            $param_userid = $id;

            if($stmt->execute()) {
                $stmt->store_result();
                if($stmt->num_rows == 0) {
                    $user_err = "Error: User not found!";
                } else {
                    $stmt->bind_result($username, $email, $location, $bio, $created_at, $date_of_birth);
                    if ($stmt->fetch()) {
                        $this->username = $username;
                        $this->email = $email;
                        $this->location = $location;
                        $this->bio = $bio;
                        $this->created_at = $created_at;
                        $this->date_of_birth = $date_of_birth;

                    }
                }
            } else {
                $user_err = "Oops! Something went wrong! " . $mysqli->error;
            }

        } else {
            "Oops! Something went wrong! " . $mysqli->error;
        }

        if(!empty($group_err)) {
            throw new Exception($group_err);
        }
    }

    public function getGroups() {
        global $mysqli;
        $sql = "SELECT grp.groupid, grp.name FROM groups grp JOIN usergroups ugr ON grp.groupid = ugr.groupid where userid = ?";
        $group_err = "";
        $groups = array();

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_userid);

            $param_userid = $this->id;

            if($stmt->execute()) {
                $stmt->store_result();
                    $stmt->bind_result($id, $name);
                    while($stmt->fetch()) {
                        $groups[$id] = $name;
                    }
            }
        }
        return $groups;
    }

    public function getHobbies() {
        global $mysqli;
        $hobbies = array();
        $sql = "SELECT name FROM hobbies hb join userhobbies uhb on hb.hobbyid = uhb.hobbyid WHERE userid = $this->id";

        if($result = $mysqli->query($sql)) {
            while($row = $result->fetch_assoc()) {
                $hobbies[] = $row["name"];
            }
        }
        return $hobbies;
    }

    function getProfilePic()
    {
        global $mysqli;
        $sql = "SELECT name FROM profilepictures WHERE userid = $this->id;";

        if ($result = $mysqli->query($sql)) {
            $row = $result->fetch_assoc();
            return "uploads/profile_pictures/" . $row["name"];
        } else {
            return $mysqli->error;
        }

    }

    static function getProfilePicForUser($userid) {
        global $mysqli;
        $sql = "SELECT name FROM profilepictures WHERE userid = $userid;";

        if ($result = $mysqli->query($sql)) {
            if($result->num_rows ==0) return "uploads/profile_pictures/default.jpg";
            $row = $result->fetch_assoc();
            return "uploads/profile_pictures/" . $row["name"];
        } else {
            return $mysqli->error;
        }
    }



}