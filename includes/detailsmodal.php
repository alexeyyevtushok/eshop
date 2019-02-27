<?php
require_once '../core/init.php';
$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);

$brand_id = $product['brand'];
$sql2 = "SELECT brand FROM brand WHERE id = '$brand_id'";
$brand_query = $db->query($sql2);
$brand = mysqli_fetch_assoc($brand_query);

$size_string = $product['size'];
$size_array = explode(',',$size_string);
?>

<?php ob_start(); ?>
<div class="modal fade details-1" id="details-modal" tabindex="1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=$product['title']?></h4>
                <button type="button" class="close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="d-block text-center">
                                <img src="<?=$product['image']?>" alt="<?=$product['title']?>" class="img-responsive details">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h4>Details</h4>
                            <p><?=$product['description']?></p>
                            <hr>
                            <p>Price: $<?=$product['price']?></p>
                            <p>Brand: <?=$brand['brand']?></p>
                            <form action="add_cart.php" method="post">
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <label for="quantity">Quantity: </label>
                                        <input type="text" class="form-control" id="quantity" name="quantity">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <lable for="size">Size: </lable>
                                    <select name="size" id="size" class="form-control">
                                        <option value="">Tap here to choose</option>
                                        <?php foreach ($size_array as  $string) {
                                            $string_array = explode(':',$string);
                                            $size = $string_array[0];
                                            $quantity = $string_array[1];
                                            echo '<option value=".$size.">'.$size.' (Available: '.$quantity.')</option>';
                                        } ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" onclick="closeModal()">Close</button>
                <button class="btn btn-warning" type="submit">Add to cart</button>
            </div>
        </div>
    </div>
</div>
    <script>
        function closeModal(){
            $('#details-modal').modal('hide');
            setTimeout(function(){
                $('#details-modal').remove();
            },500);
        }
    </script>
<?php echo ob_get_clean(); ?>