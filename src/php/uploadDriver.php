<?php
// check form was submitted
if (isset($_POST["uploadSubmit"]) && !empty($_FILES["uploadFile"]["name"])) {
    define("BD", $_SERVER["DOCUMENT_ROOT"] . "/FlexScheduler/src/php/");

    // MySQL includes
    include BD . "mysql/create_required.php";
    include BD . "mysql/delete_term.php";
    include BD . "mysql/drop_temp.php";
    include BD . "mysql/upload_data.php";
    include BD . "mysql/upload_temp.php";

    // utility includes
    include BD . "utility/Connection.php";
    include BD . "utility/convert_term.php";
    include BD . "utility/execute_query.php";
    include BD . "utility/get_file.php";

    // start session
    session_start();

    try {
        // get file
        $targetFilePath = get_file(basename($_FILES["uploadFile"]["name"]));

        // establish connection
        $conn = new Connection(
            $_SESSION["username"],
            $_SESSION["password"]
        );

        // ensure required tables exist
        create_required($conn->get_conn());

        // convert selected term to start and end months
        $term = convert_term($_POST["term"]);
        $strtMonth = $term[0];
        $endMonth = $term[1];

        // delete listings for selected term from database
        delete_term($conn->get_conn(), $strtMonth, $endMonth);

        // upload file to temp table
        upload_temp(
            $conn->get_conn(),
            $targetFilePath,
            $strtMonth,
            $endMonth
        );

        // upload data from temp table to database
        upload_data($conn->get_conn());

        // drop temp table
        drop_temp($conn->get_conn());

        // commit transaction
        $conn->get_conn()->commit();
        $conn->get_conn()->autocommit(TRUE);

        // success alert
        $message = "Success: Course catalog updated.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    // exception alert
    catch (Exception $e) {
        $message = $e->getMessage();
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>

<html>

<head>
    <title>Course Catalog Upload</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Student Scheduler</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/pricing/">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="admin.css" rel="stylesheet">

    <style>
      .btn-primary {
        background-color:#B6A267;
        outline: black;
        border-color: black;
      }
      .btn:hover {
      background-color: white; /* Green */
      color:black;
      border-color: #B6A267;
      }
    </style>
</head>

<body>
    <!-- This is the header -->
    <?php include "includes/header.php"; ?>

    <!-- file upload form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>"
        onsubmit="return confirm('WARNING: This will replace all existing ' +
            'data for the selected term.');"
        method="post" enctype="multipart/form-data">
        <label for="uploadFile">Select course catalog to upload:</label>
        <input type="file" id="uploadFile" name="uploadFile"/>
        <br/>
        <br/>
        <label for="term">Select term to update:</label>
        <select id="term" name="term">
            <option value="fall">Fall</option>
            <option value="spring">Spring</option>
            <option value="summer">Summer</option>
        </select>
        <br/>
        <br/>
        <input type="submit" value="Upload Data" id="uploadSubmit"
            name="uploadSubmit"/>
    </form>

    <!-- This is the footer -->
    <?php include "includes/footer.php"; ?>
</body>

</html>
