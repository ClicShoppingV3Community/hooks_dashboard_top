<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT

   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\OM\Module\Hooks\ClicShoppingAdmin\Dashboard;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  class IndexDashboardTopOutOfStock
  {
    protected mixed $db;

    public function __construct()
    {

      if (CLICSHOPPING::getSite() != 'ClicShoppingAdmin') {
        CLICSHOPPING::redirect();
      }

      $this->db = Registry::get('Db');
    }

    public function execute()
    {
      $Qproducts = $this->db->prepare('select count(*) as count from :table_products where products_quantity = 0');
      $Qproducts->execute();

      $number_products_out_of_stock = $Qproducts->valueInt('count');

      if ($number_products_out_of_stock > 0 && STOCK_CHECK == 'true') {
        $text = CLICSHOPPING::getDef('text_number_products_out_of_stock');
        $text_view = CLICSHOPPING::getDef('text_view');

        $output = '
<div style="padding-right:0.5rem; padding-top:0.5rem">
  <div class="card bg-danger">
    <div class="card-body">
      <div class="row">
        <h5 class="card-title text-white"><i class="fas fa-fire"  aria-hidden="true"></i> ' . $text . '</h5>
      </div>
      <div class="col-md-12">
        <span h5 class="text-white">' . $number_products_out_of_stock . '</span>
        <span><small class="text-white">' . HTML::link(CLICSHOPPING::link(null, 'A&Catalog\Products&StatsProductsLowStock'), $text_view, 'class="text-white"') . '</small></span>
      </div>
    </div>
  </div>
</div>
';
        return $output;
      }
    }
  }