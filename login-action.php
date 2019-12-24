<?php
namespace Phppot;
session_start();
use \Phppot\Member;

    /*if(!isset($_SESSION['userId'])){
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
    }*/

   
if (isset($_POST['login'])) {
    session_start();
    $username = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    require_once (__DIR__ . "/class/Member.php");
    
    $member = new Member();
    $isLoggedIn = $member->processLogin($username, $password);
    if (! $isLoggedIn) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    }
    header("Location: ./index.php");
    exit();
}

if(isset($_POST['save'])){
    $cnt_posarray = array_combine($_POST['display_name'],$_POST['symbol_name']);
    echo '<pre>';
   echo count($cnt_posarray);
   echo count(array_unique($cnt_posarray));
   echo '</pre>';
     if(count($cnt_posarray) !== count(array_unique($cnt_posarray)))
     {
       $org_val = array(); $uniq_arra = array();
         foreach (array_unique($cnt_posarray) as $key => $value) {
             $org_val[] = $key;
         }
         foreach ($cnt_posarray as $key => $value) {
             $uniq_arra[] = $key;
         }
        
         $finalarray = array_diff($uniq_arra, $org_val);
         foreach ($finalarray as $key => $value) {
            $_SESSION['msg'] = '<div class="header__msg error">Duplicate record Insertion is not allowed.</div>'; 
            header('Location:./index.php');
        }
          
     }
    else{
        $set_var = 0;
        require_once (__DIR__ . "/class/Member.php");
        $member = new Member();
        //$item = array(); 
        //$dup_array = array();       

           if(count($cnt_posarray)== 24){

            //    /* foreach($cnt_posarray as $key => $valu){
                            
            //         $chk_symbol = $member->check_url($valu);
            //         if($chk_symbol == 'Unknown symbol'){
            //             $item[$valu] = $chk_symbol;
            //             $dup_array[$valu] = $chk_symbol;
            //         }
            //         else{
            //             $item[$valu] = 'data';
            //         }
            //    }/*
              
              // if(!in_array('Unknown symbol',$item)){
                 
                    $cnt =1;
                         foreach($cnt_posarray as $key => $valu){
                           
                              $UpId = $member->update_exchange_symbols($key, $valu, $cnt);
                             
                              $cnt++;
                                if (!empty($UpId) && $UpId == 1) {
                                    $_SESSION['msg'] = '<div class="header__msg success"><b>Record Updated Successfully</b></div>';
                                }
                        }
                        header ("Location: ./index.php");
             // }

              /* else{
                   foreach($dup_array as $k => $v){
                    $_SESSION['msg'] = '<div class="header__msg error"><b>Please enter the correct symbol: '.$k.'</b></div>';
                   }
              // }*/

                
            }
            else{
                $set_var =2;
            }
        
      
    }   
}     
         


