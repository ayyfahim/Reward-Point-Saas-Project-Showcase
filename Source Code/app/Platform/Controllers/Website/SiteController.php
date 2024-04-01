<?php namespace Platform\Controllers\Website;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Platform\Controllers\Core;

class SiteController extends Controller {

  /*
   |--------------------------------------------------------------------------
   | Web routes for website
   |--------------------------------------------------------------------------
   |
   | Website logic
   |--------------------------------------------------------------------------
   */

  /**
   * Homepage
   *
   * @return \Illuminate\View\View
   */
  public function home() {
    if (!env('HOMEPAGE', true)) {
      return redirect('go');
    }
    $account = app()->make('account');
    $account = (array) $account->only('app_name', 'app_contact', 'app_headline', 'app_color', 'app_scheme', 'app_host', 'language', 'locale');
    $account['app_contact'] = Core\Secure::hideEmail($account['app_contact']);
  
    $website = [
      'theme' => [
        'color' => '#0D47A1',
        'primary' => 'blue darken-4 white--text',
        'outlined' => 'blue blue--text darken-4--text',
        'backgroundColor' => '#ffffff',
        'primaryColor' => '#ffffff',
        'primaryTextColor' => '#333',
        'textColor' => '#333333',
        'secondaryColor' => '#000',
        'secondaryTextColor' => '#ffffff',
        'drawer' => [
          'textColor' => '#eeeeee',
          'backgroundColor' => '#333333',
          'highlightTextColor' => '#ffffff',
          'highlightBackgroundColor' => '#222222'
        ]
      ],
      'home' => [
        'title' => 'Easy Loyalty Programs'
      ],
      'features' => [
        "Build a lasting relationship" => "Reward loyal customers.",
        "No app required" => "Web based, no need to install an app.",
        "Instant loyalty programs" => "No technical knowledge or third parties required.",
        "Add-on websites" => "High end loyalty pages with registration.",
        "Optimized for mobile" => "But works perfectly on tablets and desktops.",
        "Detailed insights" => "Gain insight into what your customers want.",
        "Segment your customers" => "Use segments to get more detailed analytics.",
        "Little investment" => "Offer a quality loyalty program with little investment.",
        "For agencies" => "Extend your business with this service.",
        "For marketeers" => "Our service is perfectly complementary.",
        "Reward loyalty" => "No technical knowledge or third parties required.",
        "For any business" => "That wants their customers to come back.",

      ]
    ];

    return view('website.home', compact('account', 'website'));
  }
  
  /**
   * Get terms
   *
   * @return \Illuminate\View\View
   */
  public function getTerms() {
    $account = app()->make('account');
    $company = request()->get('company', $account->app_name);
    return view('website.terms', compact('account', 'company'));
  }
}
