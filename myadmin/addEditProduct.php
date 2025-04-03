<?php
include("header.php");
?>
<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Add New Jewelry Product</h3>
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" method="post" action="save_product.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="product-name" class="col-sm-2 control-label">Product Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" id="product-name" name="product_name" placeholder="Product Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-8">
                            <select name="category" class="form-control1" required>
                                <option value="">Select Category</option>
                                <option value="rings">Rings</option>
                                <option value="necklaces">Necklaces</option>
                                <option value="earrings">Earrings</option>
                                <option value="bracelets">Bracelets</option>
                                <option value="watches">Watches</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" class="form-control1" id="price" name="price" placeholder="Price" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="col-sm-2 control-label">Stock Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control1" id="stock" name="stock" placeholder="Stock" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="material" class="col-sm-2 control-label">Material</label>
                        <div class="col-sm-8">
                            <select name="material" class="form-control1" required>
                                <option value="">Select Material</option>
                                <option value="gold">Gold</option>
                                <option value="silver">Silver</option>
                                <option value="platinum">Platinum</option>
                                <option value="white-gold">White Gold</option>
                                <option value="rose-gold">Rose Gold</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gemstone" class="col-sm-2 control-label">Gemstone</label>
                        <div class="col-sm-8">
                            <select name="gemstone" class="form-control1">
                                <option value="">Select Gemstone</option>
                                <option value="diamond">Diamond</option>
                                <option value="ruby">Ruby</option>
                                <option value="emerald">Emerald</option>
                                <option value="sapphire">Sapphire</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-8">
                            <textarea name="description" id="description" class="form-control1" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-sm-2 control-label">Product Images</label>
                        <div class="col-sm-8">
                            <input type="file" name="product_images[]" class="form-control1" multiple>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="featured" class="col-sm-2 control-label">Featured</label>
                        <div class="col-sm-8">
                            <div class="checkbox-inline">
                                <label><input type="checkbox" name="featured" value="1"> Mark as Featured</label>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">Save Product</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include("copyright.php"); ?>
</div>
<?php
include("footer.php");
?>