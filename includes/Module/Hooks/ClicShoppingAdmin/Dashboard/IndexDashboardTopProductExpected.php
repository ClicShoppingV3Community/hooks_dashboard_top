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

  class IndexDashboardTopProductExpected
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
      $Qproducts = $this->db->prepare('select count(*) as count from :table_products where products_date_available <> null');
      $Qproducts->execute();

      $number_products_expected = $Qproducts->valueInt('count');

      if ($number_products_expected != 0) {
        $text = CLICSHOPPING::getDef('text_number_products_expected');
        $text_view = CLICSHOPPING::getDef('text_view');

        $output = '
<div style="padding-right:0.5rem; padding-top:0.5rem">
  <div class="card bg-primary">
    <div class="card-body">
      <div class="row">
        <h5 class="card-title text-white"><i class="fas fas fa-info"  aria-hidden="true"></i> ' . $text . '</h5>
      </div>
      <div class="col-md-12">
        <span h5 class="text-white">' . $number_products_expected . '</span>
        <span ><small class="text-white">' . HTML::link(CLICSHOPPING::link(null, 'A&Catalog\Products&StatsProductsExpected'), $text_view, 'class="text-white"') . '</small></span>
      </div>
    </div>
  </div>
</div>
';

        return $output;
      }
    }
  }