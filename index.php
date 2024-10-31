<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'uas_sinta';
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limit = 6; // Items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit; // Calculate offset

$totalResult = $conn->query("SELECT COUNT(*) AS total FROM artikel");
$totalRow = $totalResult->fetch_assoc();
$totalArticles = $totalRow['total'];
$totalPages = ceil($totalArticles / $limit);

$semuaartikel_sort_id = $conn->query("SELECT artikel.*, kategori.nama AS kategori_nama FROM artikel 
                        LEFT JOIN kategori ON artikel.kategori_id = kategori.id 
                        ORDER BY artikel.id DESC 
                        LIMIT $limit OFFSET $offset");

// Kueri untuk artikel trending, tanpa batasan pagination
$semuaartikel_sort_read = $conn->query("SELECT artikel.*, kategori.nama AS kategori_nama FROM artikel 
                        LEFT JOIN kategori ON artikel.kategori_id = kategori.id 
                        ORDER BY artikel.read_count DESC 
                        LIMIT $limit"); // Ambil 5 artikel teratas yang paling banyak dibaca

// Lanjutkan dengan kueri lain seperti sebelumnya
$categoryResult = $conn->query("SELECT id, nama FROM kategori");
?>


<!--
Author: W3layouts
Author URL: http://w3layouts.com
-->
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Web Programming - Final Semester Exam</title>

    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>

<body>
    <!-- header -->
    <header class="w3l-header">
        <!--/nav-->
        <nav class="navbar navbar-expand-lg navbar-light fill px-lg-0 py-0 px-3">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <span class="fa fa-pencil-square-o"></span> Web Programming Blog</a>
                <!-- if logo is image enable this   
						<a class="navbar-brand" href="#index.html">
							<img src="image-path" alt="Your logo" title="Your logo" style="height:35px;" />
						</a> -->
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon"></span> -->
                    <span class="fa icon-expand fa-bars"></span>
                    <span class="fa icon-close fa-times"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown @@category__active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Categories <span class="fa fa-angle-down"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item @@cp__active" href="technology.php">Technology posts</a>
                                <a class="dropdown-item @@ls__active" href="lifestyle.php">Lifestyle posts</a>
                            </div>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="admin/beranda.php">Admin</a>
                        </li>
                    </ul>
                </div>

                <!-- toggle switch for light and dark theme -->
                <div class="mobile-position">
                    <nav class="navigation">
                        <div class="theme-switch-wrapper">
                            <label class="theme-switch" for="checkbox">
                                <input type="checkbox" id="checkbox">
                                <div class="mode-container">
                                    <i class="gg-sun"></i>
                                    <i class="gg-moon"></i>
                                </div>
                            </label>
                        </div>
                    </nav>
                </div>
                <!-- //toggle switch for light and dark theme -->
            </div>
        </nav>
        <!--//nav-->
    </header>
    <!-- //header -->

    <div class="w3l-homeblock1">
        <div class="container pt-lg-5 pt-md-4">
            <!-- block -->
            <div class="row">
                <div class="col-lg-9 most-recent">
                    <h3 class="section-title-left">Most Recent posts </h3>
                    <div class="list-view ">
                        <?php while ($row = $semuaartikel_sort_id->fetch_assoc()): ?>
                        <div class="grids5-info img-block-mobile mb-5">
                            <div class="blog-info align-self">
                                <span class="category"><?= $row['kategori_nama'] ?></span>
                                <a href="detail.php?id=<?= $row['id'] ?>" class="blog-desc mt-0">
                                    <?= $row['judul'] ?>
                                </a>
                                <p><?= $row['deskripsi'] ?></p>
                                <div class="author align-items-center mt-3 mb-1">
                                    <a href="#author"><?= $row['penulis'] ?></a> 
                                </div>
                                <ul class="blog-meta">
                                    <li class="meta-item blog-lesson">
                                        <span class="meta-value"> <?= date('d F Y', strtotime($row['tanggal'])) ?></span>
                                    </li>
                                    <li class="meta-item blog-students">
                                        <span class="meta-value"> <?= $row['read_count'] ?> read</span>
                                    </li>
                                </ul>
                            </div>
                          
                            <a href="detail.php?id=<?= $row['id'] ?>" class="d-block zoom mt-md-0 mt-3"><img src="admin/uploads/<?= $row['foto'] ?>"
                                    alt="" class="img-fluid radius-image news-image"></a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <!-- pagination -->
                    <div class="pagination-wrapper mt-5">
                        <ul class="page-pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-numbers"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-numbers <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-numbers"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- //pagination -->
                </div>
                <div class="col-lg-3 trending mt-lg-0 mt-5 mb-lg-5">
                    <div class="pos-sticky">
                        <h3 class="section-title-left">Trending </h3>

                        <?php
                        $rowNumber = 1;
                        while ($row = $semuaartikel_sort_read->fetch_assoc()): ?>
                        <div class="grids5-info">
                            <h4><?= $rowNumber++ ?>.</h4>
                            <div class="blog-info">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="blog-desc1"><?= $row['judul'] ?></a>
                                <div class="author align-items-center mt-2 mb-1">
                                    <a href="#author"><?= $row['penulis'] ?></a> 
                                    <br>
                                    <a href="#author">Kategori : <?= $row['kategori_nama'] ?></a> 
                                </div>
                                <ul class="blog-meta">
                                    <li class="meta-item blog-lesson">
                                        <span class="meta-value"> <?= date('d F Y', strtotime($row['tanggal'])) ?></span>
                                    </li>
                                    <li class="meta-item blog-students">
                                        <span class="meta-value"> <?= $row['read_count'] ?> read</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <!-- //block-->

            <!-- ad block -->
            <!-- <div class="ad-block text-center mt-5">
                <a href="#url"><img src="assets/images/ad.gif" class="img-fluid" alt="ad image" /></a>
            </div> -->
            <!-- //ad block -->

        </div>
    </div>
    <!-- footer -->
    <footer class="w3l-footer-16">
        <div class="footer-content py-lg-5 py-4 text-center">
            <div class="container">
                <div class="copy-right">
                    <h6>© 2024 Web Programming Blog . Made by <i>(Sinta)</i> with <span class="fa fa-heart" aria-hidden="true"></span><br>Designed by
                        <a href="https://w3layouts.com">W3layouts</a> </h6>
                </div>
                <ul class="author-icons mt-4">
                    <li><a class="facebook" href="#url"><span class="fa fa-facebook" aria-hidden="true"></span></a>
                    </li>
                    <li><a class="twitter" href="#url"><span class="fa fa-twitter" aria-hidden="true"></span></a></li>
                    <li><a class="google" href="#url"><span class="fa fa-google-plus" aria-hidden="true"></span></a>
                    </li>
                    <li><a class="linkedin" href="#url"><span class="fa fa-linkedin" aria-hidden="true"></span></a></li>
                    <li><a class="github" href="#url"><span class="fa fa-github" aria-hidden="true"></span></a></li>
                    <li><a class="dribbble" href="#url"><span class="fa fa-dribbble" aria-hidden="true"></span></a></li>
                </ul>
                <button onclick="topFunction()" id="movetop" title="Go to top">
                    <span class="fa fa-angle-up"></span>
                </button>
            </div>
        </div>

        <!-- move top -->
        <script>
            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function () {
                scrollFunction()
            };

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    document.getElementById("movetop").style.display = "block";
                } else {
                    document.getElementById("movetop").style.display = "none";
                }
            }

            // When the user clicks on the button, scroll to the top of the document
            function topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        </script>
        <!-- //move top -->
    </footer>
    <!-- //footer -->

    <!-- Template JavaScript -->
    <script src="assets/js/theme-change.js"></script>

    <script src="assets/js/jquery-3.3.1.min.js"></script>

    <!-- disable body scroll which navbar is in active -->
    <script>
        $(function () {
            $('.navbar-toggler').click(function () {
                $('body').toggleClass('noscroll');
            })
        });
    </script>
    <!-- disable body scroll which navbar is in active -->

    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>