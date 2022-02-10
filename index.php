<?php
$server = "localhost";
$dbname = "travellog";
$username = "root";
$password = "";

$con = mysqli_connect($server, $username, $password,$dbname);
//var_dump($con);
if(!$con){
      die(mysqli_connect_error());
}
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$country = $_POST['country'];

$visitingcountries = $_POST['visitingcountries'];
$dates = $_POST['dates'];
$result = $con->query("SELECT * FROM travellog.adda WHERE email = '{$email}' limit 1");
if($result->num_rows == 0){
      $sql = "INSERT INTO `adda` (`fname`, `lname`, `email`, `phone`, `country`) VALUES ('{$fname}', '{$lname}', '{$email}', '{$phone}', '{$country}')";
      if($con->query($sql) == true){
            echo "You have successfully submitted the details";
      }
      else{
            mysqli_error($con);
      }
      $sql= "INSERT INTO travel(`visitingcountries`, `dates`, `userid`)VALUES('{$visitingcountries}', '{$dates}', (SELECT userid from adda where email = '{$email}'))";
}
else{
      $sql = "INSERT INTO travel(`visitingcountries`, `dates`, `userid`)VALUES('{$visitingcountries}', '{$dates}', (SELECT userid from adda where email = '{$email}'))";
      if($con->query($sql) == true){
            echo "You have successfully submitted the details";
      }
      else{
            mysqli_error($con);
      }
}
?>
<?php
//CREATING HTML FORM FOR THE SUBMITTED DATA
$result = $con->query("SELECT adda.userid, adda.fname, adda.lname, travel.visitingcountries, travel.dates FROM adda RIGHT JOIN travel on adda.userid = travel.userid");
echo "<table border='1'>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Visiting Countries</th>
<th>Date</th>
</tr>";
echo"<tr>";
while($row = $result->fetch_assoc()){
      echo "<tr>";
      echo "<td>" . $row['fname'] . "</td>";
      echo "<td>" . $row['lname'] . "</td>";
      echo "<td>" . $row['visitingcountries'] . "</td>";
      echo "<td>" . $row['dates'] . "</td>";
      echo "</tr>";
}