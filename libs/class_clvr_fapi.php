<?php
if (!class_exists('Clvr_Fapi')){

    class Clvr_Fapi{
        
        const INVOICE_ID_META_KEY = "_fapi_invoice_id";
        const CUSTOMER_ID_META_KEY = '_fapi_client_id';
        private $context = 'eddfapi';
        private $fapiClient;
        
        function __construct($onlyPdf = false){
        if(!$onlyPdf){
            require 'class_clvr_fapi_settings.php';
            require 'class_edd_customer_meta_wrapper.php';
            $settings = new Clvr_Fapi_Settings();
            add_filter( 'edd_payment_meta', array($this,'store_payment_meta') );
            add_action( 'edd_payment_personal_details_list', array($this,'view_order_details'), 10, 2 );
            add_filter( 'edd_purchase_form_required_fields', array($this,'purchase_form_required_fields') );
            add_action( 'edd_payment_receipt_after', array($this, 'addInvoiceToThankYou'), 10 );
            add_action( 'edd_complete_purchase', array($this, 'setInvoicePaid') );
            add_action( 'init', array($this,'listener'));
            remove_action('edd_purchase_form_after_cc_form','edd_checkout_tax_fields',999);
            add_filter( 'edd_require_billing_address', '__return_false', 9999 );
            add_action( 'edd_add_email_tags', array($this, 'add_email_tags'),10,1 );
            
        }    
        
        }

        public function isInitialized(){
            global $edd_options;
            return (isset($edd_options[$this->context.'_login'])) and (isset($edd_options[$this->context.'_token']));
        }

        public function getFapiClient(){
            if (!$this->isInitialized()){
                return null;
            }
            if (!empty($this->fapiClient)){
                return $this->fapiClient;
            }
            global $edd_options;

            $username = $edd_options['eddfapi_login'];
      		$password = $edd_options['eddfapi_token'];
	        $apiUrl = 'https://api.fapi.cz';
            $httpClient = new \Fapi\HttpClient\CurlHttpClient();
            $clientFactory = new \Fapi\FapiClient\FapiClientFactory($apiUrl,$httpClient);
            $this->fapiClient = $clientFactory->createFapiClient($username,$password);
            return $this->fapiClient;

        }

        function all_extra_fields() {
            $eddvyfakturuj_fields[] = "edd_firma";
            $eddvyfakturuj_fields[] = "edd_stat";
            $eddvyfakturuj_fields[] = "edd_ic";
            $eddvyfakturuj_fields[] = "edd_dic";
            $eddvyfakturuj_fields[] = "edd_ulice";
            $eddvyfakturuj_fields[] = "edd_mesto";
            $eddvyfakturuj_fields[] = "edd_psc";
            return $eddvyfakturuj_fields;
        }
      
        public function store_payment_meta($payment_meta){
            $extra_fields = $this->all_extra_fields();
            foreach ($extra_fields as $key => $extra_field){
                  if(empty($payment_meta[$extra_field])){
                      $payment_meta[$extra_field] = isset( $_POST[$extra_field] ) ? sanitize_text_field( $_POST[$extra_field] ) : '';
                  }
            }
            return $payment_meta;
        }

        public function view_order_details( $payment_meta, $user_info ) {
            $firma = isset( $payment_meta['edd_firma'] ) ? $payment_meta['edd_firma'] : 'položka neuvedena';
            $stat = isset( $payment_meta['edd_stat'] ) ? $payment_meta['edd_stat'] : 'položka neuvedena';
            $ic = isset( $payment_meta['edd_ic'] ) ? $payment_meta['edd_ic'] : 'položka neuvedena';
            $dic = isset( $payment_meta['edd_dic'] ) ? $payment_meta['edd_dic'] : 'položka neuvedena';
            $ulice = isset( $payment_meta['edd_ulice'] ) ? $payment_meta['edd_ulice'] : 'položka neuvedena';
            $mesto = isset( $payment_meta['edd_mesto'] ) ? $payment_meta['edd_mesto'] : 'položka neuvedena';
            $psc = isset( $payment_meta['edd_psc'] ) ? $payment_meta['edd_psc'] : 'položka neuvedena';
            //$fapi_link = https://web.fapi.cz/invoice/detail/185240268?projectId=all
        ?>
            <div class="column-container">
                <div class="column">
                    <strong>Firma: </strong>
                     <?php echo $firma; ?>
                </div>
                <div class="column">
                    <strong>Stát: </strong>
                     <?php echo $stat; ?>
                </div>
                <div class="column">
                    <strong>IČ: </strong>
                     <?php echo $ic; ?>
                </div>
                <div class="column">
                    <strong>DIČ: </strong>
                     <?php echo $dic; ?>
                </div>
                <div class="column">
                    <strong>Ulice a číslo popisné: </strong>
                     <?php echo $ulice; ?>
                </div>
                <div class="column">
                    <strong>Město: </strong>
                     <?php echo $mesto; ?>
                </div>
                <div class="column">
                    <strong>PSČ: </strong>
                     <?php echo $psc; ?>
                </div>
                
            </div>
        <?php
        }

        public function purchase_form_required_fields( $required_fields ) {
            global $edd_options;
            if(isset($edd_options[$this->context.'_povinne_prijmeni']) && !empty($edd_options[$this->context.'_povinne_prijmeni'])){
                $required_fields['edd_last'] = array(
                'error_id' => 'invalid_last_name',
                'error_message' => 'Prosím vyplňte příjmení.'
            );
            }
            if(isset($edd_options[$this->context.'_povinny_stat']) && !empty($edd_options[$this->context.'_povinny_stat'])){
                    $required_fields['edd_stat'] = array(
                    'error_id' => 'invalid_edd_stat',
                    'error_message' => 'Prosím vyplňte stát.'
                );
                }
                if(isset($edd_options[$this->context.'_povinna_ulice']) && !empty($edd_options[$this->context.'_povinna_ulice'])){
                    $required_fields['edd_ulice'] = array(
                    'error_id' => 'invalid_edd_ulice',
                    'error_message' => 'Prosím vyplňte ulici a číslo popisné.'
                );
                }
                if(isset($edd_options[$this->context.'_povinne_mesto']) && !empty($edd_options[$this->context.'_povinne_mesto'])){
                    $required_fields['edd_mesto'] = array(
                    'error_id' => 'invalid_edd_mesto',
                    'error_message' => 'Prosím vyplňte město.'
                );
                }
                if(isset($edd_options[$this->context.'_povinne_psc']) && !empty($edd_options[$this->context.'_povinne_psc'])){
                $required_fields['edd_psc'] = array(
                'error_id' => 'invalid_edd_psc',
                'error_message' => 'Prosím vyplňte PSČ.'
            );
             }
            return $required_fields;
        }

        public function add_email_tags($payment_id){
            edd_add_email_tag( $this->context.'_firma', 'Firma zákazníka', array($this,'email_tag_firma') );
            edd_add_email_tag( $this->context.'_stat', 'Stát zákazníka', array($this, 'email_tag_stat') );
            edd_add_email_tag( $this->context.'_ic', 'IČ zákazníka', array($this, 'email_tag_ic') );
            edd_add_email_tag( $this->context.'_dic', 'DIČ zákazníka', array($this, 'email_tag_dic') );
            edd_add_email_tag( $this->context.'_ulice', 'Ulice a číslo popisné zákazníka', array($this,'email_tag_ulice') );
            edd_add_email_tag( $this->context.'_mesto', 'Město zákazníka', array($this,'email_tag_mesto') );
            edd_add_email_tag( $this->context.'_psc', 'PSČ zákazníka', array($this,'email_tag_psc') );
            edd_add_email_tag( $this->context.'_polozky', 'Položky v košíku', array($this,'email_tag_polozky') );
            edd_add_email_tag( $this->context.'_datum', 'Datum nákupu', array($this,'email_tag_datum') );
            edd_add_email_tag( $this->context.'_faktura_link', 'Neformátovaný odkaz na fakturu', array($this,'getInvoiceLink') );
            edd_add_email_tag( $this->context.'_faktura', 'Vloží odkaz s textem Fakturu si stáhněte zde', array($this,'getInvoiceDownload') );
        }

        /**
     * The {Firma} email tag
     */
    public function email_tag_firma( $payment_id ) {
    	$payment_data = edd_get_payment_meta( $payment_id );
    	return $payment_data['edd_firma'];
    }

    /**
     * The {Stat} email tag
     */
    public function email_tag_stat( $payment_id ) {
    	$payment_data = edd_get_payment_meta( $payment_id );
    	return $payment_data['edd_stat'];
    }

    /**
     * The {IC} email tag
     */
    public function email_tag_ic( $payment_id ) {
    	$payment_data = edd_get_payment_meta( $payment_id );
    	return $payment_data['edd_ic'];
    }

    /**
     * The {DIC} email tag
     */
    public function email_tag_dic( $payment_id ) {
    	$payment_data = edd_get_payment_meta( $payment_id );
    	return $payment_data['edd_dic'];
    }

    /**
     * The {Ulice} email tag
     */
    public function email_tag_ulice( $payment_id ) {
    	$payment_data = edd_get_payment_meta( $payment_id );
    	return $payment_data['edd_ulice'];
    }

    /**
     * The {Mesto} email tag
     */
    public function email_tag_mesto( $payment_id ) {
    	$payment_data = edd_get_payment_meta( $payment_id );
    	return $payment_data['edd_mesto'];
    }

    /**
     * The {PSC} email tag
     */
    public function email_tag_psc( $payment_id ) {
    	$payment_data = edd_get_payment_meta( $payment_id );
    	return $payment_data['edd_psc'];
    }

    public function email_tag_polozky($payment_id){
       $decissions = $this->format_cart_items($payment_id);
       return $decissions[1];
    }

    public function email_tag_datum($payment_id){
      $payment_meta = edd_get_payment_meta( $payment_id );
      $date = DateTime::createFromFormat('Y-m-d G:i:s', $payment_meta['date']);
      return $date->format('d.m. Y');
    }

    private function format_cart_items($payment_id){
        if (function_exists('get_home_path')){
        	$path = get_home_path();
        	$path .= "wp-content/plugins/easy-digital-downloads/includes/payments/class-edd-payment.php";
        }else{
        	$path = dirname(__FILE__) . "/../easy-digital-downloads/includes/payments/class-edd-payment.php";
        }
        require_once($path);

    	$cart_items = edd_get_payment_meta_cart_details( $payment_id );
      $payment = new EDD_Payment( $payment_id );
    	$payment_data  = $payment->get_meta();
    	$download_list = '<ul>';
    	$cart_items    = $payment->cart_details;
    	$email         = $payment->email;
        	if ( $cart_items ) {
    		$show_names = apply_filters( 'edd_email_show_names', true );
    		$show_links = apply_filters( 'edd_email_show_links', true );
            $i = 0;
    		foreach ( $cart_items as $item ) {
    			if ( edd_use_skus() ) {
    				$sku = edd_get_download_sku( $item['id'] );
    			}

    				$quantity = $item['quantity'];
                    $pavelCart[$i]['quantity'] = $item['quantity'];

            $price_id = edd_get_cart_item_price_id( $item );
    			//if ( $show_names ) {
    			if ( false ) {
    				$title = '<strong>' . get_the_title( $item['id'] ) . '</strong>';

    				if ( ! empty( $quantity ) && $quantity > 1 ) {
    					$title .= "&nbsp;&ndash;&nbsp;" . __( 'Quantity', 'easy-digital-downloads' ) . ': ' . $quantity;
    				}
    				if ( ! empty( $sku ) ) {
    					$title .= "&nbsp;&ndash;&nbsp;" . __( 'SKU', 'easy-digital-downloads' ) . ': ' . $sku;
    				}
    				if ( $price_id !== null ) {
    					$title .= "&nbsp;&ndash;&nbsp;" . edd_get_price_option_name( $item['id'], $price_id, $payment_id );

    				}
    				$download_list .= '<li>' . apply_filters( 'edd_email_receipt_download_title', $title, $item, $price_id, $payment_id ) . '<br/>';
    			}
          			$price_id = edd_get_cart_item_price_id( $item );
                    $pavelCart[$i]['price_id']  = edd_get_cart_item_price_id( $item );
    			if ( $show_names ) {
    				$title = '<strong>' . get_the_title( $item['id'] ) . '</strong>';
                    $pavelCart[$i]['title'] = get_the_title( $item['id'] );
    				if ( ! empty( $quantity )  ) {
    					$title .= "&nbsp;&ndash;&nbsp;" . __( 'Množství', 'easy-digital-downloads' ) . ': ' . $quantity ." ks";
    				}
    				if ( ! empty( $sku ) ) {
    					$title .= "&nbsp;&ndash;&nbsp;" . __( 'SKU', 'easy-digital-downloads' ) . ': ' . $sku;
    				}
    				if ( $price_id !== null ) {
    					$title .= "&nbsp;&ndash;&nbsp;" . edd_get_price_option_name( $item['id'], $price_id, $payment_id );
                        $pavelCart[$i]['price_option_name'] = edd_get_price_option_name( $item['id'], $price_id, $payment_id );
    				}
                    $title .="&nbsp;&ndash;&nbsp;" . "Jednotková cena: " .$item["price"]. " CZK</span>";
                    $pavelCart[$i]['jednotkova_cena'] = $item["price"];
                    //$title .="<span>; " .$item["quantity"]. " ks";
                    $i++;
    				$download_list .= '<li>' . apply_filters( 'edd_email_receipt_download_title', $title, $item, $price_id, $payment_id ) . '<br/>';
    			}
    			$files = edd_get_download_files( $item['id'], $price_id );
    			if ( ! empty( $files ) ) {
    				foreach ( $files as $filekey => $file ) {
    					if ( $show_links ) {
    						$download_list .= '<div>';
    							$file_url = edd_get_download_file_url( $payment_data['key'], $email, $filekey, $item['id'], $price_id );
    							$download_list .= '<a href="' . esc_url( $file_url ) . '">' . edd_get_file_name( $file ) . '</a>';
    							$download_list .= '</div>';
    					} else {
    						$download_list .= '<div>';
    							$download_list .= edd_get_file_name( $file );
    						$download_list .= '</div>';
    					}
    				}
    			} elseif ( edd_is_bundled_product( $item['id'] ) ) {
    				$bundled_products = apply_filters( 'edd_email_tag_bundled_products', edd_get_bundled_products( $item['id'] ), $item, $payment_id, 'download_list' );
    				foreach ( $bundled_products as $bundle_item ) {
    					$download_list .= '<div class="edd_bundled_product"><strong>' . get_the_title( $bundle_item ) . '</strong></div>';
    					$files = edd_get_download_files( $bundle_item );
    					foreach ( $files as $filekey => $file ) {
    						if ( $show_links ) {
    							$download_list .= '<div>';
    							$file_url = edd_get_download_file_url( $payment_data['key'], $email, $filekey, $bundle_item, $price_id );
    							$download_list .= '<a href="' . esc_url( $file_url ) . '">' . edd_get_file_name( $file ) . '</a>';
    							$download_list .= '</div>';
    						} else {
    							$download_list .= '<div>';
    							$download_list .= edd_get_file_name( $file );
    							$download_list .= '</div>';
    						}
    					}
    				}
    			}
    			if ( '' != edd_get_product_notes( $item['id'] ) ) {
    				$download_list .= ' &mdash; <small>' . edd_get_product_notes( $item['id'] ) . '</small>';
    			}
    			if ( $show_names ) {
    				$download_list .= '</li>';
    			}
    		}
    	}
    	$download_list .= '</ul>';

        $decissions = array(
           '1' =>$download_list,
           '2' =>$pavelCart
        );
    	return $decissions;

    }

    public function getsTreet($payment_id){
        $street = get_post_meta($payment_id,'street',true);
        if (!empty($street)){
             return $street;
        }     
        $payment      = new EDD_Payment( $payment_id );
        $payment_meta   = $payment->get_meta();
        if (isset($payment_meta['edd_ulice'])){
            return $payment_meta['edd_ulice'];
        }
        

    }

    public function getCity($payment_id){
        $city = get_post_meta($payment_id,'city',true);
        if (!empty($city)){
            return $city;
        }
        $payment      = new EDD_Payment( $payment_id );
        $payment_meta   = $payment->get_meta();
        if (isset($payment_meta['edd_mesto'])){
            return $payment_meta['edd_mesto'];        
        }
        
    }

    public function getZip($payment_id){
        $zip = get_post_meta($payment_id,'zip',true);
        if (!empty($zip)){
            return $zip;       
        }
        $payment      = new EDD_Payment( $payment_id );
        $payment_meta   = $payment->get_meta();
        if (isset($payment_meta['edd_psc'])){
            return $payment_meta['edd_psc'];        
        } 

    }

    public function getIC($payment_id){
        $ic = get_post_meta($payment_id,'ic',true);
        if (!empty($ic)){
            return $ic;    
        }        
        $payment      = new EDD_Payment( $payment_id );
        $payment_meta   = $payment->get_meta();
        if (isset($payment_meta['edd_ic'])){
            return $payment_meta['edd_ic'];        
        } 
    }

    public function getDIC($payment_id){
        $dic = get_post_meta($payment_id,'dic',true);
        if(!empty($dic)){
            return $dic;    
        }        
        $payment      = new EDD_Payment( $payment_id );
        $payment_meta   = $payment->get_meta();
        if (isset($payment_meta['edd_dic'])){
            return $payment_meta['edd_dic'];        
        } 

    }

    public function getFapiCustomer($payment_id){
        global $edd_options;
			$payment      = new EDD_Payment( $payment_id );
			$edd_customer_id = $payment->customer_id;
            $wrapper = new Clvr_EDD_Customer_Meta_wrapper();
            $customer_id = $wrapper->get_meta($edd_customer_id,self::CUSTOMER_ID_META_KEY);
			if (!empty($customer_id)){
				return $customer_id;
            }
            $payment_meta   = $payment->get_meta();
            $user_info = edd_get_payment_meta_user_info( $payment_id );
            $customer_data = [
                'email' => $user_info['email'],
                'ic' => $this->getIC($payment_id),
                'dic' => $this->getDIC($payment_id),
                'first_name' => $payment_meta['user_info']['first_name'],
                'last_name' => $payment_meta['user_info']['last_name'],
                'phone' => get_post_meta($payment_id,'telefon',true),
                'address' => [
                    'name' => $payment_meta['user_info']['first_name'],
                    'surname' => $payment_meta['user_info']['last_name'],
                    'street' => $this->getsTreet($payment_id),
                    'city' => $this->getCity($payment_id),
                    'zip' => $this->getZip($payment_id)
                ]

            ];
            $response = $this->getFapiClient()->getClients()->create($customer_data);
            $customer_id = $response['id'];
            $result = $wrapper->add_meta($edd_customer_id,self::CUSTOMER_ID_META_KEY,$customer_id);
            return $customer_id;
    }

    private function getInvoiceData($payment_id){
        $data = $this->prepareDataForInvoice($payment_id);
        return $data;
    }

    public function getInvoiceID($payment_id){
        if (!$this->isInitialized()){
            return;
        }

        $invoice_id = get_post_meta(  $payment_id, self::INVOICE_ID_META_KEY, true );
        if (!empty($invoice_id)){
            //return $this->getFapiClient()->getInvoices()->find($invoice_id);
            return $invoice_id;
        }
        $data = $this->prepareDataForInvoice($payment_id);
        $response = $this->getFapiClient()->getInvoices()->create($data);
        add_post_meta( $payment_id, self::INVOICE_ID_META_KEY, $response['id'] );
        return $response['id'];
    }

    public function getInvoice($invoice_id){
        if(!$this->isInitialized()){
            return;
        }
        //$invoice_id = $this->getInvoiceID($payment_id);
        return $this->getFapiClient()->getInvoices()->find($invoice_id);
    }

    

    public function prepareItemsForInvoice($payment_id){
        $payment_meta = edd_get_payment_meta( $payment_id );
        $cart = $payment_meta['cart_details'];
        $items = array();        
        foreach ($cart as $cart_item){
            $total =  $cart_item['item_price'] - $cart_item['discount'];
            $item = [
                'name' => $cart_item['name'],
                'price' => $total / $cart_item['quantity'],
                'count' => $cart_item['quantity'],
                //'vat' => $cart_item['tax'],
                'vat' => 10,
                'including_vat' => true
                //edd_is_cart_taxed()

            ];
            array_push($items,$item);
            
        }
        return $items;
    }

    public function getInvoiceLink($payment_id){
        $invoice_id = $this->getInvoiceID($payment_id);
        return get_home_url() . "?edd-listener=eddfapi&id=" . $invoice_id;
        
        
    }

    public function listener(){
        if (isset($_GET) && ($_GET['edd-listener'] == 'eddfapi')){
            if(!$this->isInitialized()){
                return;
            }
            if(isset($_GET['id'])){
                $invoice_id = $_GET['id'];
                
                
                try{
                    $full_invoice = $this->getInvoice($invoice_id);
                    $pdf = $this->getInvoicePdf($invoice_id);
                    $filename = $full_invoice['variable_symbol'] . '.pdf';
                }catch (Exception $e){
                    return;
                }
                header("Content-type:application/pdf");

                // It will be called {variable_symbol}.pdf
                header("Content-Disposition:attachment;filename={$filename}");

            

                // The PDF source is in original.pdf
                echo($pdf);
                exit;
            }
        }

        if (isset($_GET) && $_GET['edd-listener'] == 'eddfapidebug'){
            if (isset($_GET['payment_id'])){
                $payment_id = $_GET['payment_id'];
            }else{
                $payment_id = 8641;
            }
            $data = $this->getInvoiceData($payment_id);
            $payment_meta = edd_get_payment_meta( $payment_id );

            
            print_r($payment_meta);
            $payment = new EDD_Payment($payment_id);
            $user_info = edd_get_payment_meta_user_info( $payment_id );
            $customer_data = [
                'email' => $user_info['email'],
                'ic' => $this->getIC($payment_id),
                'dic' => $this->getDIC($payment_id),
                'first_name' => $payment_meta['user_info']['first_name'],
                'last_name' => $payment_meta['user_info']['last_name'],
                'phone' => get_post_meta($payment_id,'telefon',true),
                'address' => [
                    'name' => $payment_meta['user_info']['first_name'],
                    'surname' => $payment_meta['user_info']['last_name'],
                    'street' => $this->getsTreet($payment_id),
                    'city' => $this->getCity($payment_id),
                    'zip' => $this->getZip($payment_id)
                ]

            ];
            print_r($data);

            if (isset($_GET['send'])){
                $response = $this->getFapiClient()->getInvoices()->create($data);
                print_r($response);
            }
            
            exit;
        }
        

    }

    public function getInvoicePdf($invoice_id){
        return $this->getFapiClient()->getInvoices()->getPdf($invoice_id);
    }

    public function getInvoiceDownload($payment_id){
        $link = $this->getInvoiceLink($payment_id);
        $html = "<a href=\"" .$link. "\">Fakturu si stáhněte zde</a>";
        return $html;
      }

      

    public function getCartTotal($payment_id){
        $payment = new EDD_Payment($payment_id);

        return $payment->total;
    }  

    public function getCartTotalVat($payment_id){
        $payment = new EDD_Payment($payment_id);
        return $payment->tax;

    }



    public function prepareDataForInvoice($payment_id){
        $payment_meta = edd_get_payment_meta( $payment_id );
        $items = $this->prepareItemsForInvoice($payment_id);
        $customer_id = $this->getFapiCustomer($payment_id);
        $date = DateTime::createFromFormat('Y-m-d G:i:s', $payment_meta['date']);
        $payment = new EDD_Payment($payment_id);
        $data = [
            'client' => $customer_id,
            'items' => $items,
            'currency' => $payment_meta['currency'],
            'total' => $this->getCartTotal($payment_id),
            'total_vat' => $this->getCartTotalVat($payment_id),
            'vat_date' => $date->format('Y-m-d'),
            'variable_symbol' => $payment->number,
        ];
        return $data;

    }

    public function addInvoiceToThankYou( $payment ) {
        global $edd_options;
      if (!$this->isInitialized() ){
        return;
      }

        $invoice_id = $this->getInvoiceID($payment->ID)
        ?>
        <tr>
            <td><strong><?php _e( 'Faktura', $this->context ); ?>:</strong></td>
            <td><a class="edd_invoice_link" title="<?php _e( 'Stáhnout fakturu', $this->context ); ?>" href="<?php echo esc_url($this->getInvoiceLink($payment->ID) ); ?>"><?php _e( 'Stáhnout fakturu', $this->context ); ?></a></td>
        </tr>
        <?php
    }

    public function setInvoicePaid($payment_id){
        if (!$this->isInitialized()){
            return;
        }
        $invoice_id = $this->getInvoiceID($payment_id);
        $data = [
            'paid' => true
        ];
        return $this->getFapiClient()->getInvoices()->update($invoice_id,$data);
    }

    } //class

}// class exists