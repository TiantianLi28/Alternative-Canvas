<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Update Assignment Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
    <?php
	$conn = mysqli_connect("localhost",
                               "cs377", "ma9BcF@Y", "systemDB");  
        # make sure no error in connection
        if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
          exit(1);
        }
            $grade=$_POST['grade'];
            $student = $_POST['sid'];
            $egname=$_POST['egassignment_name'];
	    $semester=$_POST['semester'];
        $year=$_POST['year'];
	    $course_name=$_POST['cname'];
	    $findaid="select aid from assignment where year = '$year' and semester = '$semester' and course_number = '$course_name' and name = '$egname';";
	    
	if (!( $result = mysqli_query($conn, $findaid))){
              printf("Error: %s\n", mysqli_error($conn));
              exit(1);
            }
	    $row = mysqli_fetch_assoc($result);
	        foreach ($row as $key => $value) {
            	$aid=$value;
        }

		
	    $query="update does set grade='$grade' where aid = '$aid' and sid='$student';";
            
            # execute the query
            if (!( $result = mysqli_query($conn, $query))){
              printf("Error: %s\n", mysqli_error($conn));
              exit(1);
            }
            echo ("Grade for $student entered!");
            
            ?>
      
    </div>
  </body>
</html>
