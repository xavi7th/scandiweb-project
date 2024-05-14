<?php

namespace Backend\Miscellaneous;

use Backend\Logger\Log;
use Backend\Models\Product;

class Validator
{
  public $logger;
  public $validateddata = [];

  public function __construct()
  {
    $this->logger = new Log();
  }

  public function transformValidatedData(array $data): array
  {

    foreach ($data as $key => $value) {
      $this->validateddata[$key] = empty($value) ? 0 : $value;
    }

    return $this->validateddata;
  }

  public function validateProductCreateData($data)
  {
    $result = Product::query()->sqlQuery("SELECT * FROM " . Product::getTableName() . " WHERE sku = '" . $data['sku'] . "'");

    $numRows = $result->num_rows;

    if ($numRows > 0) {
      $this->logger->addError("SKU already exists.", 512);
    }

    if (empty($data['sku']) || empty($data['name']) || empty($data['price']) || empty($data['type'])) {
      $this->logger->addError('Please, submit required data.');
    }

    if ($data['type'] != 'dvd' && $data['type'] != 'furniture' && $data['type'] != 'book') {
      $this->logger->addError('Unknown type add.');
    }

    // if (($data['type'] == 'dvd' && empty($data['size'])) ||
    //   ($data['type'] == 'furniture' && (empty($data['height']) || empty($data['width']) || empty($data['length']))) ||
    //   ($data['type'] == 'book' && (empty($data['weight'])))
    // ) {
    //   $this->logger->addError('Please, provide the data of indicated type.');
    // } elseif (!is_numeric($data['price'])) {
    //   $this->logger->addError('Only numbers allowed for price.');
    // } elseif (
    //   $data['type'] == 'dvd' &&
    //   (!is_numeric($data['size']))
    // ) {
    //   $this->logger->addError('Only numbers allowed for size.');
    // } elseif (
    //   $data['type'] == 'furniture' &&
    //   (!is_numeric($data['height']) || !is_numeric($data['width']) || !is_numeric($data['length']))
    // ) {
    //   $this->logger->addError('Only numbers allowed for product dimension.');
    // } elseif (($data['type'] == 'book' &&
    //   (!is_numeric($data['weight'])))) {
    //   $this->logger->addError('Only numbers allowed for book weight.');
    // }

    $this->transformValidatedData($data);

    return $this;
  }

  public function validateProductDeleteData(array $data): self
  {
    switch (true) {
      case empty($data['checked_id']):
        $this->logger->addError('Please, select products to delete.');
        break;

      case !is_array($data['checked_id']):
        $this->logger->addError('Invalid data supplied.');
        break;
    }

    return $this;
  }
}
