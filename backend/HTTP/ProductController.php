<?php

namespace Backend\Http;

use Backend\Models\Product;
use Backend\Miscellaneous\Validator;

class ProductController
{
  protected $request;

  public function __construct()
  {
    $this->request = new Request;
  }

  public function index()
  {
    $products = (new Product)->getAllProducts();
    return $this->request->view('welcome.php', compact('products'));
  }

  public function create()
  {
    return $this->request->view('add.php');
  }

  public function store()
  {
    $details = $this->request->all();
    $measurement = $details['type'] == 'dvd'
                    ? ['size' => $details['size'].' MB']
                    : ($details['type'] == 'furniture'
                        ? ['dimension' => $details['height'].'x'.$details['width'].'x'.$details['length']]
                        : ['weight' => $details['weight'].' KG']
                      );

    foreach($details as $key => $value){
      if($key == 'size' || $key == 'height' || $key == 'width' || $key == 'length' || $key == 'weight'){
        unset($details[$key]);
      }
    }
    $details = array_merge($details, ['extra' => json_encode(['measurement' => $measurement])]);

    $validator = (new Validator)->validateProductCreateData($details);

    if ($validator->logger->hasErrors()) {
      return $this->request->redirect_to_route('/create');
    }

    Product::query()->saveProduct((object) $validator->validateddata);

    $validator->logger->flashSuccessMsg('Product Created!');
  }

  public function delete()
  {
    $validator = (new Validator)->validateProductDeleteData($this->request->all());

    if ($validator->logger->hasErrors()) {
      return $this->request->redirect_to_route('/');
    }

      $id_str = implode(',',  $this->request->checked_id);

      $num_of_rows_deleted = Product::query()->delete($id_str);

      $validator->logger->flashSuccessMsg($num_of_rows_deleted . ' product'. ($num_of_rows_deleted > 1 ? 's' : '') . ' deleted!');
  }

  public function __toString()
  {
    return 'Methods available in this controller: ' . implode(', ', get_class_methods(self::class));
  }
}
