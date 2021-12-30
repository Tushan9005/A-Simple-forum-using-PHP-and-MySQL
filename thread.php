<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <title>Welcome to iDiscuss - Coding Forums</title>
    <style>

    </style>
</head>

<body>
    <?php include 'partials/_header.php';  ?>
    <?php include 'partials/_dbconnect.php';  ?>
    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];

    }

    ?>


    <?php
    $showAlert = false;
     $method = $_SERVER['REQUEST_METHOD'];
    //  echo $method;
    if($method == 'POST')
    {
        //Insert thread into comment db
        $comment = $_POST['comment'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '0', current_timestamp());";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Comment has been added!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div> ';
        }
    }
     ?>


    <!-- Category container starts here -->
    <div class="container my-4 border border-light rounded bg-success p-2 text-dark bg-opacity-25">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $title; ?> </h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <br>
            <p class="text-left"><b>Posted by : Tushan</b></p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo'  <div class="container">
    <h1 class="py-2 ">Post a Comment</h1>
    <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your comment</label>
            <textarea class="form-control my-2" id="comment" name="comment" rows="3"></textarea>
        </div>
        <br>
        <button type="submit" class="btn btn-success">Post a comment</button>
    </form>
    <br>
</div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-4 text-decoration-underline">Post a comment</h1>
                <p class="lead">You are not logged in. Please login to post comments.</p>
            </div>';
    }
    ?>


    <div class="container">
        <h1 class="py-4">Discussions</h1>

        <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result))
    {
        $noResult = false;
        $id = $row['thread_id'];
        $content = $row['comment_content'];
        $comment_time= $row['comment_time'];
   

        echo '<div class="d-flex">
       <div class="flex-shrink-0 my-2">
         <img src="img/user1.png" width="54px" alt="...">
       </div>
       <div class="flex-grow-1 ms-3">
       <p class = "font-weight-bold my-0"><b>Anonymous User at '.$comment_time.'</b></p>
       '. $content .'
       </div>
     </div>
     <br>';

    }

    if($noResult)
    {
        echo '<div class="alert alert-dark border border-light" role="alert">
        <h1> No threads found !</h1>
        <br>

        <p>Be the first person to ask a question.</p>      
      </div>
      <br>
      <br>';
    }

    ?>


    </div>

    <?php include 'partials/_footer.php';  ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.min.js" integrity="sha384-PsUw7Xwds7x08Ew3exXhqzbhuEYmA2xnwc8BuD6SEr+UmEHlX8/MCltYEodzWA4u" crossorigin="anonymous"></script>
    -->
</body>

</html>