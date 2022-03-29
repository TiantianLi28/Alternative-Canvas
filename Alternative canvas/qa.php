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
        
        echo "<th>".'<font color = "ForestGreen">' ."Hi, $studentid, You have reached the question and answer page for $course_number!" .'</font>'. "</th>";
	
        ?>
        
        <?php
        $query="select qid as question_number, title, content, sid as posted_by, time_posted from question where course_number='$course_number' and semester = '$semester' and year = '$year';";

        # execute the query
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
	$checkempty = mysqli_fetch_all($result);
        if(count($checkempty)==0){
	  echo "<th>".'<font color = "ForestGreen">' ."Sadly this class does not have a Q&A page, contact your instruct to request one!" .'</font>'. "</th>";
         
          exit(1);
        }
        print("<div><table class=\"table table-borderless\"\n");
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
            print("<thead class=\"table-success\"><tr>\n");
            foreach ($row as $key => $value) {
              
	      echo "<th>".'<font color = "SeaGreen">' .$key .'</font>'. "</th>";
            }

            print("</tr></thead>\n");
          }
          print("<tr>\n");     # Start row of HTML table
          foreach ($row as $key => $value) {
            echo "<th>".'<font color = "MediumSeaGreen">' .$value .'</font>'. "</th>"; # One item in row
          }
          print ("</tr>\n");
          $questionId=$row['question_number'];
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
                    echo "<th>".'<font color = "MediumTurquoise">' .$val .'</font>'. "</th>"; # One item in row
                  } 
            print ("</tr>\n");
          }
             # End row of HTML table
        }
        print("</table></div>\n");
        ?>
	<h6>I want to filter the questions by tags!</h6>
        <?php
	print("<tr>\n"); 
        $query="select distinct tag from tags where course_number= '$course_number' and semester = '$semester' and year = '$year' order by tag asc;";
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        while ($row = mysqli_fetch_assoc($result)) {
          $tag=$row['tag'];
        ?>
        <form action="filtered.php" method="POST">
          <input type = "checkbox" name = "tags[]" value= "<?php echo $tag ?>"> <?php echo $tag ?><br>
        <?php
        }
        ?>
        <input type="hidden" name="course_number" value="<?php echo $course_number?>">
        <input type="hidden" name="semester" value="<?php echo $semester?>">
        <input type="hidden" name="year" value="<?php echo $year?>">
        
        <input type = 'submit' value = 'filter accordingly please'>
	</form>
	<p>
	<?php
	print ("</tr>\n");?>
	<h6>I want to post a question!</h6>
	</p>
	<form action="post_question.php" method="POST">
        Title:<br>
        <input type = "text" name = "title"><br>
        Tags:<br>
        <?php
        $query="select distinct tag from tags where course_number= '$course_number' and semester = '$semester' and year = '$year' order by tag asc;";
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        while ($row = mysqli_fetch_assoc($result)) {
          $tag=$row['tag'];
        ?>
          <input type = "checkbox" name = "tags[]" value= "<?php echo $tag ?>"> <?php echo $tag ?><br>
        <?php
        }
        ?>
        Content:<br>
        <input type = "text" name = "content"><br>
        <input type="hidden" name="course_number" value="<?php echo $course_number?>">
        <input type="hidden" name="semester" value="<?php echo $semester?>">
        <input type="hidden" name="year" value="<?php echo $year?>">
	      <input type="hidden" name="student_id" value="<?php echo $studentid?>">
        <input type = 'submit' value = 'Post my question please!'>
        </form>
	<p>I want to post a reply to a question!</p>
      	<form action="post_reply.php" method="POST">
        Question_number:<br>
        <input type = "text" name = "qid"><br>
        Reply:<br>
        <input type = "text" name = "content"><br>
        <input type="hidden" name="course_number" value="<?php echo $course_number?>">
        <input type="hidden" name="semester" value="<?php echo $semester?>">
        <input type="hidden" name="year" value="<?php echo $year?>">
	      <input type="hidden" name="student_id" value="<?php echo $studentid?>">
        <input type = 'submit' value = 'Post my reply please!'>
        </form>

    
      
    </div>
  </body>
</html>
 
