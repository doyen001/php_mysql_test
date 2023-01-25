<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // create category
    $warehouseCreateName = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["warehouseCreateName"] != ''){
        $warehouseCreateName = $_POST["warehouseCreateName"];
        
        $sql1 = "INSERT INTO warehouse (warehouse_name) VALUES ('$warehouseCreateName')" ;
        if (mysqli_query($conn, $sql1) === FALSE) {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
        }
    }

    // get category
    $getCategroyQuery = "SELECT id, warehouse_name FROM warehouse";
    $getCategroy = mysqli_query($conn, $getCategroyQuery);

    mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
    <style>
        .title-pad {
            margin-top: 10px;
        }
        .title {
            margin-left: 30px;
        }
        .tit-select {
            width: 175px;
            margin-left: 10px;
        }
    </style>
  <body>
    <!-- add product form -->
    <form action="products.php" method="post">
      <div class="title-pad">
        <span>name</span>
        <input class="title" type="text" id="name" name="name"/>
      </div>
      <div class="title-pad">
        <span>price</span>
        <input class="title" type="text" id="price" name="price" />
      </div>
      <div class="title-pad">
        <span>warehouse</span>
        <select class="tit-select" name="warehouse" id="warehouse">
            <?php if (mysqli_num_rows($getCategroy) > 0) {
                while($row = mysqli_fetch_assoc($getCategroy)) {
             ?>
            <option value=<?php echo $row['id'] ?>> <?php echo $row['warehouse_name'] ?> </option>
            <?php }
                }
            ?>
        </select>
      </div>

      <input class="title-pad" type="submit" value="Send">
    </form>

    <!-- create category -->
    <form action="/" method="POST">
        <span>Create warehouse</span>
        <input class="title" type="text" name="warehouseCreateName">
        <input class="title-pad" type="submit" value="Create">
    </form>

  </body>
</html>
