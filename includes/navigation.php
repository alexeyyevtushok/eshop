<!---Top nav bar--->
<?php
$sql = "SELECT * FROM categories  WHERE parent = 0";
$parent_query = $db->query($sql);
?>


<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a href="index.php" class="navbar-brand navbar-fixed-top">Clothes Shop</a>
        <ul class="nav navbar-nav">
            <?php while ($parent = mysqli_fetch_assoc($parent_query)) : ?>
            <?php $parent_id  = $parent['id'];
            $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
            $child_query = $db->query($sql2);
            ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo  $parent['ctgry_name']?><span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <?php while ($child= mysqli_fetch_assoc($child_query)) : ?>
                    <li><a href="#" class="dropdown-item"><?php echo  $child['ctgry_name']?></a></li>
                    <?php endwhile; ?>
                </ul>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>
</nav>