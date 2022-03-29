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
        $student = $_POST['student_id'];
        $course_number=$_POST['course_number'];
        $semester=$_POST['semester'];
        $year=$_POST['year'];
	 ?>
	<?php
 	$check="select year from takes where sid='$student' and course_number = '$course_number' and semester = '$semester' and year = '$year' union select year from teaches where sid='$student' and course_number = '$course_number' and semester = '$semester' and year = '$year' union select year from assists where sid='$student' and course_number = '$course_number' and semester = '$semester' and year = '$year';";
	
        if (!( $result = mysqli_query($conn, $check))){
          printf("Ewwwrror: %s\n", mysqli_error($conn));
          exit(1);
        }
        if(count(mysqli_fetch_all($result))==0){
        printf ("You have not been in this course, please go back and try again");?>
        <br><a href="coursepage.php">Ok I will go back and not try to view what I'm not supposed to view</a>
        <?php
        exit(1);}?>
  <form action = "qa.php", method="POST">  
        <input type="hidden" name="course_number" value="<?php echo $course_number?>">
        
        <input type="hidden" name="semester" value="<?php echo $semester?>">
        
        <input type="hidden" name="year" value="<?php echo $year?>">
        
        <input type="hidden" name="student_id" value="<?php echo $student?>">
        
        <input type="submit" value="Go to Q&A page!">
      </form>
  <?php  
       echo ("Here are all the students in $year-$semester-$course_number class.");

	    $query="select fname, lname, student.sid, grade from student, takes where student.sid=takes.sid and takes. course_number = '$course_number' and takes.semester='$semester' and takes.year='$year';";
        #printf($query);
	# execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }

        print("<div><table class=\"table table-striped\"\n");
        $header=False;
        while ($row = mysqli_fetch_assoc($result)) {
          # print the attribute names once!
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            # specify the header to be dark class
            print("<thead class=\"table-danger\"><tr>\n");
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
        ?>
        <h6>If you want to create a new assignment, enter the fields below. If not, enter N/A.</h6>
      <form action = "instructormanage.php", method="POST">  
        Enter the name of the assignment:<br>
        <input type="text" value="N/A" name="assignment_name">
        <br>
        Enter the description of the assignment:<br>
        <TEXTAREA name="content" placeholder="N/A" row=5 cols=20>
        </TEXTAREA>
        <br>
        Total point:<br>
        <input type="text" value="N/A" name="point">
        <br>
        Due-date (YYYY-MM-DD HH:MM:SS)<br>
        <input type="text" value="N/A" name="due_date">
        <br>
        <h6>If you want to view or change the assignment grades of a student, enter the fields below. If not, enter N/A.</h6>
        Student ID<br>
        <input type="text" value="N/A" name="cgsid">
        <br>
        <h6>If you want to update a student's final grade, enter the fields below. If not, enter N/A.</h6>
        Student ID<br>
        <input type="text" value="N/A" name="fgsid">
	<br>
        Studnet Final Grade <br>
        <input type="text" value="N/A" name="fggrade">
        <br>
        <input type="hidden" name="course_number" value="<?php echo $course_number?>">
        <br>
        <input type="hidden" name="semester" value="<?php echo $semester?>">
        <br>
        <input type="hidden" name="year" value="<?php echo $year?>">
        <br>
        
        <input type="submit">
      </form>
        <?php
        mysqli_free_result($result);
        mysqli_close($conn);
      ?>
      

      
    </div>
  </body>
</html>
