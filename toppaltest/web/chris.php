<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/lib/mustache.js"></script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/styles.css">


</head>

<body>

<!--DELETE-->
<style>
    .form-holder > div { margin:100px 0; }
</style>
<!-- DELETE -->




<div class="form-holder">
    <div id="products" style="relative">

        <div id="breadcrumb">
            <ul class="breadcrumb">
                <li><a href="#">Products </a></li><span class="divider"> / </span>
                <li class="active">Choose or Add Products</li>
            </ul>
        </div>

        <h3 id="title">Add Product</h3>




        <form id="product-form" class="form-horizontal">




        <!--GLOBAL PRODUCT FIELD START-->
        <div class="control-group">
            <label class="control-label" for="productName">Name</label>
            <div class="controls">
                <input type="text" id="productName" placeholder="Product Name">
            </div>
        </div>
        <div style="width:50%; float: left;">
            <div class="control-group">
                <label class="control-label" for="productType">Product Type</label>
                <div class="controls">
                    <select type="text" id="productType">
                        <option value="add-product-ecommerce">eCommerce</option>
                        <option value="add-product-leadgen">Lead Generation</option>
                        <option value="add-product-donation">Donation</option>
                        <option value="add-product-link-out">Link Out</option>
                        <option value="add-product-with-options">Product With Options</option>
                    </select>
                </div>
            </div>
        </div>
        <script>
            $("#productType").change(function(){
                $("#" + this.value).fadeIn().siblings().hide();
            });
        </script>

        <div style="width:50%; float: left;">
            <div class="control-group">
                <label class="control-label" for="active">Active</label>
                <div class="controls">
                    <input type="checkbox" id="active" placeholder="URL">
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="productDescription">Description</label>
            <div class="controls">
                <textarea rows="3" id="productDescription" style="width:720px"></textarea>
            </div>
        </div>

        <!--GLOBAL PRODUCT FIELD END -->

        <div class="product-type-forms">

        <!--ECOMMERCE START-->

        <div id="add-product-ecommerce"  class="clearfix">

            <div style="width: 50%; float: right;">
                <div class="control-group">
                    <label class="control-label" for="price">Price</label>
                    <div class="controls">
                        <input type="text" id="price" placeholder="Price">
                    </div>
                </div>
            </div>


            <div style="width:50%; float: left;">
                <div class="control-group">
                    <label class="control-label" for="sku">Product Code (SKU)</label>
                    <div class="controls">
                        <input type="text" id="sku" placeholder="SKU">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="weight">Weight</label>
                    <div class="controls">
                        <input type="text" id="weight" placeholder="Weight">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="quantity">Quantity</label>
                    <div class="controls">
                        <input type="text" id="quantity" placeholder="Quantity">
                    </div>
                </div>


            </div>

            <div style="width:50%; float: right;">
                <div class="control-group">
                    <label class="control-label" for="cost">Cost</label>
                    <div class="controls">
                        <input type="text" id="cost" placeholder="Cost">
                    </div>
                </div>

                <div class="control-group" style="display:none;" id="option-notification">
                    <label class="control-label" for="notify">Notify When Less Than</label>
                    <div class="controls">
                        <input type="text" id="notify" placeholder="#">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="notify">Notify When Less Than</label>
                    <div class="controls">
                        <input type="text" id="notify" placeholder="#">
                    </div>
                </div>
            </div>
        </div>

        <!--ECOMMERCE END-->





        <!--LEADGEN START-->
        <div id="add-product-leadgen" style="display: none;" >
            <div class="control-group">
                <label class="control-label" for="deliveryMethod">Delivery Method</label>
                <div class="controls">
                    <select id="deliveryMethod">
                        <option value="standard">Standard Lead</option>
                        <option value="hostpost">Host and Post</option>
                        <option value="hostposttwo">Host and Post Two Part</option>
                    </select>
                </div>
            </div>
            <div class="clearfix" id="host-and-post-fields" style="display: none;">
                <div style="width:50%; float: left;">
                    <div class="control-group">
                        <label class="control-label" for="formurlLink">Form Destination URL</label>
                        <div class="controls">
                            <input type="text" id="formurlLink" placeholder="URL">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="formFirstName">Form First Name</label>
                        <div class="controls">
                            <input type="text" id="formFirstName" placeholder="First Name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="formLastName">Form Last Name</label>
                        <div class="controls">
                            <input type="text" id="formLastName" placeholder="Last Name">
                        </div>
                    </div>

                </div>

                <div style="width: 50%; float: right;">
                    <div class="control-group">
                        <label class="control-label" for="formEmail">Form Email</label>
                        <div class="controls">
                            <input type="text" id="formEmail" placeholder="Email">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="formurlLink">Form Phone Number</label>
                        <div class="controls">
                            <input type="text" id="formPhoneNumber" placeholder="URL">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="formZip">Form Zip</label>
                        <div class="controls">
                            <input type="text" id="formZip" placeholder="URL">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#deliveryMethod").change(function(){
                if ( $(this).val() == "hostpost" || "hostposttwo"  ) {
                    $("#host-and-post-fields").fadeIn();
                }
                if ( $(this).val() == "standard"  ) {
                    $("#host-and-post-fields").hide();
                }
            });
        </script>
        <!--LEADGEN END-->




        <!--LINKOUT START-->
        <div id="add-product-link-out" style="display: none;">
            <div class="control-group">
                <label class="control-label" for="urlLink">Link to Product Page</label>
                <div class="controls">
                    <input type="text" id="urlLink" placeholder="URL">
                </div>
            </div>
        </div>
        <!--LINKOUT END-->



        <!--DONATION START-->
        <div id="add-product-donation" style="display: none;">

                <div class="control-group">
                    <label class="control-label" for="donationType">Donation Type</label>
                    <div class="controls">
                        <select id="donationType">
                            <option>General</option>
                            <option>Political</option>
                        </select>
                    </div>
                </div>

            <div class="control-group">
                <label class="control-label" for="table-donations">Donation Amounts</label>
                <div class="controls">
                    <table class="table table-striped table-of-options table-donations" id="table-donations">
                        <thead>
                        <th>Amount</th>
                        <th></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td><a href="#">Remove</a></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><a style="text-align: right;">Add Amount</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--DONATION END-->

        <!--PRODUCT WITH OPTIONS START-->
        <div id="add-product-with-options" style="display: none;">



            <div style="width: 50%; float: right;">
                <div class="control-group">
                    <label class="control-label" for="price">Price</label>
                    <div class="controls">
                        <input type="text" id="price" placeholder="Price">
                    </div>
                </div>
            </div>


            <div style="width:50%; float: left;">
                <div class="control-group">
                    <label class="control-label" for="sku">Product Code (SKU)</label>
                    <div class="controls">
                        <input type="text" id="sku" placeholder="SKU">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="weight">Weight</label>
                    <div class="controls">
                        <input type="text" id="weight" placeholder="Weight">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="options">Options</label>
                    <div class="controls">
                        <select id="options">
                            <option value="option-none">None</option>
                            <option value="option-size">Size</option>
                            <option value="option-color">Color</option>
                        </select>
                    </div>
                </div>

            </div>

            <div style="width:50%; float: right;"  >
                <div class="control-group">
                    <label class="control-label" for="cost">Cost</label>
                    <div class="controls">
                        <input type="text" id="cost" placeholder="Cost">
                    </div>
                </div>

                <div class="control-group" style="display:none;" id="option-notification">
                    <label class="control-label" for="notify">Notify When Less Than</label>
                    <div class="controls">
                        <input type="text" id="notify" placeholder="#">
                    </div>
                </div>
            </div>

            <div id="option-tables" class="clearfix">
                <div id="option-none" style="width:50%; float: right;">

                    <div class="control-group">
                        <label class="control-label" for="quantity">Quantity</label>
                        <div class="controls">
                            <input type="text" id="quantity" placeholder="Quantity">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="notify">Notify When Less Than</label>
                        <div class="controls">
                            <input type="text" id="notify" placeholder="#">
                        </div>
                    </div>

                </div>
                <table class="table table-striped table-of-options" id="option-size" style="display: none; ">
                    <thead>
                    <tr>
                        <th>Size</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Position</th>
                        <th>Default</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input type="radio" name="default" value="default"></td>
                        <td><a href="#">Remove</a></td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-striped table-of-options" id="option-color" style="display: none; ">
                    <thead>
                    <tr>
                        <th>Color</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Position</th>
                        <th>Default</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input type="radio" name="default" value="default"></td>
                        <td><a href="#">Remove</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--PRODUCT WITH OPTIONS END-->

        </div>


        </form>

        <script>
            $("#options").change(function(){
                $("#" + this.value).fadeIn().siblings().hide();
                if ( $(this).val() == "option-size" || "option-color"  ) {
                    $("#option-notification").fadeIn();
                }
                if ( $(this).val() == "option-none"  ) {
                    $("#option-notification").hide();
                }
            });
        </script>

    </div>
</div>


</body>

</html>