<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\OM\Module\Hooks\ClicShoppingAdmin\Dashboard;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  class IndexDashboardTopNewsletter
  {
    protected $db;

    public function __construct()
    {

      if (CLICSHOPPING::getSite() != 'ClicShoppingAdmin') {
        CLICSHOPPING::redirect();
      }

      $this->db = Registry::get('Db');
    }

    public function execute()
    {
      $Qustomers = $this->db->prepare('select count(*) as count 
                                       from :table_customers 
                                       where customers_newsletter = 1
                                     ');
      $Qustomers->execute();

      $number_customers_newsletter = $Qustomers->valueInt('count');

      if ($number_customers_newsletter > 0) {
        $text = CLICSHOPPING::getDef('box_newsletter');
        $text_view = CLICSHOPPING::getDef('text_view');

        $output = '
<div style="padding-right:0.5rem; padding-top:0.5rem">
    <div class="card bg-info">
      <div class="card-body">
        <div class="row">
          <h5 class="card-title text-white"><i class="fas fa-bell-slash"  aria-hidden="true"></i> ' . $text . '</h5>
        </div>
        <div class="col-md-12">
          <span h5 class="text-white">' . $number_customers_newsletter . '</span>
          <span><small class="text-white">' . HTML::link(CLICSHOPPING::link(null, 'A&Communication\Newsletter&Newsletter'), $text_view, 'class="text-white"') . '</small></span>
        </div>
      </div>
    </div>
</div>
';


        return $output;
      }
    }
  }