<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Student Course Page </title>

        <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    </head>
    <body>
        <div class = "container"> 
            <p> 
                <?php
                $conn = mysqli_connect("localhost",
                "cs377", "ma9BcF@Y", "MyCanvas");
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit(1);
                }

                # $studentID = $_POST['userID'];
                $studentID = "A1Kcf8Z1u3";
                echo("Welcome user '$studentID'");

                # part 7a: course info

                $query1 = "SELECT course_number, semester, year, course_name FROM take, class WHERE take.classID = class.cID AND take.studentID = '$studentID' \n"
                
                if ( ! ( $result = mysqli_query($conn, $query1)) )      # Execute query
                {      
                    printf("Error: %s\n", mysqli_error($conn));
                    exit(1);
                }
                
                while($row = mysqli_fetch_assoc($result))
                {
                    foreach($row as $key => $value)
                    {
                        print($key. "=" .$value. "\n");
                    }
                    print("=========");
                }
      
                mysqli_free_result($result);
      
                mysqli_close($conn);
                
                ?>
            </p>
        </div>
    </body>
</html>