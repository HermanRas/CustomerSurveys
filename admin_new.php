<?php
if( isset($_POST['Question'])){
$UserHash = md5($_SERVER['AUTH_USER']);
$User= $_SERVER['AUTH_USER'];
$SurveyName = $_POST['SurveyName'];

// Add survey to main
$sql = "INSERT INTO tSurveyMain
        (SurveyName,
        ActiveIndicator,
        OwnerUserName) 
        VALUES
        ('$SurveyName',
        '-1',
        '$User');";
$sqlargs = array();
require_once 'config/db_query.php'; 
sqlQuery($sql,$sqlargs);

//get survey ID 
$sql = "SELECT TOP(1) Survey_id from tSurveyMain
        ORDER BY Survey_id DESC;";
$sqlargs = array();
require_once 'config/db_query.php'; 
$SurveyTb = sqlQuery($sql,$sqlargs);
$Survey_id = $SurveyTb[0][0]['Survey_id'];

foreach ($_POST['Question'] as $key => $value) {
    $Question = $value;
    $Type = $_POST['Type'][$key];
    $sql = "INSERT INTO  tSurveyQuestions
                (Survey_id,
                QuestionType_id,
                Question,
                ActiveIndicator) 
            VALUES
                ('$Survey_id',
                '$Type',
                '$Question',
                '-1');";
                    
        $sqlargs = array();
        require_once 'config/db_query.php'; 
        $Questions =  sqlQuery($sql,$sqlargs);
        }
    echo "<script>window.location.href='admin_link.php?id=$Survey_id'</script>";
    die;
}


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
        $sql = 'SELECT * from [tQuestionType];';
        $sqlargs = array('');
        require_once 'config/db_query.php'; 
        $QType =  sqlQuery($sql,$sqlargs);
        echo "<script> let QType = [" . json_encode($QType[0]) . "];</script>";
    ?>
    <!-- Page Start -->
    <div class="pt-1 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="#">
                <img src="img/icon.jpg" height="60px" class="d-inline-block align-center bg-white rounded" alt="Logo">
                Client Survey Builder
            </a>
        </nav>
        <!-- NAV END -->

        <section>
            <!-- form start-->
            <div class="card">
                <div class="p-1 card-header bg-success">
                    <h2 class="m-0 p-0 text-white"> Build a Survey</h2>
                </div>
                <div class="card-body">
                    <form method="POST">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="SurveyName">SurveyName:</label>
                                <input type="text" maxlength="250" class="form-control" id="SurveyName"
                                    name="SurveyName" Placeholder="Type the survey name here" required>
                            </div>
                        </div>
                        <p class="small text-danger">Question number are for visual aid only ! </p>
                        <hr>
                        <div id="QHolder">
                        </div>

                        <div class="row my-3">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-primary btn-lg form-control"
                                    onclick="addNew();">Add
                                    Question</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-info btn-lg form-control">Add
                                    Title</button>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12 pt-1">
                                <button type="submit" class="btn btn-outline-success btn-lg form-control">Save</button>
                            </div>
                            <div class="col-12 pt-1">
                                <button type="button" class="btn btn-outline-secondary btn-lg form-control"
                                    onclick="window.location.href='admin.php'">Home / Cancel</button>
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

    <!-- Page Level JS -->
    <script src="js/questions.js">
    </script>

</body>

</html>