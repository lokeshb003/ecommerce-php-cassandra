<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kodekloud E-Commerce</title>
    <!-- Favicon -->
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon CSS-->
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/linearicons/linearicons-1.0.0.css">
    <!-- Animations CSS-->
    <link rel="stylesheet" href="vendors/wow-js/animate.css">
    <!-- owl_carousel-->
    <link rel="stylesheet" href="vendors/owl_carousel/owl.carousel.css">
    <!-- Theme style CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Include Cassandra PHP Driver -->
    <?php
    require_once 'vendor/autoload.php';
    use Cassandra;
    ?>

</head>
<body>
    <!--==========Main Header==========-->
    <header class="main_header_area">
        <!-- ... Your existing header code ... -->
    </header>
    <!--==========Main Header==========-->

    <!--==========Slider area==========-->
    <section class="slider_area row m0">
        <!-- ... Your existing slider code ... -->
    </section>
    <!--==========End Slider area==========-->

    <section class="best_business_area row">
        <div class="check_tittle wow fadeInUp" data-wow-delay="0.7s" id="product-list">
            <h2>Product List</h2>
        </div>
        <div class="row it_works">
            <?php
            $cluster = Cassandra::cluster()
                ->withContactPoints('127.0.0.1') // Replace with your Cassandra cluster contact points
                ->build();
            $session = $cluster->connect('your_keyspace'); // Replace with your keyspace name

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $imageUrl = $_POST['imageUrl'];
                $price = $_POST['price'];

                $statement = $session->prepare("INSERT INTO your_table (name, imageUrl, price) VALUES (?, ?, ?)");
                $boundStatement = $statement->bind($name, $imageUrl, $price);
                $session->execute($boundStatement);

                // Redirect or show a success message
            }

            $res = $session->execute("SELECT * FROM products");
            foreach ($res as $row) {
                echo '<div class="col-md-3 col-sm-6 business_content">';
                echo '<img src="img/' . $row['imageurl'] . '" alt="">';
                echo '<div class="media">';
                echo '<div class="media-left"></div>';
                echo '<div class="media-body">';
                echo '<a href="#">' . $row['name'] . '</a>';
                echo '<p>Purchase ' . $row['name'] . ' at the lowest price <span>' . $row['price'] . '$</span></p>';
                echo '</div></div></div>';
            }
            ?>
        </div>
    </section>

    <footer class="footer_area row">
        <!-- ... Your existing footer code ... -->
    </footer>

    <!-- jQuery -->
    <script src="js/jquery-1.12.4.min.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Wow js -->
    <script src="vendors/wow-js/wow.min.js"></script>
    <!-- Wow js -->
    <script src="vendors/Counter-Up/waypoints.min.js"></script>
    <script src="vendors/Counter-Up/jquery.counterup.min.js"></script>
    <!-- Stellar js -->
    <script src="vendors/stellar/jquery.stellar.js"></script>
    <!-- owl_carousel js -->
    <script src="vendors/owl_carousel/owl.carousel.min.js"></script>
    <!-- Theme js -->
    <script src="js/theme.js"></script>
</body>
</html>
