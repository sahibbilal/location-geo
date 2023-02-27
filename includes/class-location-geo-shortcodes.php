<?php

class LOCATION_GEO_Shortcodes {

    /**
	 * The Name of plugin.
	 *
	 */
	private $plugin_name;
	/**
	 * The version of plugin.
	 *
	 */
	private $version;
    /**
     * Configuration
     */
    private $headingSize;
    private $headingColor;
    private $paragraphColor;
    private $paragraphSize;
    private $neighbor_limit = 60;
    private $neighbor_location;
    private $neighbor_sort;
    private $activities_limit;
    private $activities_location;
    private $activities_sort;
    private $activities_types;
    private $location_sentence;
    private $gmap_zoom;
    private $gmap_height;
    private $gmap_location;
    private $apiKey;
	/**
	 * Class and set properties.
	 *
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
        $licenses_res = get_option( 'licenses_res' );
        $options = get_option( 'max_sb_location_geo_options' );
		$this->version = $version;
        $this->headingSize = (!empty($options['max_sb_location_geo_heading_font_size'])) ? $options['max_sb_location_geo_heading_font_size'] : '';
        $this->headingColor = (!empty($options['max_sb_location_geo_heading_font_color'])) ? $options['max_sb_location_geo_heading_font_color'] : '';
        $this->paragraphColor = (!empty($options['max_sb_location_geo_paragraph_font_color'])) ? $options['max_sb_location_geo_paragraph_font_color'] : '';
        $this->paragraphSize = (!empty($options['max_sb_location_geo_paragraph_font_size'])) ? $options['max_sb_location_geo_paragraph_font_size'] : '';
        $this->margin_bottom = (!empty($options['max_sb_location_geo_margin_bottom'])) ? $options['max_sb_location_geo_margin_bottom'] : '';
        $this->headling_alignment = (!empty($options['max_sb_location_geo_heading_alignment'])) ? $options['max_sb_location_geo_heading_alignment'] : '';
        $this->weatherApiKey = (!empty($options['max_sb_location_geo_weather_api_key'])) ? $options['max_sb_location_geo_weather_api_key'] : '';
        $settingsOptions = (!empty(get_option( 'max_sb_location_geo_settings' ))) ? get_option( 'max_sb_location_geo_settings' ) : '';
        $this->neighbor_limit = (!empty($settingsOptions['max_sb_location_geo_neighbor_limit'])) ? $settingsOptions['max_sb_location_geo_neighbor_limit'] : '';
        $this->neighbor_location = (!empty($settingsOptions['max_sb_location_geo_neighbor_location'])) ? $settingsOptions['max_sb_location_geo_neighbor_location'] : '';
        $this->neighbor_sort = (!empty($settingsOptions['max_sb_location_geo_neighbor_sort'])) ? $settingsOptions['max_sb_location_geo_neighbor_sort'] : '';
        $this->activities_limit = (!empty($settingsOptions['max_sb_location_geo_activities_limit'])) ? $settingsOptions['max_sb_location_geo_activities_limit'] : '';
        $this->activities_location = (!empty($settingsOptions['max_sb_location_geo_activities_location'])) ? $settingsOptions['max_sb_location_geo_activities_location'] : '';
        $this->activities_radius = (!empty($settingsOptions['max_sb_location_geo_activities_radius'])) ? $settingsOptions['max_sb_location_geo_activities_radius'] : '';
        $this->activities_sort = (!empty($settingsOptions['max_sb_location_geo_activities_sort'])) ? $settingsOptions['max_sb_location_geo_activities_sort'] : '';
        $this->activities_types = (isset($settingsOptions['max_sb_location_geo_activities_types']) && !empty($settingsOptions['max_sb_location_geo_activities_types'] )) ? $settingsOptions['max_sb_location_geo_activities_types'] : 'park,restaurant,stadium,tourist_attraction,point_of_interest,landmark';
        $this->activities_types = (!empty($settingsOptions['max_sb_location_geo_locations_sentence'])) ? $settingsOptions['max_sb_location_geo_locations_sentence'] : '';
        $this->gmap_zoom = (!empty($settingsOptions['max_sb_location_geo_gmap_radius'])) ? $settingsOptions['max_sb_location_geo_gmap_radius'] : '';
        $this->gmap_height = (!empty($settingsOptions['max_sb_location_geo_gmap_height'])) ? $settingsOptions['max_sb_location_geo_gmap_height'] : '';
        $this->gmap_location = (!empty($settingsOptions['max_sb_location_geo_gmap_location'])) ? $settingsOptions['max_sb_location_geo_gmap_location'] : '';
        $this->apiKey = (!empty($settingsOptions['max_sb_location_geo_gmap_api'])) ? $settingsOptions['max_sb_location_geo_gmap_api'] : '';
        $this->weatherApiKey = (!empty($settingsOptions['max_sb_location_geo_weather_api_key'])) ? $settingsOptions['max_sb_location_geo_weather_api_key'] : '';
        $this->licenseKey = (!empty($settingsOptions['max_sb_location_geo_license_key'])) ? $settingsOptions['max_sb_location_geo_license_key'] : get_option('max_sb_location_geo_license_key');
        $this->licenses_res = (!empty($licenses_res)) ? json_decode($licenses_res , true) : '' ;

	}

    public function about_location( $atts, $content= null, $code = '' )
    {
        ob_start();
        $atts = shortcode_atts(
			array(
				'title' => '',
				'location' => '',
                'limit' => ($this->location_sentence !== '')? $this->location_sentence : 10
			),
			$atts, 'max_sb_location_geo'
		);

        $args = array(
            'title' => trim( $atts['title'] ),
            'location' => trim( $atts['location'] ),
            'limit' =>  trim( $atts['limit'] )
        );

        $this->about_location_html($args);
        return ob_get_clean();

    }

    public function neighborhood( $atts, $content= null, $code = '' )
    {
        ob_start();

        $atts = shortcode_atts(
			array(
				'title' => '',
				'location' => $this->neighbor_location,
                'limit' => $this->neighbor_limit,
                'sort' => $this->neighbor_sort
			),
			$atts, 'max_sb_location_geo'
		);

        $args = array(
            'title' => trim( $atts['title'] ),
            'location' => trim( $atts['location'] ),
            'limit' =>  trim( $atts['limit'] ),
            'sort' =>  trim( strtolower($atts['sort']) )
        );

        $this->neighborhood_html($args);
        return ob_get_clean();

    }

    public function activities( $atts, $content= null, $code = '' )
    {
        ob_start();

        $atts = shortcode_atts(

			array(

				'title' => '',

				'location' => $this->activities_location,

                'limit' => $this->activities_limit,

                'sort' => $this->activities_sort,

                'types' => $this->activities_types,

			),

			$atts, 'max_sb_location_geo'

		);

        $args = array(

            'title' => trim( $atts['title'] ),

            'location' => trim( $atts['location'] ),

            'limit' =>  trim( $atts['limit'] ),

            'sort' =>  trim( strtolower($atts['sort']) ),

            'types' =>  trim( strtolower($atts['types']) ),

        );

        $this->activities_html($args);

        return ob_get_clean();

    }

    public function map( $atts, $content= null, $code = '' )
    {
        ob_start();

        $atts = shortcode_atts(
			array(
				'title' => '',
				'location' => $this->gmap_location,
                'zoom' => ($this->gmap_zoom !== '')? $this->gmap_zoom : 8,
                'neighborhood' => '',
                'activities' => ''
			),
			$atts, 'max_sb_location_geo'
		);

        $args = array(
            'title' => trim( $atts['title'] ),
            'location' => trim( $atts['location'] ),
            'zoom' => trim( $atts['zoom'] ),
            'neighborhood' => trim( $atts['neighborhood'] ),
            'activities' => trim( $atts['activities'] ),
            'height' => trim( $atts['height'] )
        );

        $this->map_html($args);
        return ob_get_clean();
    }

    public function directions( $atts, $content= null, $code = '' )
    {
        ob_start();
        $atts = shortcode_atts(
			array(
				'title' => '',
				'address' => '',
                'zoom' => 8,
                'pins' => 5,
                'city' => ''
			),
			$atts, 'max_sb_location_geo'
		);

        $args = array(
            'title' => trim( $atts['title'] ),
            'address' => trim( $atts['address'] ),
            'zoom' => trim( $atts['zoom'] ),
            'city' => trim( $atts['city'] ),
            'pins' => trim( $atts['pins'] )
        );
        $this->directions_html($args);

        return ob_get_clean();
    }

    public function airports( $atts, $content= null, $code = '' )
    {
        ob_start();
        $atts = shortcode_atts(
			array(
				'radius' => '',
				'address' => '',
                'city' => '',
			),
			$atts, 'max_sb_location_geo'
		);

        $args = array(
            'radius' => trim( $atts['radius'] ),
            'address' => trim( $atts['address'] ),
            'city' => trim( $atts['city'] )
        );
        $this->airports_html($args);

        return ob_get_clean();
    }

    public function neighborhood_html($args)

    {
        $dataLocation = (isset($args['location']) && $args['location'] !== '')? 'data-location="'.$args['location'].'"' : '';
        $dataLimit = (isset($args['limit']) && $args['limit'] !== '')? 'data-limit="'.$args['limit'].'"' : '';
        $dataSort = (isset($args['sort']) && $args['sort'] !== '')? 'data-sort="'.$args['sort'].'"' : '';
        $dataAttributes = $dataLocation . ' ' . $dataLimit . ' '. $dataSort;
        $title = ($args['title'] !== '')? $args['title'] : 'Neighborhood';

        if( isset($args['location']) && $args['location'] !== '' ):
            $open = 1;
            $this->max_verify_license($open);
            echo '<div '.$this->addBlockStyle().' class="max-sb-block max-sb-neighborhoods js-max-sb-neighborhoods" '.$dataAttributes.'  data-id="max-sbd-neighborhood-'.substr(bin2hex($args['location']), 0, 20).'">';
            $this->getGifMaxLoader();
            echo '<div class="max-sb-block__area max-sb-block--loading">';
            echo '<div class="max-sb-gmap" style="display:none;"></div>';
            echo '<div>';
            $this->getTitle($title);
            echo '<p class="max-sb-neighborhoods js-max-sb-list" style="font-size:'.$this->paragraphSize.'px; color:'.$this->paragraphColor.';"></p>';
            echo '</div></div></div>';
            $this->getGifMaxLoaderHide();
        else:
            $this->noDataAvailable($title);
        endif;
    }

    public function activities_html($args){

        $dataLocation = (isset($args['location']) && $args['location'] !== '')? 'data-location="'.$args['location'].'"' : '';
        $dataLimit = (isset($args['limit']) && $args['limit'] !== '')? 'data-limit="'.$args['limit'].'"' : '';
        $dataSort = (isset($args['sort']) && $args['sort'] !== '')? 'data-sort="'.$args['sort'].'"' : '';
        $dataTypes = (isset($args['types']) && $args['types'] !== '')? 'data-types="'.$args['types'].'"' : '';
        $dataAttributes = $dataLocation . ' ' . $dataLimit . ' '. $dataSort . ' ' . $dataTypes;
        $title = ($args['title'] !== '')? $args['title'] : 'Activities';
        if( isset($args['location']) && $args['location'] !== '' ):
            $open = 1;
            $this->max_verify_license($open);
            echo '<div '.$this->addBlockStyle().' class="max-sb-block max-sb-activities js-max-sb-activities"   '.$dataAttributes.' data-id="max-sbd-activities-'.substr(bin2hex($args['location']), 0, 20).'">';
            $this->getGifMaxLoader();
            echo '<div class="max-sb-block__area max-sb-block--loading">';
            echo '<div class="max-sb-gmap"  style="display: none;"></div>';
            echo '<div>';
            $this->getTitle($title);
            echo '<div class="max-sb__list js-max-sb-list"></div>';

            echo '</div></div></div>';
            $this->getGifMaxLoaderHide();
        else:
            $this->noDataAvailable($title);
        endif;

    }

    public function map_html($args){

        $dataLocation = (isset($args['location']) && $args['location'] !== '')? 'data-location="'.$args['location'].'"' : '';
        $dataZoom = (isset($args['zoom']) && $args['zoom'] !== '')? 'data-zoom="'.$args['zoom'].'"' : '';
        $dataNeighborhood = (isset($args['neighborhood']) && $args['neighborhood'] !== '')? 'data-neighborhood="'.$args['neighborhood'].'"' : '';
        $dataActivities = (isset($args['activities']) && $args['activities'] !== '')? 'data-activities="'.$args['activities'].'"' : '';
        $dataAttributes = $dataLocation . ' ' . $dataZoom . ' ' . $dataNeighborhood . ' ' . $dataActivities;
        $title = ($args['title'] !== '')? $args['title'] : 'Google Map';
        $mapHeight = 'height: ' . $this->gmap_height . 'px;';
        if( isset($args['location']) && $args['location'] !== '' ):
            $this->max_verify_license(1);
            echo '<div '.$this->addBlockStyle().' class="max-sb-block max-sb-map js-max-sb-map"  '.$dataAttributes.'>';
            $this->getGifMaxLoader();
            echo '<div class="max-sb-block__area max-sb-block--loading">';
            $this->getTitle($title);
            echo '<div id="max-sb-map" class="max-sb-gmap" '.$this->addBlockStyle($mapHeight).'></div>';
            echo '</div></div>';
            $this->getGifMaxLoaderHide();
        else:
            $this->noDataAvailable($title);
        endif;

    }

    public function about_location_html($args){

        $dataLocation = (isset($args['location']) && $args['location'] !== '')? 'data-location="'.$args['location'].'"' : '';
        $dataLimit = (isset($args['limit']) && $args['limit'] !== '')? 'data-limit="'.$args['limit'].'"' : '';
        $dataKey = 'data-key="'.$this->apiKey.'"';
        $dataAttributes = $dataLocation . ' ' . $dataLimit . ' ' . $dataKey;
        $title = ($args['title'] !== '')? $args['title'] : $args['location'];
        $classes = 'max-sb-mb-0';
        if( isset($args['location']) && $args['location'] !== '' ):
            $open = 1;
            $this->max_verify_license($open);
            echo '<div '.$this->addBlockStyle().' class="max-sb-block max-sb-aboutlocation js-max-sb-aboutlocation"  '.$dataAttributes.' data-id="max-sbd-details-'.substr(bin2hex($args['location']), 0, 20).'">';
            $this->getGifMaxLoader();
            echo '<div class="max-sb-block__area max-sb-block--loading">';
            echo '<div><div class="max-sb-aboutlocation__header text-'.$this->headling_alignment.'">';
            $this->getTitle($title, $classes);
            echo '<p class="max-sb-gray">City of '.$args['location'].'</p>';
            echo '</div>';
            echo '<div class="max-sb-desc js-max-sb-desc" style="font-size: '.$this->paragraphSize.'px;"></div>';
            echo '<ul class="max-sb-ul">';
            echo '<li><strong>Area:</strong> <span class="js-max-sb-area">' . $this->getGifMaxDualLoader(). '</span></li>';
            echo '<li><strong>Local Time:</strong> <span class="js-max-sb-timezone">' . $this->getGifMaxDualLoader(). '</span></li>';
            echo '<li><strong>Mayor:</strong> <span class="js-max-sb-mayor">' . $this->getGifMaxDualLoader(). '</span></li>';
            echo '<li><strong>Weather:</strong> <span class="js-max-sb-weather">' . $this->getGifMaxDualLoader(). '</span></li>';
            echo '<li><strong>Population:</strong> <span class="js-max-sb-population">' . $this->getGifMaxDualLoader(). '</span></li>';
            echo '</ul></div></div></div>';
            $this->getGifMaxLoaderHide();
        else:
            $this->noDataAvailable($title);
        endif;

    }

    public function directions_html($args){

	    global $post;
        $current_id = $post->ID;
        $dataLocation = (isset($args['address']) && $args['address'] !== '')? 'data-address="'.$args['address'].'"' : '';
        $dataZoom = (isset($args['zoom']) && $args['zoom'] !== '')? 'data-zoom="'.$args['zoom'].'"' : '';
        $dataCity = (isset($args['city']) && $args['city'] !== '')? 'data-city="'.$args['city'].'"' : '';
        $dataPins = (isset($args['pins']) && $args['pins'] !== '')? 'data-pins="'.$args['pins'].'"' : '';
        $dataAttributes = $dataLocation . ' ' . $dataZoom . ' ' . $dataCity . ' ' . $dataPins;
        $title = ($args['title'] !== '')? $args['title'] : 'Google Map';
        $mapHeight = 'height: ' . $this->gmap_height . 'px;';

        if( isset($args['address']) && $args['address'] !== '' && isset($args['city']) && $args['city'] !== '' ):
            $open = 1;
            $this->max_verify_license($open);
            echo '<div '.$this->addBlockStyle().' class=" max-sb-block js-max-sb-directions"  '.$dataAttributes.' data-id="max-sbd-'.substr(bin2hex($args['address']), 0, 20).'">';
            $this->getGifMaxLoader();
            echo '<div class="max-sb-block__area max-sb-block--loading">';
            $this->getTitle($title);
            echo '<div class="max-sb-directions__area max-sb-directions ">';
            echo '<div class="max-sb-directions__sidebar js-max-sb-directions-sidebar">';
            echo '<ul id="js-max-sb-direction-routes" class="max-sb-directions__routes"></ul>';
            echo '<button class="js-clear-routes btn-clear-routes">Clear all routes</button>';
            echo '</div>';
            echo '<div class="max-sb-directions__content">';
            echo '<div id="max-sb-directions-map" style="width:100%;height:100%"></div>';
            echo '<div id="max-sb-directions-map2" style="display: none;width:100%;height:100%"></div>';
            echo '</div></div></div></div>';
        else :
            echo '<div '.$this->addBlockStyle().' class="max-sb-block js-max-sb-directions" >';
            echo 'Please add the location address and city.';
            echo '</div>';
            $this->getGifMaxLoaderHide();
            $this->noDataAvailable($title);
        endif;
    }

    public function airports_html($args){

        $mapHeight      = 'height: ' . $this->gmap_height . 'px;';
        $title          = 'Nearest Airport';
        $url            = $args['address'];
        $radius         = $args['radius'] * 1609.34;
        $response       = $this->max_get_curl_api_response($url, $this->apiKey, '', '', '', '', '', '', '');
        $response       = json_decode($response, true)['results'];
        $response       = (!empty($response)) ? $response[0] : '';

        $from_lat         = (!empty($response)) ? $response['geometry']['location']['lat'] : '';

        $from_lng         = (!empty($response)) ? $response['geometry']['location']['lng'] : '';
        $airpor_res     = $this->max_get_curl_api_response($url, $this->apiKey, $from_lat, $from_lng, $radius, '', '', '', '');
        $airpor_res     = json_decode($airpor_res, true)['results'];

        $count = count($airpor_res) - 1;

        if(!empty($airpor_res) && !empty($airpor_res[0]['geometry']['location']['lat'])) {
            $to_lat       = $airpor_res[0]['geometry']['location']['lat'];
            $to_lng       = $airpor_res[0]['geometry']['location']['lng'];

            $route_detail   = $this->max_get_curl_api_response($url, $this->apiKey, $from_lat, $from_lng, $radius, '', $to_lat, $to_lng, '');
            $route_detail   = json_decode($route_detail, true);
            $distance_dtl   = $this->max_get_curl_api_response($url, $this->apiKey, $from_lat, $from_lng, $radius, '', $to_lat, $to_lng, 'distance');
            $distance_dtl   = json_decode($distance_dtl, true);

            $distance       = (!empty($route_detail) && !empty($route_detail['routes'][0]['legs'][0])) ? $route_detail['routes'][0]['legs'][0]['distance']['text'] : '';
            $route_details  = (!empty($route_detail) && !empty($route_detail['routes'][0]['legs'][0])) ? $route_detail['routes'][0]['legs'][0]['steps'] : '';

            $iata_res       = $this->max_get_curl_api_response($url, $this->apiKey, $to_lat, $to_lng, $radius, 'iata', '', '', '');
            $iata_res       = json_decode($iata_res, true);

            $open           = 2;
            if (isset($args['address']) && $args['address'] !== ''):
                $this->max_verify_license($open);
                $this->getGifMaxLoader();
                ?>
                <div class="max-sb-block hide_not_verify" style="display: none">
                    <?php echo $this->getTitle('Nearest Airport'); ?>
                    <ul class="max-sb-ul">
                        <li>
                            <strong>Name</strong>
                            <span><?php echo $airpor_res[0]['name'] ?></span>
                        </li>
                        <li>
                            <strong>IATA</strong>
                            <span><?php echo $iata_res['IATA'] ?></span>
                        </li>
                        <li>
                            <strong>Distance</strong>
                            <span><?php echo $distance ?></span>
                        </li>
                        <li>
                            <strong>Address</strong>
                            <span><?php echo $url ?> </span>
                        </li>
                    </ul>
                    <input type="hidden" value="<?php echo $from_lat; ?>" id="from_lat">
                    <input type="hidden" value="<?php echo $from_lng; ?>" id="from_lng">
                    <input type="hidden" value="<?php echo $to_lat; ?>" id="to_lat">
                    <input type="hidden" value="<?php echo $to_lng; ?>" id="to_lng">
                    <div class="max-sb-airport">
                        <div class="max-sb-airport-sidebar" style="position: relative">
                            <ul class="max-sb-airport-routes">
                                <?php foreach($route_details as $route_detail): ?>
                                    <ul>
                                        <li><?php echo $route_detail['html_instructions']?></li>
                                        <li><?php echo $route_detail['duration']['text'].' ('.$route_detail['distance']['text'].')' ?></li>
                                    </ul>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="max-sb-airport-map">
                            <div <?php echo $this->addBlockStyle($mapHeight) ?> id="airtport-map"></div>
                        </div>
                    </div>
                </div>
                <?php
            endif;
            $this->getGifMaxLoaderHide();
        }
        else {
            ?>
            <div class="max-sb-block hide_not_verify" style="display:none;">
                <?php echo $this->getTitle($title); ?>
                <p>Sorry! no result available for <br />
                    <b>Address: </b><?php echo ' '.$url;?></p>
            </div>
            <?php
        }
    }

    public function noDataAvailable($title){
        ?>
        <div class="max-sb-block hide_not_verify" >
            <?php echo $this->getTitle($title); ?>
            <p>Sorry! no result available</p>
        </div>
        <?php
    }

    public function addBlockStyle( $styles = null ){

	    $properties = '';
        $properties .= 'margin-bottom:' . $this->margin_bottom . 'px;';
        $properties .= $styles;
        return ' style="'.$properties.'"' ;
    }

    public function max_enque_scripts($open){
        global $wp_scripts;
        ?>
        <script>
            var weather_api = '<?php echo $this->weatherApiKey ?>';
            var apiKey = '<?php echo $this->apiKey ?>';
        </script>
        <?php
        wp_enqueue_script( $this->plugin_name . '-googlemap');
        wp_enqueue_script( $this->plugin_name . '-max-cluster-marker');
        wp_enqueue_script( $this->plugin_name . '-max-regions');
        wp_enqueue_script( $this->plugin_name . '-max-localcache');
        wp_enqueue_script( $this->plugin_name . '-max-scrolanimation');
        wp_enqueue_script( $this->plugin_name . '-max-frontend');
        if($open == 2){
            //wp_enqueue_script( $this->plugin_name . '-googlemaps', 'https://maps.googleapis.com/maps/api/js?key='.$this->apiKey.'&callback=initializeMap&v=weekly', array(), false, true );
            wp_enqueue_script( $this->plugin_name . '-max-frontend-airport');
        }
    }
    public function max_verify_license($open){
       //$this->max_enque_scripts($open);
       //return;
        if(empty($this->licenseKey)){
            echo '<p style="color: red">Please get your license key and save and verify in settings tab for using these features</p>';
        }
        else{
            if($this->licenses_res['code'] != 200 || ($this->licenses_res['code'] == 200 && isset($this->licenses_res['expiry_msg']) && $this->licenses_res['expiry_date']<= date("Y-m-d"))){
                echo '<p style="color: red">'.$this->licenses_res['msg'].'</p>';
            }
            else{
                $this->max_enque_scripts($open);
                ?>
                <style>
                    .hide_not_verify{
                        display: block !important;
                    }
                </style>
                <?php
            }
        }
    }

    public function getTitle($title, $cssClasses = '') {

        echo '<h2 class="max-sb__title '.$cssClasses.' text-'.$this->headling_alignment.'" style="font-size:'.$this->headingSize.'px; color:'.$this->headingColor.'">'.$title.'</h2>';

    }

    public function getGifMaxLoader() {
        echo  '<div class="max-sb-loader js-max-sb-loader" id="max-sb-loader">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:#fff;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" r="32" stroke-width="8" stroke="#6afd45" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
                      <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>
                    </circle>
                    <circle cx="50" cy="50" r="23" stroke-width="8" stroke="#f8b26a" stroke-dasharray="36.12831551628262 36.12831551628262" stroke-dashoffset="36.12831551628262" fill="none" stroke-linecap="round">
                      <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 50;-360 50 50"></animateTransform>
                    </circle>
                </svg>
            </div>';
    }

    public function getGifMaxDualLoader() {
        return '<em class="max-sb-small-loader js-max-sb-small-loader">

            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:#fff;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">

                    <circle cx="50" cy="50" r="32" stroke-width="8" stroke="#6afd45" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">

                      <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>

                    </circle>

                    <circle cx="50" cy="50" r="23" stroke-width="8" stroke="#f8b26a" stroke-dasharray="36.12831551628262 36.12831551628262" stroke-dashoffset="36.12831551628262" fill="none" stroke-linecap="round">

                      <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 50;-360 50 50"></animateTransform>

                    </circle>

                </svg>

        </em>';

    }

    public function getGifMaxLoaderHide() {
	    ?>
        <style>
            .js-max-sb-loader{
                display: none;
            }
        </style>
        <?php

    }

    public function max_get_curl_api_response($address, $api_key, $lat, $lng, $radius, $iata, $to_lat, $to_lng, $distance) {
        $curl   = curl_init();
        if(!empty($iata) && !empty($iata) && empty($distance)){
            curl_setopt(
                $curl,
                CURLOPT_URL,
                'https://iatageo.com/getCode/'.$lat.'/'.$lng
            );
        }
        else if(!empty($to_lat) && !empty($to_lng) && empty($distance)){
            curl_setopt(
                $curl,
                CURLOPT_URL,
                'https://maps.googleapis.com/maps/api/directions/json?origin='.$lat.','.$lng.'&destination='.$to_lat.','.$to_lng.'&key='.$api_key
            );
        }
        else if(!empty($distance)){
            curl_setopt(
                $curl,
                CURLOPT_URL,
                'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$lat.','.$lng.'&destinations='.$to_lat.','.$to_lng.'&mode=driving&sensor=false&key='.$api_key
            );
        }
        else if(!empty($lat) && !empty($lng) && empty($to_lng) && empty($distance)){
            curl_setopt(
                $curl,
                CURLOPT_URL,
                'https://maps.googleapis.com/maps/api/place/nearbysearch/json?keyword=airport&location=' . $lat.','.$lng.'&radius='.$radius.'&type=airport&key='.$api_key
//                'https://maps.googleapis.com/maps/api/place/textsearch/json?query=airport&location=' . $lat.','.$lng.'&radius='.$radius.'&type=airport&key='.$api_key
            );
        }
        else{
            curl_setopt(
                $curl,
                CURLOPT_URL,
                'https://maps.googleapis.com/maps/api/geocode/json?address=' . rawurlencode($address) . '&key=' . $api_key
            );
        }

        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);

        $response              = curl_exec($curl);

        curl_close($curl);

        return ($response);

    }

}