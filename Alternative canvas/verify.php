<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <?php
        $studentid=$_POST['studentid'];
        $loginid=$_POST['loginid'];
        # establish connection to cs377 database
        $conn = mysqli_connect("localhost",
                               "cs377", "ma9BcF@Y", "systemDB");  
        # make sure no error in connection
        if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
          exit(1);}
        echo("Hi, $studentid, let me see if you are a user of our system...");
        $query="select sid from student where sid='$studentid' and login_id='$loginid';";
	
        if (!( $result = mysqli_query($conn, $query))){
            printf("Error: %s\n", mysqli_error($conn));
            exit(1);
          }
        $res=mysqli_fetch_all($result);
        if (count($res)==0){
            echo("Your student id and login id do not match, please go back and check again!");
            exit(1);
        }
        else{
            echo("You are a user!");
            ?>
            <form action="coursepage.php" method="POST">
            <input type = "hidden" name = "studentid" value = <?php echo $studentid?>>
	    <input type = 'submit' value = "Lead me to my course page!">
        </form>
            <?php
        }
        mysqli_free_result($result);
        mysqli_close($conn);
      ?>
      
    </div>
  </body>
</html>
