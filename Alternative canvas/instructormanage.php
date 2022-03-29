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
        $assignment_name=$_POST['assignment_name'];
        $point=$_POST['point'];
        $due_date=$_POST['due_date'];
        $egassignment_name=$_POST['egassignment_name'];
        $grade=$_POST['grade'];
        $cgsid=$_POST['cgsid'];
        $fgsid=$_POST['fgsid'];
        $student = $_POST['sid'];
        $course_number=$_POST['course_number'];
        $semester=$_POST['semester'];
        $year=$_POST['year'];
        $final_grade=$_POST['fggrade'];

        if(strcmp($assignment_name, "N/A")!=0){
        #add assignment
        #first find last aid:

        $query="select max(aid) from assignment;";
        
        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($row as $key => $value) {
                $aid=$value+1;
            }
          } 
    
        #insert new assignment into assignment table
    	$query="insert into assignment values('$course_number', '$semester', '$year', '$assignment_name', '$due_date', '$content', '$aid');";
        
	    # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        
        
        #insert new assignment into does table
        $findStudent="select sid from takes where course_number='$course_number' and semester='$semester' and year='$year';";
        if (!( $result = mysqli_query($conn, $findStudent))){
            printf("Error: %s\n", mysqli_error($conn));
            exit(1);
          }
          while ($row = mysqli_fetch_assoc($result)) {
            foreach ($row as $key => $sid) {
                $query="insert into does values('$sid',-1,'$aid');";
                # execute the query
                if (!( $result = mysqli_multi_query($conn, $query))){
                  printf("Error: %s\n", mysqli_error($conn));
                  exit(1);
                } 
            }
          }  
          echo ("New assignment created!");
        }
        
        if(strcmp($cgsid, "N/A")!=0){
            #check all assignment grade for a student 
            
        $query="select name, sid, grade from does, assignment where does.sid='$cgsid' and does.aid=assignment.aid and assignment.course_number = '$course_number' and assignment.semester='$semester' and assignment.year='$year';";
        
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
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value) {
              print "<th>" . $key . "</th>";
            }
            print("</tr></thead>\n");
          }
          print("<tr>\n");     # Start row of HTML table
          foreach ($row as $key => $value) {
            if ($value == -1){
              print("<td>" . "In progress" . "</td>");
            }
            else{
            print ("<td>" . $value . "</td>"); } # One item in row
          }
          print ("</tr>\n");   # End row of HTML table
        } print("</table></div>\n");
        ?>
        <h6>If you want to enter an assignment grade for a student, enter the fields below.</h6>
        <form action = "updateassignment.php", method="POST"> 
        Assignment name<br>
        <input type="text" value="N/A" name="egassignment_name">
        <br>
        Grade<br>
        <input type="text" value="N/A" name="grade">
        <input type="hidden" name = "sid" value = <?php echo $cgsid ?>>
        <input type="hidden" name = "semester" value = <?php echo $semester ?>>
        <input type="hidden" name = "year" value = <?php echo $year?>>
        <input type="hidden" name = "cname" value = <?php echo $course_number ?>>
	
        <input type = "submit" value = "update grade" >
        <br> 
        </form>
        <?php
        }

        
        mysqli_free_result($result);
        mysqli_close($conn);
      ?>
      

      
    </div>
  </body>
</html>
