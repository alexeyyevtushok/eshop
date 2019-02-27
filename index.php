<?php
    require_once  'core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    include 'includes/headerfull.php';
    include 'includes/leftbar.php';

    $sql =  "SELECT * FROM products  WHERE featured = 1";
    $featured = $db->query($sql);
?>
    <!-- Main content-->
<div class="col-lg-8">
        <h2 class="text-center">
            Featured Products
        </h2>
    <div class="row">
        <?php while ($featured_products = mysqli_fetch_assoc($featured)) : ?>
        <div class="col-lg-3">
            <h4><?=$featured_products['title']; ?></h4>
            <img src="<?=$featured_products['image']; ?>" alt="<?=$featured_products['title']; ?>" class="img-cart">
            <p class="list-price text-danger">List Price: <s>$<?=$featured_products['list_price']; ?></s></p>
            <p class="price">Our price: $<?=$featured_products['price']; ?></p>
            <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $featured_products['id']; ?>)" ">Details</button>
        </div>
        <?php endwhile;?>
    </div>
</div>

<?php
    /*include 'includes/detailsmodal.php';*/
    include 'includes/rightbar.php';
    include 'includes/footer.php';
?>
