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

if( isset($_GET['sid'])){
        $sid = $_GET['sid'];
        $sql = 'SELECT * from [CustomerSurveys].[dbo].[tSurveyMain]
        WHERE OwnerUserName = :User
        AND Survey_id = :sid;';
        $sqlargs = array('User'=>$User,'sid'=>$sid);
        require_once 'config/db_query.php'; 
        $SurveyTb =  sqlQuery($sql,$sqlargs);


        if($SurveyTb[0][0]['ActiveIndicator']== -1){
            $sql = 'UPDATE [CustomerSurveys].[dbo].[tSurveyMain]
                    SET ActiveIndicator = 0
                    WHERE Survey_id = :sid;';
            $sqlargs = array('sid'=>$sid);
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);
        }else{
            $sql = 'UPDATE [CustomerSurveys].[dbo].[tSurveyMain]
                    SET ActiveIndicator = -1
                    WHERE Survey_id = :sid;';
            $sqlargs = array('sid'=>$sid);
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);
        }
    echo "<script>window.location.href='admin.php'</script>";
    die;
}
if( isset($_GET['qid'])){
        $qid = $_GET['qid'];
        $sql = 'SELECT * from [CustomerSurveys].[dbo].[tSurveyQuestions]
        WHERE id = :qid;';
        $sqlargs = array('qid'=>$qid);
        require_once 'config/db_query.php'; 
        $SurveyTb =  sqlQuery($sql,$sqlargs);


        if($SurveyTb[0][0]['ActiveIndicator']== -1){
            $sql = 'UPDATE [CustomerSurveys].[dbo].[tSurveyQuestions]
                    SET ActiveIndicator = 0
                    WHERE id = :qid;';
            $sqlargs = array('qid'=>$qid);
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);
        }else{
            $sql = 'UPDATE [CustomerSurveys].[dbo].[tSurveyQuestions]
                    SET ActiveIndicator = -1
                    WHERE id = :qid;';
            $sqlargs = array('qid'=>$qid);
            require_once 'config/db_query.php'; 
            sqlQuery($sql,$sqlargs);
        }
    echo "<script>window.location.href='admin.php'</script>";
    die;
}


?>