<?php
$host = "127.0.0.1";
$database = "animals";
$user = "root";
$password = "";

//csatlakozás adatbázishoz
$conn = new mysqli($host, $user, $password, $database);

//csatlakozás ellenőrzése
if ($conn->connect_error) {
  die("Connection failes: ". $conn->connect_error);//ha szopó van kiírja a hibát
}

if (isset($_POST['allat']) && isset($_POST['faj']) && isset($_POST['elohely']) && isset($_POST['kozeg'])) {
  $animal = $_POST['allat'];
  $class = $_POST['faj'];
  $place = $_POST['elohely'];
  $asd = $_POST['kozeg'];

  $new_animal = $conn->query("INSERT INTO allatok (allat, faj, elohely, kozeg)
                              VALUES('$animal', '$class', '$place', '$asd')");

  if ($new_animal) {
    echo "Sikeresen felvettük az új állatot";
  }else {
    echo "Nem sikerült felvenni az új állatot";
  }
}

if (isset($_POST['modify_form']) && isset($_POST['modify_elohely'])) {
  $animalId = $conn->real_escape_string($_POST['modify_form']);
  $animalPlace = $conn->real_escape_string($_POST['modify_elohely']);

  $updateAniml = $conn->query("UPDATE allatok SET elohely = '$animalPlace' WHERE id = $animalId");
}

//kveri létrehozása az állatok lekérdezéséhez
$listingAnimalsQuery = $conn->query("SELECT * FROM allatok");

//állatok kilistázása
while ($row = $listingAnimalsQuery->fetch_assoc()) {
  echo "Allat: ".$row['allat']."<br>";
  echo "Faj: ".$row['faj']."<br>";
  echo "Élőhely: ".$row['elohely']."<br>";
  echo "Közeg: ".$row['kozeg']."<br>";
  echo "<a href=?modify_id=".$row['id'].">Szerkesztés</a><br><br>";

  if (isset($_GET['modify_id'])) {
    if ($_GET['modify_id'] == $row['id']) {?>
      <form class="" method="post">
        <input type="hidden" name="modify_form" value="<?php echo $row['id']?>">
        <input type="text" name="modify_elohely" value="<?php echo $row['elohely']?>">
        <input type="submit" name="submit" value="Módosítás">
      </form>
<?php
    }
  }
}
?>


<form class="" method="post">
  <input type="text" name="allat" value="" placeholder="állat"><br>
  <input type="text" name="faj" value="" placeholder="faj"><br>
  <input type="text" name="elohely" value="" placeholder="élőhely"><br>
  <input type="text" name="kozeg" value="" placeholder="közeg"><br>
  <input type="submit" name="submit" value="Feltöltés">
</form>
