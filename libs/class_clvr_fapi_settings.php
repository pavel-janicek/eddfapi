<?php

if (!class_exists('Clvr_Fapi_Settings')){

    class Clvr_Fapi_Settings{

        private $context = "eddfapi";

        function __construct(){
            add_filter( 'edd_settings_sections_extensions', array($this,'settings_section') );
            add_filter( 'edd_settings_extensions', array($this,'add_settings') );
            add_action( 'edd_purchase_form_user_info_fields', array($this,'checkout_fields') );
           
        }  

        public function settings_section($sections){
            
			$sections['eddfapi-settings'] = __( 'Nastavení FAPI', 'eddfapi' );
			return $sections;
        }
        
        public function add_settings($settings){
            
            $eddfapi_settings = array (
				array(
					'id' => 'eddfapi_settings',
					'name' => '<strong>Nastavení propojení EDD s FAPI</strong>',
					'desc' => 'Níže uvedené údaje se budou zobrazovat na každé vystavené faktuře.',
					'type' => 'header'
				),
		    array(
		      'id' => 'eddfapi_login',
		      'name' => 'Přihlašovací email',
					'desc' => 'E-Mail který jste uvedli ve FAPI',
					'type' => 'text',
					'size' => 'regular'
		    ),
		    array(
		      'id' => 'eddfapi_token',
		      'name' => 'Token FAPI',
					'desc' => 'Vygenerovaný token',
					'type' => 'text',
					'size' => 'regular'
		    ),
				
			array(
		      'id' => 'eddfapi_povinne_prijmeni',
		      'name' => 'Povinné příjmení',
					'desc' => 'Má být příjmení povinné?',
					'type' => 'checkbox'
		    ),
			array(
		      'id' => 'eddfapi_povinny_stat',
		      'name' => 'Povinný stát',
					'desc' => 'Má být stát povinný?',
					'type' => 'checkbox'
		    ),
				array(
		      'id' => 'eddfapi_povinna_ulice',
		      'name' => 'Povinná ulice',
					'desc' => 'Má být ulice povinná?',
					'type' => 'checkbox'
		    ),
				array(
		      'id' => 'eddfapi_povinne_mesto',
		      'name' => 'Povinné město',
					'desc' => 'Má být město povinné?',
					'type' => 'checkbox'
		    ),
				array(
		      'id' =>  'eddfapi_povinne_psc',
		      'name' => 'Povinné PSČ',
					'desc' => 'Má být PSČ povinné?',
					'type' => 'checkbox'
		    ),
				array(
					'id' => 'eddfapi_povinne_firemni_udaje',
		      'name' => 'Skrýt formulář nákupu na firmu',
					'desc' => 'pokud bude zaškrtnuto, tak se formulář s nákupem na firmu nezobrazí',
					'type' => 'checkbox'
				 )
			);
            if ( version_compare( EDD_VERSION, 2.5, '>=' ) ) {
				$eddfapi_settings = array( 'eddfapi-settings'  => $eddfapi_settings );
			}
			return array_merge( $settings, $eddfapi_settings );
    }

    public function checkout_fields() {
    	global $edd_options;
    	if(isset($edd_options[$this->context.'_povinne_firemni_udaje']) && !empty($edd_options[$this->context.'_povinne_firemni_udaje'])){
    		return;
    	}
    ?>
        <p id="edd-faktura-general">
    	  <strong>Fakturační údaje:</strong>
    	</p>
        <p id="edd-faktura-firma-wrap">
            <label class="edd-label" for="edd-firma">Název společnosti</label>
            <span class="edd-description">
            	Vyplňte název vaší společnosti. Pokud toto pole vyplníte, vaše křestní jméno se na faktuře neobjeví
            </span>
            <input class="edd-input" type="text" name="edd_firma" id="edd-firma" placeholder="" />
        </p>
    		<?php if(isset($edd_options[$this->context.'_povinny_stat']) && !empty($edd_options[$this->context.'_povinny_stat'])): ?>
    	<p id="edd-faktura-stat-wrap">
            <label class="edd-label" for="edd-stat">Stát <span class="edd-required-indicator">*</span></label>
            <span class="edd-description">
            	Vyplňte stát vaší společnosti
            </span>
            <input class="edd-input" type="text" name="edd_stat" id="edd-stat" value="Česká Republika" />
        </p>
    	<?php endif;?>
        <p id="edd-faktura-ic-wrap">
            <label class="edd-label" for="edd-ic">IČ</label>
            <span class="edd-description">
            	Vyplňte IČ vaší společnosti
            </span>
            <input class="edd-input" type="text" name="edd_ic" id="edd-ic" placeholder="" />
        </p>
        <p id="edd-faktura-dic-wrap">
            <label class="edd-label" for="edd-dic">DIČ</label>
            <span class="edd-description">
            	Vyplňte DIČ vaší společnosti
            </span>
            <input class="edd-input" type="text" name="edd_dic" id="edd-dic" placeholder="" />
        </p>
    		<?php if(isset($edd_options[$this->context.'_povinna_ulice']) && !empty($edd_options[$this->context.'_povinna_ulice'])): ?>
    	<p id="edd-faktura-ulice-wrap">
            <label class="edd-label" for="edd-ulice">Ulice a číslo popisné <span class="edd-required-indicator">*</span></label>
            <span class="edd-description">
            	Vyplňte ulici sídla vaší společnosti
            </span>
            <input class="edd-input" type="text" name="edd_ulice" id="edd-ulice" placeholder="" />
        </p>
    	<?php endif;?>
    	<?php if(isset($edd_options[$this->context.'_povinne_mesto']) && !empty($edd_options[$this->context.'_povinne_mesto'])): ?>
    	<p id="edd-faktura-mesto-wrap">
            <label class="edd-label" for="edd-mesto">Město <span class="edd-required-indicator">*</span></label>
            <span class="edd-description">
            	Vyplňte město sídla vaší společnosti
            </span>
            <input class="edd-input" type="text" name="edd_mesto" id="edd-mesto" placeholder="" />
        </p>
    		<?php endif;?>
    		<?php if(isset($edd_options[$this->context.'_povinne_psc']) && !empty($edd_options[$this->context.'_povinne_psc'])): ?>
    	<p id="edd-faktura-psc-wrap">
            <label class="edd-label" for="edd-psc">PSČ <span class="edd-required-indicator">*</span></label>
            <span class="edd-description">
            	Vyplňte PSČ
            </span>
            <input class="edd-input" type="text" name="edd_psc" id="edd-psc" placeholder="" />
        </p>
        <?php endif;
    }
    
        
        
    } //class


}// class exists