<?php
namespace Phppot;

use \Phppot\DataSource;

class Member
{

    private $dbConn;

    private $ds;

    function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new DataSource();
    }

    function getMemberById($memberId)
    {
        $query = "select * FROM registered_users WHERE id = ?";
        $paramType = "i";
        $paramArray = array($memberId);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
        return $memberResult;
    }
    
    public function processLogin($username, $password) {
        //$passwordHash = md5($password);
        $query = "select * FROM registered_users WHERE user_name = ? AND password = ?";
        $query1 = "select name,symbol FROM exchange_symbols";
        $paramType = "ss";
        $paramArray = array($username, $password);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);

        if(!empty($memberResult)) {
            $_SESSION["userId"] = $memberResult[0]["id"];
            return true;
        }
       
    }
    function validateMember()
    {
        $valid = true;
        $errorMessage = array();
        foreach ($_POST as $key => $value) {
            if (empty($_POST[$key])) {
                $valid = false;
            }
        }
        
        if($valid == true) {
            // Password Matching Validation
            if ($_POST['password'] != $_POST['confirm_password']) {
                $errorMessage[] = 'Passwords should be same.';
                $valid = false;
            }
            
            // Email Validation
            if (! isset($error_message)) {
                if (! filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
                    $errorMessage[] = "Invalid email address.";
                    $valid = false;
                }
            }
            
            // Validation to check if Terms and Conditions are accepted
            if (! isset($error_message)) {
                if (! isset($_POST["terms"])) {
                    $errorMessage[] = "Accept terms and conditions.";
                    $valid = false;
                }
            }
        }
        else {
            $errorMessage[] = "All fields are required.";
        }
        
        if ($valid == false) {
            return $errorMessage;
        }
        return;
    }

    function isMemberExists($username, $email)
    {
        $query = "select * FROM registered_users WHERE user_name = ? OR email = ?";
        $paramType = "ss";
        $paramArray = array($username, $email);
        $memberCount = $this->ds->numRows($query, $paramType, $paramArray);
        
        return $memberCount;
    }

    function insertMemberRecord($username, $displayName, $password, $email)
    {
        $passwordHash = md5($password);
        $query = "INSERT INTO registered_users (user_name, display_name, password, email) VALUES (?, ?, ?, ?)";
        $paramType = "ssss";
        $paramArray = array(
            $username,
            $displayName,
            $passwordHash,
            $email
        );
        $insertId = $this->ds->insert($query, $paramType, $paramArray);
        return $insertId;
    }
    function update_exchange_symbols($name, $symbol, $id)
    {
    
        $query = "";
        $query .= "Update exchange_symbols set display_name = '$name',symbol = '$symbol' where id ='$id';";
        $query .= "";
        
        $symbolCount = $this->ds->up_exchnge_symbols($query);
        return $symbolCount;
    }
    public function get_all_exchange_symbols(){
        $query = "select display_name,symbol FROM exchange_symbols ORDER BY id ASC";
        $memberResult= $this->ds->select_alldata($query);
        return $memberResult;
       
    }
    
    public function check_url($prm){
        $handle = curl_init();
        $url = "https://cloud.iexapis.com/stable/stock/".$prm."/quote?token=pk_c9157d70c3cf47e09633280796bdbb0d";
        
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($handle);
        curl_close($handle);
        return $output;
   
    }

    
}
$obj  = new Member();

    if(isset($_GET['get_all_exchange_symbols']) && $_GET['get_all_exchange_symbols'] == '1'){
         header("Access-Control-Allow-Origin: *");
         header("Content-type: application/xml");
         $data = $obj->get_all_exchange_symbols();
         echo $json = json_encode($data); 
      
    }
    if((strpos($_SERVER['REQUEST_URI'], '/member') !== false || strpos($_SERVER['REQUEST_URI'], '/Member') !== false) && !(isset($_GET['get_all_exchange_symbols']))){
         echo '<div style="height: 30em;position: relative;">';
         echo '<p style="
                margin: 0;
                background: yellow;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-right: -50%;
                transform: translate(-50%, -50%);
                ">Unauthorised Access.
            </p>
            </div>';
}
