<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="./frontend/css/bootstrap.min.css">
  <link rel="stylesheet" href="./frontend/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="./frontend/css/styles.css">

  <title>Scandiweb Junior Developer Test</title>
</head>

<body>
  <div id="app" class="relative flex flex-column items-top justify-around min-h-screen bg-gray-100 dark:bg-gray-900 sm:pt-0">
    <div class="header container">
      <header class="row w-100 pt-4 fnt1">
        <h1 class="col-lg-6 col-md-6 col-sm-6 text-gray-900">Product Add</h1>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <nav class="d-flex justify-content-end">
            <button type="submit" form="product_form" class="btn btn-primary text-uppercase">Save Product</button>
            <a href="./" class="btn btn-primary text-uppercase ml-4">Cancel</a>
          </nav>
        </div>
        <div class="seperator col-lg-12">
          <hr class="bg-white">
        </div>
      </header>
    </div>

    <div class="display-boxes">
      <div class="container">
        <div class="row justify-center">
          <!-- <form action="./backend/Form_add_action.php" method="POST" class="col-lg-6" id="product_form"> -->
          <form action="/store" method="POST" class="col-lg-6" id="product_form">
            <input type="hidden" name='_method' value='post' />
              <?php
                $this->notifications->viewErrorMsgs();
                $this->notifications->viewSuccessMsgs();
              ?>

            <div class="row my-3">
              <div class="form-group col-md-6">
                <label class="mb-2" for="sku">SKU</label>
                <input required type="text" class="form-control" name="sku" id="sku" placeholder="SKU" maxlength="10">
              </div>

              <div class="form-group col-md-6">
                <label class="mb-2" for="name">Product Name</label>
                <input required type="text" class="form-control" name="name" id="name" placeholder="Product Name">
              </div>
            </div>

            <div class="row my-3">
              <div class="form-group col-md-6">
                <label class="mb-2" for="price">Price</label>
                <input required type="number" class="form-control" name="price" id="price" placeholder="Price">
              </div>

              <div class="form-group col-md-6">
                <label class="mb-2" for="productType">Product Type</label>
                <select name="type" id="productType" class="form-control">
                  <option selected value="">Choose...</option>
                  <option value="dvd">DVD</option>
                  <option value="book">Book</option>
                  <option value="furniture">Furniture</option>
                </select>
              </div>
            </div>

            <div class="form-group my-3 type-options d-none dvd">
              <label class="mb-2" for="size">Size (MB) </label>
              <input type="number" class="form-control" name="size" id="size" placeholder="E.g. 700">
            </div>

            <div class="form-group my-3 type-options d-none book">
              <label class="mb-2" for="weight">Weight (kg)</label>
              <input type="number" class="form-control" name="weight" id="weight" placeholder="E.g. 0.7">
            </div>

            <div class="row my-3 type-options d-none furniture">
              <div class="form-group col-md-4">
                <label class="mb-2" for="height">Height (cm)</label>
                <input type="number" class="form-control" name="height" id="height" placeholder="E.g. 175">
              </div>

              <div class="form-group col-md-4">
                <label class="mb-2" for="width">Width (cm)</label>
                <input type="number" class="form-control" name="width" id="width" placeholder="E.g. 175">
              </div>

              <div class="form-group col-md-4">
                <label class="mb-2" for="length">Length (cm)</label>
                <input type="number" class="form-control" name="length" id="length" placeholder="E.g. 175">
              </div>
            </div>

            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->

          </form>
        </div>
      </div>
    </div>

    <footer class="container w-100 mt-5">
      <div class="row">
        <div class="seperator col-lg-12">
          <hr class="bg-white">
        </div>
        <div class="col-lg-12 text-capitalize text-center p-2 fnt1 text-gray-700">
          Scandiweb Test assignment
        </div>
      </div>
    </footer>
  </div>

  <script src="./frontend/js/jquery-3.1.1.js"></script>
  <script src="./frontend/js/app.js"></script>
  <script>
    $(document).ready(function() {
      // dropdown function
      $('#productType').change(function() {
        $('.type-options').addClass('d-none');
        $(`.${$('#productType').val()}`).removeClass('d-none');
      })

      // form validation function
      $("form").submit(function(e) {
        switch (true) {
          case ($('#sku').val() == '' ||
            $('#name').val() == '' ||
            $('#price').val() == '' ||
            $('#productType').val() == ''):
            hasError('Please, submit required data.', e);
            break;

          case ($('#productType').val() == 'dvd' &&
            $('#size').val() == ''):
            hasError('Please, provide the data of indicated type.', e);
            break;

          case (($('#productType').val() == 'furniture' &&
              ($('#height').val() == '' || $('#width').val() == '' || $('#length').val() == '')) ||
            ($('#productType').val() == 'book' && $('#weight').val() == '') ||
            ($('#productType').val() == 'book' && $('#weight').val() == '')):
            hasError('Please, provide the data of indicated type.', e);
            break;

          case ($('#productType').val() != 'dvd' &&
            $('#productType').val() != 'furniture' &&
            $('#productType').val() != 'book'):
            hasError('Unknown type add.', e);
            break;

          case (isNaN($('#price').val())):
            hasError('Only numbers allowed for price.', e);
            break;

          case ($('#productType').val() == 'dvd' && isNaN($('#size').val())):
            hasError('Only numbers allowed for size.', e);
            break;

          case ($('#productType').val() == 'furniture' && (isNaN($('#height').val()) || isNaN($('#width').val()) || isNaN($('#length').val()))):
            hasError('Only numbers allowed for product dimension.', e);
            break;

          case ($('#productType').val() == 'book' && isNaN($('#weight').val())):
            hasError('Only numbers allowed for book weight.', e);
            break;

          default:
            hasSuccess('Created Successfully.');
        }
      });
    });

    // functions
    function htmlContent(className, content) {
      $(className).html(content);
    }

    function classRemoval(className, actionClassName) {
      $("." + className).removeClass(actionClassName);
    }
  </script>
</body>

</html>
