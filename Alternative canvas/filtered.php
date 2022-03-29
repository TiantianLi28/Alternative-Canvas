<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Q&A Page</title>
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
	
        $semester = $_POST['semester'];
        $year = $_POST['year'];
        $studentid = $_POST['student_id'];
        $tags=$_POST['tags'];
   
        echo("Here are the filtered question posts for $course_number!");

        $query="select question.qid, title, content, sid, time_posted from question, tags where tags.qid= question.qid and question.qid in";
        for ($i=0; $i<count($tags); $i++){
            if ($i==0){
                $query= $query . "(select question.qid from question, tags where tags.qid=question.qid and question.course_number='$course_number' and question.semester = '$semester' and question.year = '$year' and tags.tag='$tags[$i]') ";
            }
            else {
                $query= $query . " and question.qid in (select question.qid from question, tags where tags.qid=question.qid and question.course_number='$course_number' and question.semester = '$semester' and question.year = '$year' and tags.tag='$tags[$i]')";
            }
        }
	$query=$query."group by question.qid, title, content, sid, time_posted;";
        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }

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
            print("<thead class=\"table-primary\"><tr>\n");
            foreach ($row as $key => $value) {
              print "<th>" . $key . "</th>";
            }

            print("</tr></thead>\n");
          }
          print("<tr>\n");     # Start row of HTML table
          foreach ($row as $key => $value) {
            print ("<td>" . $value . "</td>"); # One item in row
          }
          print ("</tr>\n");
          $questionId=$row['qid'];
          $Findthread="select content, sid, time_posted from thread where qid= '$questionId' order by time_posted asc;";
          if (!( $resultthread = mysqli_query($conn, $Findthread))){
            printf("Error: %s\n", mysqli_error($conn));
            exit(1);
          }
          while ($threadrow = mysqli_fetch_assoc($resultthread)){
            print("<tr>\n");
                for($i =0; $i < 2; $i ++){
                    print ("<td>" . " " . "</td>");
                }
                foreach ($threadrow as $feat => $val) {
                    print ("<td>" . $val . "</td>"); # One item in row
                  } 
            print ("</tr>\n");
          }
             # End row of HTML table
        }
        print("</table></div>\n");
        ?>
        
    
      
    </div>
  </body>
</html>
 
