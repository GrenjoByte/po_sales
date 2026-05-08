<?php
class Sys_control extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$allowed = ['login', 'attempt_login', 'system_deactivated'];

        if (!in_array($this->router->fetch_method(), $allowed)) {
            if (!$this->session->userdata('active_user')) {
                redirect('sys_control/login');
                exit;
            }
        }
		$_SERVER['warning_message'] = "<br><h1 align='center' style='color: red;'>System Administrator Data Compromised!<br>Please contact the Developer!</h1>";
	}
	private function check_session($allowed_types = [])
	{
	    if (empty($_SESSION['active_user'])) {
	        header('Location: ' . base_url('login'));
	        exit;
	    }
	    if (
	        $_SESSION['session_ip'] !== $_SERVER['REMOTE_ADDR'] ||
	        $_SESSION['session_ua'] !== $_SERVER['HTTP_USER_AGENT']
	    ) {
	        session_destroy();
	        header('Location: ' . base_url('login'));
	        exit;
	    }
	    $user_type = (int) $_SESSION['active_user_type'];
	    // Superadmin (8) bypasses all type restrictions
	    if ($user_type === 8) return;
	    if (!empty($allowed_types) && !in_array($user_type, $allowed_types)) {
			header('Location: '.base_url().'i.php/sys_control/unauthorized');
	        exit;
	    }
	}
	public function load_system_datetime()
	{
		$this->check_session();

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
	    $today = new DateTime('today');
	    $start = new DateTime('2026-05-07');
	    $end   = new DateTime('2026-05-11');

	    if ($today < $start || $today > $end) {
	        $this->session->sess_destroy();
			header('Location: '.base_url().'i.php/sys_control/system_deactivated');
	        exit;
	    }

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
		$this->check_session([1]);
		$this->load->view('inventory');	
	}
	public function sales()
	{
		$this->check_session([2]);
		$this->load->view('sales');	
	}
	public function load_pos_inventory()
	{
		$this->check_session();
		$this->load->model('sys_model');	
		$this->sys_model->load_pos_inventory();
	}
	public function create_pos_item()
	{
		$this->check_session([1]);
		$this->load->model('sys_model');	
		$this->sys_model->create_pos_item();
	}
	public function update_pos_item()
	{
		$this->check_session([1]);		
		$this->load->model('sys_model');	
		$this->sys_model->update_pos_item();
	}
	public function add_new_barcode()
	{
		$this->check_session([1]);		
		$this->load->model('sys_model');	
		$this->sys_model->add_new_barcode();
	}
	public function load_barcodes()
	{
	    $pos_item_id = $_POST['pos_item_id'];

		$this->check_session();	
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
		$this->check_session([1]);		
	    $this->load->model('sys_model');    
	    $this->sys_model->remove_barcode();
	}
	public function process_restocking()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');    
	    $this->sys_model->process_restocking();
	}
	public function load_pos_restocking_report()
	{
		$this->check_session();		
	    $this->load->model('sys_model');    
	    $this->sys_model->load_pos_restocking_report();
	}
	public function load_pos_logs()
	{
		$this->check_session();	
	    $this->load->model('sys_model');
	    $this->sys_model->load_pos_logs();
	}
	public function search_barcode()
	{
		$this->check_session();	
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
		$this->check_session([2]);
	    $this->load->model('sys_model');    
	    $this->sys_model->process_sales();
	}
	public function load_pos_sales_report()
	{
		$this->check_session();		
	    $this->load->model('sys_model');
	    $this->sys_model->load_pos_sales_report();
	}
	public function load_pos_checkout_receipt()
	{
		$this->check_session();		
		$this->load->model('sys_model');
	    $this->sys_model->load_pos_checkout_receipt();
	}
	public function load_low_stock_items()
	{
		$this->check_session();	
		$this->load->model('sys_model');
	    $this->sys_model->load_low_stock_items();
	}
	public function void_pos_restocking()
	{
		$this->check_session([1]);		
		$this->load->model('sys_model');
	    $this->sys_model->void_pos_restocking();
	}
	public function load_accounts()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');
	    $this->sys_model->load_accounts();
	}

	public function get_account()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');
	    $this->sys_model->get_account();
	}

	public function create_account()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');
	    $this->sys_model->create_account();
	}

	public function update_account()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');
	    $this->sys_model->update_account();
	}
	public function void_pos_sale()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');
	    $this->sys_model->void_pos_sale();
	}
	public function void_pos_checkout_item()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');
	    $this->sys_model->void_pos_checkout_item();
	}
	public function restore_pos_checkout_item()
	{
		$this->check_session();		
	    $this->load->model('sys_model');
	    $this->sys_model->restore_pos_checkout_item();
	}
	public function restore_pos_sale()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');
	    $this->sys_model->restore_pos_sale();
	}
	public function request_void_pos_checkout_item()
	{
		$this->check_session([2]);		
	    $this->load->model('sys_model');
	    $this->sys_model->request_void_pos_checkout_item();
	}
	public function cancel_void_request_pos_checkout_item()
	{
		$this->check_session([2]);		
	    $this->load->model('sys_model');
	    $this->sys_model->cancel_void_request_pos_checkout_item();
	}
	public function load_pos_voiding_requests()
	{
		$this->check_session([1]);		
	    $this->load->model('sys_model');
	    $this->sys_model->load_pos_voiding_requests();
	}
	public function unauthorized()
	{
		$this->load->view('unauthorized.html');
	}
	public function system_deactivated()
	{
	    $this->session->sess_destroy();
	    $this->load->view('system_deactivated.html');	
	}
	public function stream_db_changes()
	{
	    $this->load->model('sys_model');
	    $this->sys_model->stream_db_changes();
	}
}
?>