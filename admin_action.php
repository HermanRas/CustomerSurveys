<?php
// check user is survey admin
$User = $_SERVER['AUTH_USER'];

$sql = 'SELECT * from [tSurveyAdmins]
        WHERE SurveyAdminUserName = :User;';
$sqlargs = array('User' => $User);
require_once 'config/db_query.php'; 
$UserAdmin =  sqlQuery($sql,$sqlargs);

if($UserAdmin[1] < 1 ){
    echo "Please contact Petra In-house Software support for access !";
    die;
};

if( isset($_POST['Question'])){

// $UserHash = md5($_SERVER['AUTH_USER']);
// $Survey_id = $_GET['id'];

// foreach ($_POST['Question'] as $key => $value) {
//          $sql = "INSERT INTO   tSurveyResult
//                     (Survey_id,
//                     Question_id,
//                     Result,
//                     UserHash) 
//                 VALUES
//                     ('$Survey_id',
//                     '$key',
//                     '$value',
//                     '$UserHash');";
                    
//         $sqlargs = array();
//         require_once 'config/db_query.php'; 
//         $Questions =  sqlQuery($sql,$sqlargs);
//         }
//      echo "<script>window.location.href='thanks.php'</script>";
    var_dump($_POST);
    die;
}


?>