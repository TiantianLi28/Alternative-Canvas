<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Post question Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <h3></h3>
      <?php
        # establish connection to cs377 database
        $conn = mysqli_connect("localhost",
                               "cs377", "ma9BcF@Y", "systemDB");  
        # make sure no error in connection
        if (mysqli_connect_errno()) {
          printf("Connect failed: %s\n", mysqli_connect_error());
          exit(1);
        }
        $course_number = $_POST['course_number'];
        $qid = $_POST['qid'];
        $content = $_POST['content'];
        $semester = $_POST['semester'];
        $year = $_POST['year'];
        $studentid = $_POST['student_id'];
        

        echo("You are posting a reply to question number $qid with the content $content!");

        date_default_timezone_set('America/New_York');

        $date = date('Y-m-d H:i:s');
        #insert new assignment into assignment table
    	$query="insert into thread values('$qid', '$date', '$content', '$studentid');";
       
	    # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        ?>
	<form action="qa.php" method="POST">
              <input type="hidden" name="student_id" value="<?php echo $studentid?>">
              <input type="hidden" name="course_number" value="<?php echo $course_number?>">
              <input type="hidden" name="semester" value="<?php echo $semester?>">
              <input type="hidden" name="year" value="<?php echo $year?>">
        <input type = 'submit' value = 'Click me to view your reply among other posted replies!'>
        </form>
    
      
    </div>
  </body>
</html>
 
