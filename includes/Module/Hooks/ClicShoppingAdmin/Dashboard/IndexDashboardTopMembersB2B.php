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

  class IndexDashboardTopMembersB2B
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
      $Qmembes = $this->db->prepare('select count(*) as count 
                                    from :table_customers 
                                    where member_level = 0
                                    ');
      $Qmembes->execute();

      $number_members = $Qmembes->valueInt('count');

      if ($number_members > 0) {
        $text = CLICSHOPPING::getDef('text_number_members_b2b');
        $text_view = CLICSHOPPING::getDef('text_view');

        $output = '
<div style="padding-right:0.5rem; padding-top:0.5rem">
  <div class="card bg-secondary">
      <div class="card-body">
        <div class="row">
          <h5 class="card-title text-white"><i class="fas fa fa-female"  aria-hidden="true"></i> ' . $text . '</h5>
        </div>
        <div class="col-md-12">
          <span h5 class="text-white">' . $number_members . '</span>
          <span><small class="text-white">' . HTML::link(CLICSHOPPING::link(null, 'A&Customers\Members&Members'), $text_view, 'class="text-white"') . '</small></span>
      </div>
    </div>
  </div>
</div> 
';

        return $output;
      }
    }
  }