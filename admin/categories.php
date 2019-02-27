<?php
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';
require_once '../core/init.php';

$sql = "SELECT * FROM categories WHERE parent = 0";
$result = $db->query($sql);
$errors = array();
$category = '';
$post_parent = '';

//Edit category
if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $edit_sql = "SELECT * FROM categories WHERE id='$edit_id'";
    $edit_result = $db->query($edit_sql);
    $category_toedit = mysqli_fetch_assoc($edit_result);

}
//Delete category
if(isset($_GET['delete'])  && !empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    //delete parent and subcategories
    $pdelete_sql = "SELECT * FROM categories WHERE id='$delete_id'";
    $pdelete = $db->query($pdelete_sql);
    $category_todelete = mysqli_fetch_assoc($pdelete);
    if($category_todelete['parent'] =='0'){
        $sql = "DELETE FROM categories WHERE parent='$delete_id'";
        $db->query($sql);
    }
    //delete category
    $delete_sql = "DELETE FROM categories WHERE id='$delete_id'";
    $db->query($delete_sql);

    header('Location: categories.php');
}

//Process Form
if(isset($_POST) && !empty($_POST)){
    $post_parent = sanitize($_POST['parent']);
    $category = sanitize($_POST['category']);

    //if category is blank
    if($category == ''){
        $errors[] .= 'The category can not be left blank';
    }
    //If exist in DB
    $sql_form = "SELECT * FROM categories WHERE ctgry_name='$category' AND parent ='$post_parent'";
    //edit
    if(isset($_GET['edit'])){
        $id = $category_toedit['id'];
        $sql_form = "SELECT * FROM categories WHERE ctgry_name='$category' AND parent='$post_parent' AND id!='$id'";
    }
    $form_result = $db->query($sql_form);
    $count = mysqli_num_rows($form_result);
    if($count>0){
        $errors[] .= $category. ' category already exist.';
    }
    //Display errors or edit db
    if(!empty($errors)){
        echo display_errors($errors);
    } else {
        //addition or edition of db
        $update_sql = "INSERT INTO categories(ctgry_name,parent) VALUES ('$category','$post_parent')";
        if(isset($_GET['edit'])){
            $update_sql = "UPDATE categories SET ctgry_name = '$category',parent = '$post_parent' WHERE id='$edit_id'";
        }
        $db->query($update_sql);
        header('Location: categories.php');
    }
}
//input value in 'category' blank if edit is checked
$category_value = '';
$parent_value = 0;
if(isset($_GET['edit'])){
    $category_value = $category_toedit['ctgry_name'];
    $parent_value = $category_toedit['parent'];

} else if(isset($_POST)){
    $category_value = $category;
    $parent_value = $post_parent;
}
?>
<div class="col-lg-12">
    <hr><h2 class="admin_headline">Categories editor</h2><hr>
</div>

</div>
<div class="row">
    <!--Form-->
    <div class="category_form">
        <form action="categories.php<?=((isset($_GET['edit'])))?'?edit='.$edit_id:''?>" class="form" method="post">
            <div class="form-inline">
                <!--Parent-->
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text font-weight-bold">Parent: </div>
                    </div>
                    <select name="parent" id="parent" class="form-control">
                        <option value="0" <?=(($parent_value==0))?'selected="selected"':'';?>">Parent</option>
                        <?php while($parent = mysqli_fetch_assoc($result)): ?>
                            <option value="<?=$parent['id']?>" <?=(($parent_value==$parent['id']))?'selected="selected"':'';?>><?=$parent['ctgry_name']?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!--Category-->
                <div class="input-group mb-2" style="margin:0 10px">
                    <div class="input-group-prepend">
                        <div class="input-group-text font-weight-bold">Category: </div>
                    </div>
                    <input type="text" class="form-control" id="category" name="category" value="<?=$category_value?>">
                </div>
                <!--Edition field-->
                <?php if(isset($_GET['edit'])) : ?>
                <div class="input-group mb-2">
                    <a href="categories.php" class="btn btn-secondary" style="margin-right:10px">Cancel</a>
                </div>
                <?php endif;?>
                <div class="input-group mb-2">
                    <input type="submit" value="<?=((isset($_GET['edit'])))?'Submit edition':'Add category'?>" class="btn btn-success">
                </div>


            </div>

        </form>
    </div>
    <!--Table-->
    <table class="table table-bordered">
        <thead>
            <th>Category</th>
            <th>Parent</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM categories WHERE parent = 0";
        $result = $db->query($sql);
        while($parent = mysqli_fetch_assoc($result)):
            $parent_id = (int)$parent['id'];
            $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
            $child_result = $db->query($sql2);
    
        ?>
            <tr class="bg-light">
                <td class="text-success font-weight-bold"><?=$parent['ctgry_name'];?></td>
                <td class="text-success font-weight-bold">Parent</td>
                <td>
                    <a href="categories.php?edit=<?=$parent['id'];?>" class="btn btn-sm btn-link"><span class="fas fa-pencil-alt"> Click to edit</span></a>
                </td>
                <td>
                    <a href="categories.php?delete=<?=$parent['id'];?>" class="btn btn-sm btn-link"><span class="fas fa-trash-alt"> Click to delete</span></a>
                </td>
            </tr>
        <?php while($child = mysqli_fetch_assoc($child_result)) :
        ?>
            <tr>
                <td><?=$child['ctgry_name'];?></td>
                <td ><?=$parent['ctgry_name'];?></td>
                <td>
                    <a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-sm btn-link"><span class="fas fa-pencil-alt"> Click to edit</span></a>
                </td>
                <td>
                    <a href="categories.php?delete=<?=$child['id'];?>" class="btn btn-sm btn-link"><span class="fas fa-trash-alt"> Click to delete</span></a>
                </td>
            </tr>
        <?php endwhile; ?>
        <?php endwhile;?>
        </tbody>
    </table>
<?php
include 'includes/footer.php';
?>
