<?php
namespace Phppot;

use \Phppot\Member;

if (! empty($_SESSION["userId"])) {
    require_once __DIR__ . './../class/Member.php';
    $member = new Member();
    $memberResult = $member->getMemberById($_SESSION["userId"]);
    if(!empty($memberResult[0]["display_name"])) {
        
        $displayName = ucwords($memberResult[0]["display_name"]);
        $values_to_print = $member->get_all_exchange_symbols(); 
       
    } else {
        $displayName = $memberResult[0]["user_name"];
    }
}
?>
<html>
<head>
<title>User Login</title>
<link href="./view/css/style.css" rel="stylesheet" type="text/css" />
<script src="text/javascript">
const menuIconEl = $('.menu-icon');
const sidenavEl = $('.sidenav');
const sidenavCloseEl = $('.sidenav__close-icon');

// Add and remove provided class names
function toggleClassName(el, className) {
  if (el.hasClass(className)) {
    el.removeClass(className);
  } else {
    el.addClass(className);
  }
}

// Open the side nav on click
menuIconEl.on('click', function() {
  toggleClassName(sidenavEl, 'active');
});

// Close the side nav on click
sidenavCloseEl.on('click', function() {
  toggleClassName(sidenavEl, 'active');
});
</script>
</head>
<body>
<div class="grid-container">
   <div class="menu-icon">TB
    <i class="fas fa-bars header__menu"></i>
  </div>
   
  <header class="header">
    <div class="header__search">Welcome <b><?php echo $displayName; ?></b></div>
    <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; } ?>
    <div class="header__avatar"><a href="./logout.php" class="logout-button">Logout</a></div>
  </header>
  <div>
        <div class="dashboard">
           
                 <div id='parent_div_1'>
                  
                 <form action="login-action.php" method="post" name="exchnge_symbols">
                         <?php  
                         
                          if(count($values_to_print) ==24){
                              foreach($values_to_print as $k =>$v){
                                  $count = $k+1;
                                  echo '<div class="child_div_1">';
                                  if(strlen($count)== 1){
                                    echo '<div class="pos'.$count.'">';
                                    echo '<span class="badge">0'.$count.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                  }
                                  else{
                                    echo '<div class="pos'.$count.'">';
                                    echo '<span class="badge">'.$count.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                  }
                                  echo '<label>Display:</label>&nbsp;&nbsp;&nbsp;';
                                  echo '<input type="textbox" name="display_name[]" value="'.$v['display_name'].'" class="textbox_dm" required="true"/>';
                                  echo  '&nbsp;&nbsp;&nbsp;<label>Symbol:</label>&nbsp;&nbsp;&nbsp;';
                                  echo '<input type="textbox" name="symbol_name[]" value="'.$v['symbol'].'" class="textbox_dm" required="true"/>';
                                  echo '</div>';
                                  echo '</div>';
                              }
                            }
                           
                        ?>
                                    <div class="child_div_1"> 
                                      <input type="submit" name="save" value="Save" class="btnLogin" style="width: 30%;margin: 15px 200px;"/>
                                   </div>
                                    </form>
                  </div>
                 <br/>
            
    </div>
 </div>
</div>
</body>
</html>