<?php
   //array functions

   //array_push
   $students = ["Adesewa", "Shola", "Mary"];
   //$result = array_push($students, "Rowland", "Adewale"); //This function returns something

//ARRAY POP
// $result= array_pop($students, );

//ARRAY SHIFT
//$result = array_shift($students);

//ARRAY SHIFT
$result = array_unshift($students, "Olu", "Jacob");

echo $result;
echo"<pre>";

    print_r($students);
echo"</pre>";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array function</title>
</head>
<body>

<?php
    $numbers = [23, 32, 50, 65, 12, 13, 19, 22, 24, 55];
    $oddnumber=[];
    $evennumber=[];
    
    
    foreach ($numbers as $number) {
        if ($number % 2 == 0) {
            array_push($evennumber, $number);
        } else {
            array_push($oddnumber, $number);            
        }
        
    }

    
    echo"<pre>";
    print_r($oddnumber);
    echo"</pre>";

    echo"<pre>";
    print_r($evennumber);
    echo"</pre>";
?>

    
</body>
</html>