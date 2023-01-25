<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

// add products
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $product_name = $_POST["name"];
        $price = $_POST["price"];
        $warehouse_id = $_POST["warehouse"];
        
        $sql1 = "INSERT INTO products2 (product_name, price, warehouse_id) VALUES ('$product_name', '$price', '$warehouse_id')" ;
        if (mysqli_query($conn, $sql1) === FALSE) {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
        }
    }
// show products
        $sql2 = "SELECT products2.id, warehouse.warehouse_name, products2.product_name, products2.price
                FROM products2
                INNER JOIN warehouse
                ON products2.warehouse_id=warehouse.id";
        $result = mysqli_query($conn, $sql2);
        $data ='';
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data .= '<tr><td>'.$row['product_name'].'</td>';
                $data .= '<td>'.$row['warehouse_name'].'</td>';
                $data .= '<td>'.$row['price'].'</td></tr>';
            }
        }
// get category
        $getCategroyQuery = "SELECT id, warehouse_name FROM warehouse";
        $getCategroy = mysqli_query($conn, $getCategroyQuery);

// get category products
        $warehouseId = '';
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){ 
            $warehouseId = $_GET["warehouse"];
            $warehouse_sql ="SELECT products2.id, products2.product_name, products2.price, warehouse.warehouse_name
                            FROM products2
                            LEFT JOIN warehouse
                            ON products2.warehouse_id=warehouse.id
                            WHERE warehouse.id=".$warehouseId;

            $result = mysqli_query($conn, $warehouse_sql);
            $data ='';
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $data .= '<tr><td>'.$row['product_name'].'</td>';
                    $data .= '<td>'.$row['warehouse_name'].'</td>';
                    $data .= '<td>'.$row['price'].'</td></tr>';
                }
            }
        }

        mysqli_close($conn);
        
?>

<!DOCTYPE html>
<html>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <body>    
        <!-- show products -->
        <form action="/products.php" method="GET">
            <select name="warehouse" onchange="this.form.submit()">

                <?php if (mysqli_num_rows($getCategroy) > 0) {
                    while($row = mysqli_fetch_assoc($getCategroy)) {
                ?>
                <option value=<?php echo $row['id'] ?> <?php if($row['id'] == $warehouseId){echo("selected");}?>>
                     <?php echo $row['warehouse_name'] ?>
                </option>
                <?php }
                    }
                ?>
            </select>
        </form>
        <table>
            <tr>
                <th>name</th>
                <th>warehouse</th>
                <th>price</th>
            </tr>
            <?php echo $data; ?>
        </table>
    </body>
</html>    