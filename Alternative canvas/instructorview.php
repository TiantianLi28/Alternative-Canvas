<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Instructor Page</title>
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
        # get the query that was posted
	
        $studentid = $_POST['student_id'];
        
        $query="select fname from teaches, student where teaches.sid=student.sid and student.sid='$studentid';";

        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }

        if (count(mysqli_fetch_all($result))==0){
	$query="select fname from student where sid='$studentid';";

        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
          $row = mysqli_fetch_assoc($result);
          foreach ($row as $key => $value) {
            echo("Hi $value, you have not taught any course.");
        }}
        else{
	$query="select fname from student where sid='$studentid';";

        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
          $row = mysqli_fetch_assoc($result);
          foreach ($row as $key => $value) {
            echo("Hi $value, here are the courses that you have taught.");
        }
        }

        $query="select course_number, semester, year from teaches where sid='$studentid';";
        print("<div><table class=\"table table-striped\"\n");
        $header=False;
        if (!( $result = mysqli_query($conn, $query))){
            printf("Error: %s\n", mysqli_error($conn));
            exit(1);
          }
        while ($row = mysqli_fetch_assoc($result)) {
          # print the attribute names once!
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            # specify the header to be dark class
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value) {
              print "<th>" . $key . "</th>";
            }
            print("</tr></thead>\n");
          }
          print("<tr>\n");     # Start row of HTML table
          foreach ($row as $key => $value) {
            print ("<td>" . $value . "</td>"); # One item in row
          }
          print ("</tr>\n");   # End row of HTML table
        }

        print("</table></div>\n");
        

        $querya="select course_number, semester, year  from assists where sid='$studentid';";
        if (!( $result = mysqli_query($conn, $querya))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        if (count(mysqli_fetch_all($result))==0){
        $query="select fname from student where sid='$studentid';";

        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        } 
	 $row = mysqli_fetch_assoc($result);
          foreach ($row as $key => $value) {
            echo("Hi $value, you have not assisted in teaching any course.");
        }}
        else{
        $query="select fname from student where sid='$studentid';";

        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        } 
	 $row = mysqli_fetch_assoc($result);
          foreach ($row as $key => $value) {
            echo("Hi $value, here are the courses that you have assisted in teaching.");
        }
        }
        
        $query="select course_number, semester, year from assists where sid='$studentid';";
        print("<div><table class=\"table table-striped\"\n");
        $header=False;
        if (!( $result = mysqli_query($conn, $query))){
            printf("Error: %s\n", mysqli_error($conn));
            exit(1);
          }
        while ($row = mysqli_fetch_assoc($result)) {
          # print the attribute names once!
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            # specify the header to be dark class
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value) {
              print "<th>" . $key . "</th>";
            }
            print("</tr></thead>\n");
          }
          print("<tr>\n");     # Start row of HTML table
          foreach ($row as $key => $value) {
            print ("<td>" . $value . "</td>"); # One item in row
          }
          print ("</tr>\n");   # End row of HTML table
        }

        print("</table></div>\n");

        mysqli_free_result($result);
        mysqli_close($conn);
      ?>
      <h6>Enter the course you want to view</h6>
      <form action = "instructorcourseview.php", method="POST">  
        Course Number (eg. CS377)<br>
        <input type="text" name="course_number">
        <br>
        Semester Taken (eg. Fall)<br>
        <input type="text" name="semester">
        <br>
        Year Taken (eg. 2019)<br>
        <input type="text" name="year">
        <br>
        <input type="hidden" name="student_id" value="<?php echo $studentid?>">
        <br>
        <input type="submit">
      </form>
      
    </div>
  </body>
</html>
 
