<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Transcript Page</title>
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
        
	$studentid = $_POST['studentid'];
	echo("Transcript for ");
	$query="select fname , lname from student where sid='$studentid';";
        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }

        $row = mysqli_fetch_assoc($result);
        foreach ($row as $key => $value) {
            echo("$value ");
        }
        echo(".");

        $query="select takes.course_number, course_title.course_name, takes.semester, takes.year, takes.grade from takes, course_title where course_title.course_number=takes.course_number and takes.sid= '$studentid' order by takes.year asc, takes.semester desc";
	
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
        <form action="coursepage.php" method="POST">
            <input type = "hidden" name = "studentid" value = <?php echo $studentid?>>
            <input type = 'submit' value = "Lead me back to my course page!">
        </form>
    
      
    </div>
  </body>
</html>
 
