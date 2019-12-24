<?php
namespace Phppot;
ini_set('max_execution_time',-1);

class DataSource
{

    
    const HOST = 'localhost';

    const USERNAME = 'root';

    const PASSWORD = '';

    const DATABASENAME = 'tickerboard';

    private $conn;
    

   
    function __construct()
    {
        $this->conn = $this->getConnection();
    }

    /**
     * If connection object is needed use this method and get access to it.
     * Otherwise, use the below methods for insert / update / etc.
     *
     * @return \mysqli
     */
    public function getConnection()
    {
        $conn = new \mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASENAME);
        
        if (mysqli_connect_errno()) {
            trigger_error("Problem with connecting to database.");
        }
        
        $conn->set_charset("utf8");
        return $conn;
    }

    public function select($query, $paramType="", $paramArray=array())
    {
        $stmt = $this->conn->prepare($query);
        
        if(!empty($paramType) && !empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if (! empty($resultset)) {
            return $resultset;
        }
    }
    
   
    public function insert($query, $paramType, $paramArray)
    {
       
        $stmt = $this->conn->prepare($query);
       
        $this->bindQueryParams($stmt, $paramType, $paramArray);
        $stmt->execute();
        $insertId = $stmt->insert_id;
       
        return $insertId;
    }
    
    
    public function execute($query, $paramType="", $paramArray=array())
    {
        $stmt = $this->conn->prepare($query);
        
        if(!empty($paramType) && !empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType="", $paramArray=array());
        }
        $stmt->execute();
    }
    
   
    public function bindQueryParams($stmt, $paramType, $paramArray=array())
    {
       
        $paramValueReference[] = & $paramType;
        
        for ($i = 0; $i < count($paramArray); $i ++) {
            $paramValueReference[] = & $paramArray[$i];
        }
        
            call_user_func_array(array(
                $stmt,
                'bind_param'
            ), $paramValueReference);
       
        
    }
    
  
    public function numRows($query, $paramType="", $paramArray=array())
    {
        $stmt = $this->conn->prepare($query);
        
        if(!empty($paramType) && !empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        
        $stmt->execute();
        $stmt->store_result();
        $recordCount = $stmt->num_rows;
        return $recordCount;
    }
   
    public function up_exchnge_symbols($query){
       
        $set  = 0 ;
       
                if (mysqli_multi_query($this->conn, $query)) {
                        $set = 1;
                }
                else {
                        $set = 0;
                }
                    return $set;
          
    }


     
    public function select_alldata($query){
        $count = 0;
        $alldata = array();
        $res = mysqli_query($this->conn, $query);
        
        while($list = mysqli_fetch_assoc($res))
        {
            $alldata[] = $list;
        }
        
        return $alldata;
       
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

if(strpos($_SERVER['REQUEST_URI'], '/DataSource') !== false || strpos($_SERVER['REQUEST_URI'], 'datasource') !== false){
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
   