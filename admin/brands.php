<?php
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';
require_once '../core/init.php';

$sql = "SELECT * FROM brand ORDER BY brand";
$results = $db->query($sql);
$errors = array();
//Edit brand
if(isset($_GET['edit'])  && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql5 = "SELECT * FROM brand WHERE id = '$edit_id'";
    $edit_result = $db->query($sql5);
    $eBrand = mysqli_fetch_assoc($edit_result);
}

//Delete brand
if(isset($_GET['delete'])  && !empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql4 = "DELETE FROM brand WHERE id='$delete_id'";
    $db->query($sql4);
    header('Location: brands.php');
}


//if form is submitted
if(isset($_POST['add_submit'])){
    $brand = sanitize($_POST['brand']) ;
    //check if brand is blank
    if($brand == ''){
        $errors[] .= 'You must enter a brand.';
    }
    //edit brand
    $sql2 = "SELECT * FROM brand WHERE brand='$brand'";
    if(isset($_GET['edit'])){
        $sql2 = "SELECT * FROM brand WHERE brand='$brand' AND id!= '$edit_id'";
    }
    $result2 = $db->query($sql2);
    $count = mysqli_num_rows($result2);
    if($count>0){
        $errors[] .= $brand. ' brand already exist.';
    }
    //display errors or edit db
    if(!empty($errors)){
        echo display_errors($errors);
    } else {
        //addition or edition of brand
        $sql3="INSERT INTO brand(brand) VALUES ('$brand')";
        if(isset($_GET['edit'])){
            $sql3 = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
        }
        $db->query($sql3);
        header('Location: brands.php');
    }
}

?>
<div class="col-lg-12">
    <hr><h2 class="admin_headline">Brands editor</h2><hr>
</div>

</div>
<div class="row">
<div class="brand-form">
    <form action="brands.php<?=((isset($_GET['edit']))) ? '?edit='.$edit_id :'' ?>" method="post">
        <div class="form-row align-items-center">
            <?php
            $brand_value = '';
            if(isset($_GET['edit'])){
                $brand_value = $eBrand['brand'];
            } else if(isset($_POST['brand'])){
                $brand_value =sanitize($_POST['brand']);
            }
            ?>
            <div class="col-auto">
                <label class="sr-only" for="brand">Brand</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><span class="fab fa-acquisitions-incorporated"></span></div>
                    </div>
                    <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand name" value="<?=$brand_value;?>">
                    <?php if(isset($_GET['edit'])) : ?>
                        <a href="brands.php" class="btn btn-secondary" style="margin-left:10px">Cancel</a>
                    <?php endif;?>
                </div>
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2" name="add_submit"><?=((isset($_GET['edit']))) ? 'Submit edition' : 'Add brand';?></button>
            </div>
        </div>
    </form>
</div>
<table class="table  table-bordered table-striped">
    <thead>
        <th>Brand</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
    <?php while($brand = mysqli_fetch_assoc($results)) : ?>
        <tr>
            <td><?=$brand['brand'];?></td>
            <td><a href="brands.php?edit=<?=$brand['id'];?>" class="btn btn-sm btn-link"><span class="fas fa-pencil-alt"> Click to edit</span></a></td>
            <td><a href="brands.php?delete=<?=$brand['id'];?>" class="btn btn-sm btn-link"><span class="fas fa-trash-alt"> Click to delete</span></a></td>
        </tr>
    <?php endwhile;?>
    </tbody>
</table>

<?php
include 'includes/footer.php';
?>


