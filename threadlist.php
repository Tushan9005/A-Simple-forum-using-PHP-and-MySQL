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
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];

    }

    ?>

    <?php
    $showAlert = false;
     $method = $_SERVER['REQUEST_METHOD'];
    //  echo $method;
    if($method == 'POST')
    {
        //Insert thread into db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$th_title', '$th_desc', '$id', '0', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added! Please wait for the community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div> ';
        }
    }


     ?>


    <!-- Category container starts here -->
    <div class="container my-4 border border-light rounded p-3 mb-2 bg-dark text-white">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forums</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Browse topics</a>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo'<div class="container">
        <h1 class="py-4 text-decoration-underline">Start a discussion</h1>


        <form class="bg-success p-2 text-dark bg-opacity-25" action="'.$_SERVER["REQUEST_URI"].'" method="post">
        <div class="mb-3  ">
            <label for="exampleInputEmail1" class="form-label">Problem Title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible.</div>
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="desc" name="desc"></textarea>
            <label for="floatingTextarea">Elaborate your concerns</label>
        </div>
            <br>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

        <br>
        <br>

    </div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-4 text-decoration-underline">Start a discussion</h1>
                <p class="lead">You are not logged in. Please login to start a discussion.</p>
            </div>';
    }
    ?>

    <div class="container">
    
    <h1 class="py-4 text-decoration-underline">Browse Questions</h1>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result))
    {
        $noResult = false;
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_time = $row['timestamp'];
   
     echo '<div class="d-flex">
        <div class="flex-shrink-0 my-2 py-2">
          <img src="img/user1.png" width="54px" alt="...">
        </div>
        <div class="flex-grow-1 ms-3">
        <p class = "font-weight-bold my-0"><b>Anonymous User at '.$thread_time.'</b></p>
        <h5 class="mt-0"><a class = "text-dark "  href = "thread.php?threadid='. $id .'">'. $title .'</a></h5>
                 '. $desc .'
        </div>
      </div>';
      
   


        // <div class="media my-3">
        //     <img src="user1.png" width="35px" class="mr-3" alt="...">
        //     <div class="media-body">
        //         <h5 class="mt-0"><a class = "text-dark "  href = "thread.php?threadid='. $id .'">'. $title .'</a></h5>
        //         '. $desc .'
        //     </div>
        // </div>';

    }

    if($noResult)
    {
        echo '<div class="alert alert-dark border border-light" role="alert">
        <h1> No threads found !</h1>
        <br>

        <p>Be the first person to ask a question.</p>      
      </div>';
    }
    ?>
    <br>
    <br>
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