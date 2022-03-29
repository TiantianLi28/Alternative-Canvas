<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Home Page</title>
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
	 echo "<th>".'<font color = "LightCoral">' ."Hi, view all your assignments here!" .'</font>'. "</th>";
        $student = $_POST['student_id'];
        $course_number=$_POST['course_number'];
        $semester=$_POST['semester'];
        $year=$_POST['year'];
	$check="select year from takes where sid='$student' and course_number = '$course_number' and semester = '$semester' and year = '$year';";
	if (!( $result = mysqli_query($conn, $check))){
          printf("Ewwwrror: %s\n", mysqli_error($conn));
          exit(1);
        }
	if(count(mysqli_fetch_all($result))==0){
	printf ("You have not been in this course, please go back and try again");?>
	<a href="login.php">Fine I will go back...</a>
	<?php
	exit(1);}?>
 	 
  	<form action = "qa.php", method="POST">  
        <input type="hidden" name="course_number" value="<?php echo $course_number?>">
        
        <input type="hidden" name="semester" value="<?php echo $semester?>">
        
        <input type="hidden" name="year" value="<?php echo $year?>">
        
        <input type="hidden" name="student_id" value="<?php echo $studentid?>">
        
        <input type="submit" value="Go to Q&A page!">
      </form>
  <?php 
	$query="select assignment.name, assignment.due_date, assignment.content, assignment.point, does.grade from does, assignment where does.sid='$student' and does.aid=assignment.aid and assignment.course_number='$course_number' and assignment.semester='$semester' and assignment.year='$year' ;";
        #printf($query);
	# execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }

        print("<div><table class=\"table\"\n");
        $header=False;
        while ($row = mysqli_fetch_assoc($result)) {
          # print the attribute names once!
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            # specify the header to be dark class
            print("<thead class=\"table-light\"><tr>\n");
            foreach ($row as $key => $value) {
              echo "<th>".'<font color = "PaleVioletRed">' . $key .'</font>'. "</th>";
            }
            print("</tr></thead>\n");
          }
          print("<tr>\n");     # Start row of HTML table
          foreach ($row as $key => $value) {
             echo "<th>".'<font color = "pink">' . $value .'</font>'. "</th>"; # One item in row
          }
          print ("</tr>\n");   # End row of HTML table
        }

        print("</table></div>\n");
        mysqli_free_result($result);
        mysqli_close($conn);
      ?>
      

      
    </div>
  </body>
</html>
