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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client Survey</title>

    <!-- Chrome/android APP settings -->
    <meta name="theme-color" content="#4287f5">
    <link rel="icon" href="img/icon.jpg" sizes="192x192">
    <!-- end of Chrome/Android App Settings  -->

    <!-- Bootstrap // you can use hosted CDN here-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
    <!-- end of bootstrap -->

</head>

<body class="bg-primary">
    <?php
        $sid = $_GET['sid'];
        $sql = 'SELECT * from [CustomerSurveys].[dbo].[tSurveyQuestions]
                WHERE Survey_id = :sid;';
        $sqlargs = array('sid'=>$sid);
        require_once 'config/db_query.php'; 
        $SurveyTb =  sqlQuery($sql,$sqlargs);
    ?>

    <!-- Page Start -->
    <div class="pt-1 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="#">
                <img src="img/icon.jpg" height="60px" class="d-inline-block align-center bg-white rounded" alt="Logo">
                Client Survey Questions
            </a>
        </nav>
        <!-- NAV END -->

        <section>
            <!-- form start-->
            <div class="card">
                <div class="p-1 card-header bg-success">
                    <h2 class="m-0 p-0 text-white"> Update Survey Questions</h2>
                </div>
                <div class="card-body">
                    <form method="GET" action="admin_new.php">
                        <?php
                        foreach ($SurveyTb[0] as $Rec) {
                            if($Rec['ActiveIndicator']== -1){
                                $active = "Active";
                                $status = "bg-success text-white";
                            }else{
                                $active = "Deactivated";
                                $status = "bg-secondary text-white";
                            }

                        ?>
                        <!-- Survey Start -->
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text <?php echo $status?>"><?php echo $active; ?></div>
                                    </div>
                                    <input type=" text" class="form-control" id="inlineFormInputGroup"
                                        value="<?php echo $Rec['Question'] ;?>" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <a class="form-control btn btn-primary"
                                    href="admin_action.php?qid=<?php echo $Rec['id'] ;?>">
                                    Toggle
                                </a>
                            </div>
                        </div>
                        <!-- Survey End -->
                        <?php
                            }
                        ?>
                        <hr>
                        <div class="row my-3">
                            <div class="col-12">
                                <button class="btn btn-outline-success btn-lg form-control">
                                    New Survey</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- form end -->
        </section>


    </div>
    <!-- Page End -->

    <!-- Start of Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- end of Bootstrap JS -->

</body>

</html>