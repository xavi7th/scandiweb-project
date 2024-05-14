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

<body class="antialiased">
  <div id="app" class="relative flex flex-column items-top justify-around min-h-screen bg-gray-100 dark:bg-gray-900 sm:pt-0">
    <div class="header container">
      <header class="row w-100 pt-4 fnt1">
        <h1 class="col-lg-6 col-md-6 col-sm-6 h2 text-gray-900 uppercase tracking-wider text-white">Product List</h1>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <nav class="d-flex justify-content-end">
            <a href="/create" class="btn btn-primary text-uppercase">ADD</a>
            <button type="submit" form="productsContainer" formaction="/delete" class="btn btn-primary text-uppercase ml-4">MASS DELETE</button>
          </nav>
        </div>
        <div class="seperator col-lg-12">
          <hr class="bg-white">
        </div>
      </header>
    </div>

    <div class="display-boxes">
      <div class="container">
        <!-- form start -->

        <form id="productsContainer" method="POST" class="row gx-5 gy-5">
          <?php
            // $this->notifications->viewErrorMsgs();
            // $this->notifications->viewSuccessMsgs();
          ?>

          <input type="hidden" name='_method' value='delete' />

          <?php if (!empty($this->params->products)) : ?>
            <?php foreach ($this->params->products as $product) : ?>
              <!-- box display -->
              <div class="col-lg-3 col-md-6">
                <div class="box pt-3 pb-5 text-gray-700 tracking-wider border-0">
                  <div class="check-box px-4">
                    <!-- checkbox for each button -->
                    <input type="checkbox" class="delete-checkbox" name="checked_id[]" value="<?php echo $product['id']; ?>">
                  </div>
                  <div class="text text-center text-capitalize fnt1">
                    <p class="mb-0"><?php echo $product['sku'] ?></p>
                    <p class="mb-0"><?php echo $product['name'] ?></p>
                    <p class="mb-0"><?php echo $product['price'] . ' $' ?></p>

                    <p class="mb-0">
                      <?php foreach (json_decode($product['extra'])->measurement as $key => $value) : ?>
                        <p class="mb-0"><?php echo $key ?>: <?php echo $value ?></p>
                      <?php endforeach ?>
                    </p>
                  </div>
                </div>
              </div>
              <!-- box display end -->
            <?php endforeach; ?>
          <?php else : ?>
            <div class="fnt1 text-gray-700 tracking-wider text-center"><i>Product List is empty.</i></div>
          <?php endif; ?>
          <button id="submit" type="submit" class="d-none">done</button>
        </form>
        <!-- form end -->
      </div>
    </div>


    <footer class="container mt-5">
      <div class="row">
        <div class="seperator col-lg-12">
          <hr class="bg-white">
        </div>
        <div class="col-lg-12 text-capitalize text-center p-2 fnt1 text-gray-700 tracking-wider">
          Scandiweb Test assignment
        </div>
      </div>
    </footer>
  </div>
</body>

<script src="./frontend/js/jquery-3.1.1.js"></script>

</html>
