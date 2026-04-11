<?php
class Sys_control extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$allowed = ['login', 'attempt_login'];

        if (!in_array($this->router->fetch_method(), $allowed)) {
            if (!$this->session->userdata('active_user')) {
                redirect('sys_control/login');
                exit;
            }
        }
		$_SERVER['warning_message'] = "<br><h1 align='center' style='color: red;'>System Administrator Data Compromised!<br>Please contact the Developer!</h1>";
	}
	public function load_system_datetime()
	{
		$this->load->model('sys_model');
		if ($this->sys_model->admin_security_check() == TRUE) {
			if ((isset($_SESSION['534X39a']) AND isset($_SESSION['kJaW31i'])) AND (!is_null($_SESSION['534X39a']) AND !is_null($_SESSION['kJaW31i']))) {
				// is logged in
				$this->load->model('sys_model');
				$this->sys_model->load_system_datetime();
			}
			else {
				header('Location: '.base_url().'i.php/sys_control/login');
				die();
			}
		}
		else {
			echo $_SERVER['warning_message'];
			die();
		}
	}
	public function login()
	{
		$this->session->sess_destroy();
		$this->load->view('login');	
	}
	public function attempt_login()
	{
		$this->load->model('sys_model');	
		$this->sys_model->attempt_login();
	}
	public function inventory()
	{
		$this->load->view('inventory');	
	}
	public function sales()
	{
		$this->load->view('sales');	
	}
	public function create_pos_item()
	{
		$this->load->model('sys_model');	
		$this->sys_model->create_pos_item();
	}
	public function update_pos_item()
	{
		$this->load->model('sys_model');	
		$this->sys_model->update_pos_item();
	}
	public function add_new_barcode()
	{
		$this->load->model('sys_model');	
		$this->sys_model->add_new_barcode();
	}
	public function load_barcodes()
	{
	    $pos_item_id = $_POST['pos_item_id'];

	    $this->load->model('sys_model');
	    $barcodes = $this->sys_model->load_barcodes($pos_item_id);
	    header('Content-Type: application/json');
	    echo json_encode([
	        'status' => 'success',
	        'barcodes' => $barcodes
	    ]);
	    exit;
	}
	public function remove_barcode()
	{
	    $this->load->model('sys_model');    
	    $this->sys_model->remove_barcode();
	}
	public function process_restocking()
	{
	    $this->load->model('sys_model');    
	    $this->sys_model->process_restocking();
	}
	public function load_pos_restocking_report()
	{
	    $this->load->model('sys_model');    
	    $this->sys_model->load_pos_restocking_report();
	}
	public function load_pos_logs()
	{
	    $this->load->model('sys_model');
	    $this->sys_model->load_pos_logs();
	}
	public function search_barcode()
	{
	    $this->load->model('sys_model');

	    $barcode = $this->input->post('pos_barcode_value', true);
	    $item_id = $this->sys_model->search_barcode($barcode);

	    header('Content-Type: application/json');
	    if ($item_id) {
	        echo json_encode(['status' => 'success', 'pos_item_id' => $item_id]);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Item not found']);
	    }
	    exit;
	}
	public function process_sales()
	{
	    $this->load->model('sys_model');    
	    $this->sys_model->process_sales();
	}
	public function load_pos_sales_report()
	{
	    $this->load->model('sys_model');
	    $this->sys_model->load_pos_sales_report();
	}
	public function load_pos_checkout_receipt()
	{
		$this->load->model('sys_model');
	    $this->sys_model->load_pos_checkout_receipt();
	}
	public function load_low_stock_items()
	{
		$this->load->model('sys_model');
	    $this->sys_model->load_low_stock_items();
	}
	
	public function void_pos_restocking()
	{
		$this->load->model('sys_model');
	    $this->sys_model->void_pos_restocking();
	}
















	
	public function save_child_profile()
	{
		$this->load->model('sys_model');	
		$this->sys_model->save_child_profile();
	}
	public function update_child_profile()
	{
		$this->load->model('sys_model');	
		$this->sys_model->update_child_profile();
	}
	public function load_inactive_clients()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_inactive_clients();
	}
	public function load_active_clients()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_active_clients();
	}
	public function load_registered_clients()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_registered_clients();
	}
	public function load_archived_clients()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_archived_clients();
	}
	public function load_time_rates()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_time_rates();
	}
	public function new_active_client()
	{
		$this->load->model('sys_model');	
		$this->sys_model->new_active_client();
	}
	public function extend_client_time()
	{
		$this->load->model('sys_model');	
		$this->sys_model->extend_client_time();
	}
	public function end_client_time()
	{
		$this->load->model('sys_model');	
		$this->sys_model->end_client_time();
	}
	public function remove_client_time()
	{
		$this->load->model('sys_model');	
		$this->sys_model->remove_client_time();
	}
	public function archive_client()
	{
		$this->load->model('sys_model');	
		$this->sys_model->archive_client();
	}
	public function unarchive_client()
	{
		$this->load->model('sys_model');	
		$this->sys_model->unarchive_client();
	}
	public function delete_client()
	{
		$this->load->model('sys_model');	
		$this->sys_model->delete_client();
	}
	public function load_tm_reports()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_tm_reports();
	}
	public function load_tm_logs()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_tm_logs();
	}
	public function load_pos_inventory()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_pos_inventory();
	}
	public function pos_checkout()
	{
		$this->load->model('sys_model');	
		$this->sys_model->pos_checkout();
	}
	public function load_pos_checkout_codes()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_pos_checkout_codes();
	}
	public function load_pos_checkout()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_pos_checkout();
	}
	public function void_pos_checkout_item()
	{
		$this->load->model('sys_model');	
		$this->sys_model->void_pos_checkout_item();
	}
	public function void_pos_checkout()
	{
		$this->load->model('sys_model');	
		$this->sys_model->void_pos_checkout();
	}
	public function pos_restock()
	{
		$this->load->model('sys_model');	
		$this->sys_model->pos_restock();
	}
	public function load_pos_reports()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_pos_reports();
	}
	public function load_pos_restocking_codes()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_pos_restocking_codes();
	}
	public function load_pos_restocking()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_pos_restocking();
	}
	public function new_supply_item()
	{
		$this->load->model('sys_model');	
		$this->sys_model->new_supply_item();
	}
	public function update_supply_item()
	{
		$this->load->model('sys_model');	
		$this->sys_model->update_supply_item();
	}
	public function supply_checkout()
	{
		$this->load->model('sys_model');	
		$this->sys_model->supply_checkout();
	}
	public function load_supply_checkout_codes()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_supply_checkout_codes();
	}
	public function load_supply_checkout()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_supply_checkout();
	}
	public function void_supply_checkout_item()
	{
		$this->load->model('sys_model');	
		$this->sys_model->void_supply_checkout_item();
	}
	public function void_supply_checkout()
	{
		$this->load->model('sys_model');	
		$this->sys_model->void_supply_checkout();
	}
	public function supply_restock()
	{
		$this->load->model('sys_model');	
		$this->sys_model->supply_restock();
	}
	public function load_supply_reports()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_supply_reports();
	}
	public function load_supply_logs()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_supply_logs();
	}
	public function load_supply_restocking_codes()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_supply_restocking_codes();
	}
	public function load_supply_restocking()
	{
		$this->load->model('sys_model');	
		$this->sys_model->load_supply_restocking();
	}
	public function void_supply_restocking_item()
	{
		$this->load->model('sys_model');	
		$this->sys_model->void_supply_restocking_item();
	}
	public function void_supply_restocking()
	{
		$this->load->model('sys_model');	
		$this->sys_model->void_supply_restocking();
	}
}
?>