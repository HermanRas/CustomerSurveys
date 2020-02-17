<?php

if( isset($_POST['Question'])){

$UserHash = md5($_SERVER['AUTH_USER']);
$Survey_id = $_GET['id'];

foreach ($_POST['Question'] as $key => $value) {
         $sql = "INSERT INTO   tSurveyResult
                    (Survey_id,
                    Question_id,
                    Result,
                    UserHash) 
                VALUES
                    ('$Survey_id',
                    '$key',
                    '$value',
                    '$UserHash');";
                    
        $sqlargs = array();
        require_once 'config/db_query.php'; 
        $Questions =  sqlQuery($sql,$sqlargs);
}
     echo "<script>window.location.href='thanks.php'</script>";
    die;
}

$id = 0;
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $UserHash = md5($_SERVER['AUTH_USER']);
        //SQL get Survey Data
        $sql = 'SELECT
                SM.SurveyName,
                SQ.Question,
                SQ.id,
                QT.QuestionType
                From
                tSurveyMain As SM Inner Join
                tSurveyQuestions As SQ On SQ.Survey_id = SM.Survey_id Inner Join
                tQuestionType As QT On QT.QuestionType_id = SQ.QuestionType_id
                Where
                ((SM.ActiveIndicator <> 0) Or
                (SQ.ActiveIndicator <> 0)) And
                SM.Survey_id = :id ;';
        $sqlargs = array('id' => $id);
        require_once 'config/db_query.php'; 
        $Questions =  sqlQuery($sql,$sqlargs);

        // check user completed survey
        $sql = 'SELECT * from [tSurveyResult]
                WHERE Survey_id = :id AND 
                      UserHash = :UserHash;';
        $sqlargs = array('id' => $id,'UserHash' => $UserHash);
        require_once 'config/db_query.php'; 
        $UserSurveyCompleted =  sqlQuery($sql,$sqlargs);
        
        if($UserSurveyCompleted[1]> 0 ){
            echo "<script>window.location.href='thanks.php'</script>";
            die;
        };
}else{
    echo "Please contact ICT, the survey link is not valid !";
    die;
}

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
    <!-- Page Start -->
    <div class="pt-1 container bg-white rounded">

        <!-- NAV START -->
        <nav class="navbar navbar-dark bg-dark rounded">
            <a class="navbar-brand" href="#">
                <img src="img/icon.jpg" height="60px" class="d-inline-block align-center bg-white rounded" alt="Logo">
                <?php echo $Questions[0][0]['SurveyName'] ?>
            </a>
        </nav>
        <!-- NAV END -->

        <section>
            <!-- form start-->
            <div class="card">
                <div class="p-1 card-header bg-success">
                    <h2 class="m-0 p-0"> Questions</h2>
                </div>
                <div class="card-body">
                    <form method="POST">

                        <?php 

                        foreach ($Questions[0] as $Rec) {

                            if( strpos($Rec['QuestionType'],'|',0) > 0 ){
                                $Options = explode('|',$Rec['QuestionType']);
                                
                                echo '<div class="form-row"><div class="form-group col-md-12"><label for="Question['.$Rec['id'].']">'.$Rec['Question'].'</label><br>';
                                $j = 0;
                                foreach ($Options as $q) {
                                    echo '<div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="Question['.$Rec['id'].']['.$j.']"  name="Question['.$Rec['id'].']" value="'.$q.'" required>
                                            <label class="form-check-label" for="Question['.$Rec['id'].']['.$j.']">'.$q.'</label>
                                         </div>';
                                         $j++;
                                        }
                                 echo '</div></div><hr>';
                            }else{
                                if (strpos($Rec['QuestionType'],'Type',0)){
                                echo
                                    '<div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="Question['.$Rec['id'].']">'.$Rec['Question'].'</label>
                                            <input type="text" class="form-control" id="Question['.$Rec['id'].']" placeholder="Type here..." name="Question['.$Rec['id'].']">
                                        </div>
                                    </div>
                                    <hr>';
                                }else{
                                echo
                                    '<div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="Question['.$Rec['id'].']">'.$Rec['Question'].'</label>
                                            <input type="number" class="form-control" id="Question['.$Rec['id'].']" placeholder="Type here..." name="Question['.$Rec['id'].']" required>
                                        </div>
                                    </div>
                                    <hr>';
                                }
                            }
                        }?>
                        <div class="row my-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-success btn-lg form-control">Save</button>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- end of Bootstrap JS -->

</body>

</html>