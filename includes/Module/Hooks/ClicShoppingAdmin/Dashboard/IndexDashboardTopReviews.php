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

  class IndexDashboardTopReviews
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
      $Qreviews = $this->db->prepare('select count(*) as num_reviews 
                                      from :table_reviews 
                                      where date_added >= (now() - INTERVAL 2 month) 
                                      and status > 0
                                      ');
      $Qreviews->execute();

      $number_of_reviews = $Qreviews->valueInt('num_reviews');

      $text = CLICSHOPPING::getDef('text_number_of_reviews');
      $text_view = CLICSHOPPING::getDef('text_view');

      if ($number_of_reviews > 0) {
        $output = '
<div style="padding-right:0.5rem; padding-top:0.5rem">
    <div class="card bg-success">
      <div class="card-body">
        <div class="row">
          <h5 class="card-title text-white"><i class="far fa-comment"  aria-hidden="true"></i> ' . $text . '</h5>
        </div>
        <div class="col-md-12">
          <span h5 class="text-white">' . $number_of_reviews . '</span>
          <span><small class="text-white">' . HTML::link(CLICSHOPPING::link(null, 'A&Customers\Reviews&Reviews'), $text_view, 'class="text-white"') . '</small></span>
        </div>
      </div>
    </div>
</div>
';
        return $output;
      }
    }
  }