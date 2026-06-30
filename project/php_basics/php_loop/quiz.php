<?php
// function odd($number){
//     for($k=1; $k<=10; $k++){
//         if($k == $number){
//             continue;
//         }
//         echo "$k <br>";
//     }
// };

// odd(6);



//function display_odd($num_passed_by_user){
    //METHOD 1
//for ($i = 1; $i <= 10; $i++) {
    // if ($i %2 !=0) {
    //   echo "$i <br>";
    // }

    //METHOD 2
    //if ($i %2 ==0) {
  //   continue;
  //  }
  //  echo "$i <br>";
//}
//     if ($i ==$num_passed_by_user) {
//      continue;
//     }
//     echo "$i <br>";
// } 
// }
// display_odd(5)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>






 <select>
  <option>please select</option>
<?php
    
for($i = 0; $i <=35; $i=$i+5) {
   if ($k= $i+5) {
       echo "<option>$i-$k</option>";
   }
  
 }
   ?>
<!-- </select> -->


<select name="yrexp" id="yrexp">
<option value="">Please Select</option>
<?php
    for($i = 0; $i <=35; $i+=5) {
        $lower = $k;
        $upper = $i +5;
       echo "<option>$i - $upper</option>";
    }
?>
</select>
</body>
</html>