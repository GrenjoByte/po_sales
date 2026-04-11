<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Sys_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$_SESSION['ghi8Asd8'] = 'grenjo8';
		$_SESSION['1jhA3xBg'] = 'Renzo';
		$_SESSION['87gBAi89'] = 'Ferreras';
		$_SESSION['HyA23jas'] = 'Advincula';
		$_SESSION['oljnAS78'] = '1998-03-21';
		date_default_timezone_set('Asia/Manila');
	}
	public function load_system_datetime()
	{
		date_default_timezone_set('Asia/Manila');
		$current_time = date("h:i A");
		$current_date = new DateTime(date('Y-m-d'));		
		$previous_month = clone $current_date;
		$previous_month->modify('-1 month');
		
		$current_date = $current_date->format('Y-m-d');
		$previous_month = $previous_month->format('Y-m-d');

		$datetime_data = array(
			'current_time' => $current_time,
			'current_date' => $current_date,
			'previous_month' => $previous_month
		);
		echo json_encode([$datetime_data]);
	}
	public function attempt_login()
	{
	    $username = $this->input->post('username', TRUE);
	    $password = $this->input->post('password', TRUE);

	    $sql = "SELECT user_id, username, password FROM user_accounts WHERE username = ?";
	    $query = $this->db->query($sql, [$username]);
	    $row = $query->row();

	    if ($row && $password === $row->password) {
	        $user_id = $row->user_id;

	        $sql = "SELECT user_type ,last_name, gender FROM user_info WHERE user_id = ?";
	        $query = $this->db->query($sql, [$user_id]);
	        $row = $query->row();

	        if ($row) {
	        	$_SESSION['active_user'] = $user_id;
	            $attempt_response = array(
	                'status' => 'success',
	                'user_type' => $row->user_type,
	                'last_name' => $row->last_name,
	                'gender' => $row->gender
	            );
	        } else {
	            $attempt_response = array(
	                'status' => 'error',
	                'user_type' => '',
	                'last_name' => '',
	                'gender' => 'failed'
	            );
	        }
	    } else {
	        $attempt_response = array(
	            'status' => 'error',
                'user_type' => '',
                'last_name' => '',
	            'gender' => 'Invalid username or password'
	        );
	    }

	    header('Content-Type: application/json');
	    echo json_encode($attempt_response);
	    exit;
	}
	public function load_pos_inventory()
	{
	    $page  = isset($_POST['page']) ? (int)$_POST['page'] : 1;
	    $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 15;
	    $search = isset($_POST['search']) ? trim($_POST['search']) : '';

	    $offset = ($page - 1) * $limit;

	    // base condition
	    $where = "WHERE pos_item_status = 1";
	    $params = [];

	    if (!empty($search)) {
	        $where .= " AND (pos_item_name LIKE ? OR pos_item_code LIKE ?)";
	        $params[] = "%$search%";
	        $params[] = "%$search%";
	    }

	    // total
	    $total_sql = "SELECT COUNT(*) AS total FROM pos_inventory $where";
	    $total_query = $this->db->query($total_sql, $params);
	    $total = $total_query->row()->total;

	    // data
	    $sql = "SELECT pos_item_id, pos_item_name, pos_item_code, pos_item_price, pos_item_stock, pos_item_unit, pos_item_low
	            FROM pos_inventory
	            $where
	            ORDER BY pos_item_name ASC
	            LIMIT ?, ?";

	    $params[] = $offset;
	    $params[] = $limit;

	    $query = $this->db->query($sql, $params);

	    $items = [];
	    foreach ($query->result() as $row) {
	        $items[] = [
	            'pos_item_id'    => $row->pos_item_id,
	            'pos_item_name'  => $row->pos_item_name,
	            'pos_item_code'  => $row->pos_item_code,
	            'pos_item_price' => $row->pos_item_price,
	            'pos_item_stock' => $row->pos_item_stock,
	            'pos_item_unit'  => $row->pos_item_unit,
	            'pos_item_low'   => $row->pos_item_low
	        ];
	    }

	    echo json_encode([
	        'items' => $items,
	        'total' => $total
	    ]);
	}
	public function create_pos_item()
	{
	    $pos_item_name  = $_POST['new_pos_item_name'];
	    $pos_item_code  = $_POST['new_pos_item_code'];
	    $pos_item_price = $_POST['new_pos_item_price'];
	    $pos_item_unit  = $_POST['new_pos_item_unit'];
	    $pos_item_stock = $_POST['new_pos_item_stock'];
	    $pos_item_low   = $_POST['new_pos_item_low'];

	    $sql = "INSERT INTO pos_inventory 
	            (pos_item_name, pos_item_code, pos_item_price, pos_item_unit, pos_item_stock, pos_item_low) 
	            VALUES (?, ?, ?, ?, ?, ?)";
	    $insert_query = $this->db->query($sql, array(
	        $pos_item_name,
	        $pos_item_code,
	        $pos_item_price,
	        $pos_item_unit,
	        $pos_item_stock,
	        $pos_item_low
	    ));

	    $pos_item_id = $this->db->insert_id();

	    header('Content-Type: application/json');
	    if ($insert_query) {

	        $activity_type = "Item Creation";
	        $pos_code = "Item ID: " . $pos_item_id;

	        $activity = "<strong>Created:</strong><br>"
                  . "Item Name: {$pos_item_name}<br>"
                  . "Item Code: {$pos_item_code}<br>"
                  . "Item Price: ₱" . number_format($pos_item_price, 2) . "<br>"
                  . "Item Unit: {$pos_item_unit}<br>"
                  . "Current Stock: {$pos_item_stock}<br>"
                  . "Low Stock Level: {$pos_item_low}";

	        $sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $pos_code, $activity]);

	        echo json_encode([
	            'status' => 'success',
	            'message' => 'Item created successfully'
	        ]);
	    } 
	    else {
	        echo json_encode([
	            'status' => 'error',
	            'message' => 'Failed to create item'
	        ]);
	    }
	    exit;
	}
	public function update_pos_item()
	{
	    $pos_item_id        = $_POST['update_pos_item_id'];
	    $pos_item_name      = $_POST['update_pos_item_name'];
	    $pos_item_price     = $_POST['update_pos_item_price'];
	    $pos_item_unit      = $_POST['update_pos_item_unit'];
	    $pos_item_stock     = $_POST['update_pos_item_stock'];
	    $pos_item_low       = $_POST['update_pos_item_low'];

	    $sql = "SELECT * FROM pos_inventory WHERE pos_item_id = ?";
	    $query = $this->db->query($sql, array($pos_item_id));
	    $current = $query->row_array();

	    $sql = "UPDATE pos_inventory 
	    SET pos_item_name=?, pos_item_price=?, pos_item_unit=?, pos_item_stock=?, pos_item_low=? 
	    WHERE pos_item_id=?";
	    $update_query = $this->db->query($sql, array($pos_item_name, $pos_item_price, $pos_item_unit, $pos_item_stock, $pos_item_low, $pos_item_id));

	    $changed = array();
	    if ($current['pos_item_name'] != $pos_item_name) $changed[] = 'Item Name';
	    if ($current['pos_item_price'] != $pos_item_price) $changed[] = 'Item Price';
	    if ($current['pos_item_unit'] != $pos_item_unit) $changed[] = 'Item Unit';
	    if ($current['pos_item_stock'] != $pos_item_stock) $changed[] = 'Current Stock';
	    if ($current['pos_item_low'] != $pos_item_low) $changed[] = 'Low Stock Level';

	    header('Content-Type: application/json');
	    if ($update_query) {
	    	if (!empty($changed)) {
	    		$activity_type = "Item Updating";
	    		$pos_code = "Item ID: " . $pos_item_id;
	    		$activity = "<strong>Updated:</strong><br>" . implode(', ', $changed);

	    		$sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)";
	    		$this->db->query($sql, [$activity_type, $pos_code, $activity]);
	    	}

	    	echo json_encode([
	    		'status' => 'success',
	    		'message' => 'Item updated successfully'
	    	]);
	    } 
	    else {
	    	echo json_encode([
	    		'status' => 'error',
	    		'message' => 'Failed to update item'
	    	]);
	    }
	    exit;
	}
	public function add_new_barcode()
	{
	    $pos_item_id        = $_POST['pos_item_id'];
	    $pos_barcode_value  = $_POST['pos_barcode_value'];

	    header('Content-Type: application/json');

	    if (empty($pos_item_id) || empty($pos_barcode_value)) {
	        echo json_encode([
	            'status' => 'error',
	            'message' => 'Missing required fields'
	        ]);
	        exit;
	    }

	    $check = $this->db->query(
	        "SELECT pos_item_id 
	         FROM pos_item_codes 
	         WHERE pos_barcode_value = ? 
	         LIMIT 1",
	        [$pos_barcode_value]
	    );

	    if ($check && $check->num_rows() > 0) {

	        $existing = $check->row();

	        if ($existing->pos_item_id == $pos_item_id) {
	            echo json_encode([
	                'status' => 'error',
	                'message' => 'Barcode already exists for this item'
	            ]);
	        } 
	        else {
	            echo json_encode([
	                'status' => 'error',
	                'message' => 'Barcode already assigned to another item'
	            ]);
	        }

	        exit;
	    }

	    $sql = "INSERT INTO pos_item_codes 
	            (pos_item_id, pos_barcode_value) 
	            VALUES (?, ?)";

	    $insert_query = $this->db->query($sql, [
	        $pos_item_id,
	        $pos_barcode_value
	    ]);

	    if ($insert_query) {

	        $activity_type = "Barcode Creation";
	        $pos_code = "Item ID: " . $pos_item_id;

	        $activity = "<strong>Added Barcode:</strong><br>"
	                  . $pos_barcode_value;

	        $sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) 
	                VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $pos_code, $activity]);

	        echo json_encode([
	            'status' => 'success',
	            'message' => 'Barcode added successfully'
	        ]);
	    } 
	    else {
	        echo json_encode([
	            'status' => 'error',
	            'message' => 'Failed to add barcode'
	        ]);
	    }

	    exit;
	}
	public function load_barcodes($pos_item_id)
	{
	    $sql = "SELECT pos_barcode_value 
	            FROM pos_item_codes 
	            WHERE pos_item_id = ?";

	    $query = $this->db->query($sql, [$pos_item_id]);

	    $barcodes = [];

	    if ($query && $query->num_rows() > 0) {
	        foreach ($query->result() as $row) {
	            $barcodes[] = $row->pos_barcode_value;
	        }
	    }

	    return $barcodes;
	}
	public function remove_barcode()
	{
	    $pos_item_id       = $_POST['pos_item_id'];
	    $pos_barcode_value = $_POST['pos_barcode_value'];

	    header('Content-Type: application/json');

	    if (empty($pos_item_id) || empty($pos_barcode_value)) {
	        echo json_encode([
	            'status' => 'error',
	            'message' => 'Invalid data'
	        ]);
	        exit;
	    }

	    $sql = "DELETE FROM pos_item_codes 
	            WHERE pos_item_id = ? 
	            AND pos_barcode_value = ?";

	    $delete_query = $this->db->query($sql, [
	        $pos_item_id,
	        $pos_barcode_value
	    ]);

	    if ($delete_query) {

	        $activity_type = "Barcode Deletion";
	        $pos_code = "Item ID: " . $pos_item_id;

	        $activity = "<strong>Removed Barcode:</strong><br>"
	                  . $pos_barcode_value;

	        $sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) 
	                VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $pos_code, $activity]);

	        echo json_encode([
	            'status' => 'success',
	            'message' => 'Barcode removed successfully'
	        ]);
	    } 
	    else {
	        echo json_encode([
	            'status' => 'error',
	            'message' => 'Failed to remove barcode'
	        ]);
	    }

	    exit;
	}
	public function process_restocking()
	{
	    $pos_restocking_code = $_POST['pos_restocking_code'];
	    $pos_restocking_date = $_POST['pos_restocking_date'];
	    $items = json_decode($_POST['items'], true);

	    header('Content-Type: application/json');

	    if (empty($items)) {
	        echo json_encode([
	            'status' => 'error',
	            'message' => 'No items to restock'
	        ]);
	        exit;
	    }

	    $this->db->trans_start();

	    foreach ($items as $item) {

	        $total = $item['pos_item_price'] * $item['pos_item_quantity'];

	        $sql = "INSERT INTO pos_restocking 
	                (pos_restocking_code, pos_item_id, pos_item_code, pos_item_name, 
	                 pos_item_price, pos_item_quantity, pos_item_unit, pos_restocking_total, pos_restocking_date)
	                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

	        $this->db->query($sql, [
	            $pos_restocking_code,
	            $item['pos_item_id'],
	            $item['pos_item_code'],
	            $item['pos_item_name'],
	            $item['pos_item_price'],
	            $item['pos_item_quantity'],
	            $item['pos_item_unit'],
	            $total,
	            $pos_restocking_date
	        ]);

	        $sql = "UPDATE pos_inventory 
	                SET pos_item_stock = pos_item_stock + ?
	                WHERE pos_item_id = ?";

	        $this->db->query($sql, [
	            $item['pos_item_quantity'],
	            $item['pos_item_id']
	        ]);

	        $activity_type = "Restocking";
	        $pos_code = "Item ID: " . $item['pos_item_id'];

	        $activity = "<strong>Restocked:</strong><br>"
	                  . $item['pos_item_name']
	                  . " (+" . $item['pos_item_quantity'] . " " . $item['pos_item_unit'] . ")";

	        $this->db->query(
	            "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) 
	             VALUES (?, ?, ?)",
	            [$activity_type, $pos_code, $activity]
	        );
	    }

	    $this->db->trans_complete();

	    if ($this->db->trans_status() === FALSE) {

	        echo json_encode([
	            'status' => 'error',
	            'message' => 'Restocking failed (rolled back)'
	        ]);

	    } else {

	        echo json_encode([
	            'status' => 'success',
	            'message' => 'Restocking completed successfully'
	        ]);
	    }

	    exit;
	}
	public function load_pos_restocking_report()
	{
	    header('Content-Type: application/json');

	    $report_date = $_POST['report_date'];
	    $params = [];

	    $sql = "SELECT 
	                pos_item_id,
	                pos_restocking_code,
	                pos_item_code,
	                pos_item_name,
	                pos_item_price,
	                pos_item_quantity,
	                pos_item_unit,
	                pos_restocking_total,
	                pos_restocking_date
	            FROM pos_restocking
	            WHERE pos_restocking_status = 1
	    ";

	    if (!empty($report_date)) {
	        $sql .= " WHERE DATE(pos_restocking_date) = ? ";
	        $params[] = $report_date;
	    }

	    $sql .= " ORDER BY pos_restocking_date DESC";

	    $query = $this->db->query($sql, $params);

	    $data = [];
	    $grand_total = 0;

	    foreach ($query->result() as $row) {

	        $grand_total += $row->pos_restocking_total;

	        $data[] = [
	            'pos_item_id' => $row->pos_item_id,
	            'pos_restocking_code' => $row->pos_restocking_code,
	            'pos_item_code'       => $row->pos_item_code,
	            'pos_item_name'       => $row->pos_item_name,
	            'pos_item_price'      => $row->pos_item_price,
	            'pos_item_quantity'   => $row->pos_item_quantity,
	            'pos_item_unit'       => $row->pos_item_unit,
	            'pos_restocking_total'=> $row->pos_restocking_total,
	            'pos_restocking_date' => $row->pos_restocking_date
	        ];
	    }

	    echo json_encode([
	        'status' => 'success',
	        'data' => $data,
	        'grand_total' => $grand_total
	    ]);

	    exit;
	}
	public function load_pos_logs() {
	    $sql = "SELECT pos_log_id, pos_activity_type, pos_code, pos_activity, timestamp
	            FROM pos_logs
	            ORDER BY timestamp DESC
	            LIMIT 100"; // adjust as needed

	    $query = $this->db->query($sql);
	    $data = [];

	    foreach ($query->result() as $row) {
	        $data[] = [
	            'pos_log_id' => $row->pos_log_id,
	            'pos_activity_type' => $row->pos_activity_type,
	            'pos_code' => $row->pos_code,
	            'pos_activity' => $row->pos_activity,
	            'timestamp' => $row->timestamp
	        ];
	    }

	    echo json_encode(['data' => $data]);
	}
	public function search_barcode($barcode)
	{
	    $sql = "
	        SELECT i.pos_item_id, i.pos_item_stock
	        FROM pos_item_codes c
	        INNER JOIN pos_inventory i ON i.pos_item_id = c.pos_item_id
	        WHERE c.pos_barcode_value = ?
	        LIMIT 1
	    ";

	    $query = $this->db->query($sql, array($barcode));

	    if ($query->num_rows() > 0) {
	        $row = $query->row();

	        if ((float)$row->pos_item_stock <= 0) {
	            echo json_encode([
	                'status' => 'empty',
	                'pos_item_id' => $row->pos_item_id
	            ]);
	            exit;
	        }

	        echo json_encode([
	            'status' => 'success',
	            'pos_item_id' => $row->pos_item_id
	        ]);
	        exit;
	    }

	    echo json_encode([
	        'status' => 'not_found'
	    ]);
	    exit;
	}
	public function process_sales() {
	    $items = json_decode($_POST['items'], true);
	    $discount_type = $_POST['discount_type'] ?? 'none';
	    $other_discount = $_POST['other_discount'] ?? 0;
	    $user_id = $_SESSION['active_user'] ?? 0;

	    header('Content-Type: application/json');

	    if (empty($items)) {
	        echo json_encode(['status'=>'error','message'=>'No items to sell']);
	        exit;
	    }

	    $this->db->trans_start();

	    // generate sale code
	    $sql = "SELECT CONCAT('CO-', LPAD(IFNULL(MAX(CAST(SUBSTRING(pos_checkout_code,4) AS UNSIGNED)),0)+1,4,'0')) AS new_code
	            FROM pos_checkouts";
	    $sale_code = $this->db->query($sql)->row()->new_code;

	    // discount setup
	    $discount_rate = 0;

	    switch ($discount_type) {
	        case 'senior':
	        case 'pwd':
	            $discount_rate = 0.20;
	            break;
	        case 'promo':
	            $discount_rate = 0.10;
	            break;
	        case 'other':
	            $discount_rate = floatval($other_discount) / 100;
	            break;
	        default:
	            $discount_rate = 0;
	    }

	    $vat_rate = 0.12;

	    foreach ($items as $item) {

	        $gross_price = $item['pos_item_price'];
			$qty = $item['pos_item_quantity'];

			$gross_total = $gross_price * $qty;

			// 1. Apply discount first
			$discount_amount = $gross_total * $discount_rate;
			$discounted_total = $gross_total - $discount_amount;

			// 2. Compute VAT from discounted amount
			$vat_amount = $discounted_total * $vat_rate / (1 + $vat_rate);

			// 3. Net of VAT (VAT-exclusive base)
			$pos_checkout_subtotal = $discounted_total - $vat_amount;

			// 4. Final total (what customer pays)
			$final_total = $discounted_total;

	        // insert checkout row
	        $this->db->query(
	            "INSERT INTO pos_checkouts 
	            (user_id, pos_checkout_code, pos_item_id, pos_item_code, pos_item_name,
	             pos_item_price, pos_item_quantity, pos_item_unit,
	             pos_discount_type, pos_discount_value,
	             pos_checkout_vat, pos_checkout_subtotal, pos_checkout_total,
	             pos_checkout_date, pos_checkout_status)
	            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)",
	            [
	                $user_id,
	                $sale_code,
	                $item['pos_item_id'],
	                $item['pos_item_code'],
	                $item['pos_item_name'],
	                $gross_price,
	                $qty,
	                $item['pos_item_unit'],
	                $discount_type,
	                $discount_rate,
	                $vat_amount,
	                $pos_checkout_subtotal,
	                $final_total
	            ]
	        );

	        // stock update
	        $this->db->query(
	            "UPDATE pos_inventory 
	             SET pos_item_stock = pos_item_stock - ? 
	             WHERE pos_item_id = ?",
	            [$qty, $item['pos_item_id']]
	        );
	    }

	    $this->db->trans_complete();

	    if ($this->db->trans_status() === FALSE) {
	        echo json_encode(['status'=>'error','message'=>'Sale failed (rolled back)']);
	    } else {
	        echo json_encode([
	            'status' => 'success',
	            'sale_code' => $sale_code
	        ]);
	    }

	    exit;
	}
	public function load_pos_sales_report()
	{
	    $report_date = $_POST['report_date'];

	    header('Content-Type: application/json');

	    $params = [];

	    $sql = "
	        SELECT 
	            pc.pos_checkout_code,

	            COUNT(DISTINCT pc.pos_item_id) AS total_items,
	            SUM(pc.pos_item_quantity) AS total_quantity,

	            IFNULL(MAX(pc.pos_discount_value), 0) AS pos_discount_value,

	            SUM(pc.pos_item_price * pc.pos_item_quantity) AS pos_checkout_total,

	            MAX(pc.pos_checkout_status) AS pos_checkout_status,
	            MAX(pc.pos_checkout_date) AS pos_checkout_date,

	            -- Proper name formatting
	            CONCAT(
	                ui.first_name, ' ',
	                IFNULL(CONCAT(LEFT(ui.middle_name, 1), '. '), ''),
	                ui.last_name
	            ) AS cashier_name

	        FROM pos_checkouts pc
	        LEFT JOIN user_info ui ON ui.user_id = pc.user_id
	    ";

	    if (!empty($report_date)) {
	        $sql .= " WHERE DATE(pc.pos_checkout_date) = ? ";
	        $params[] = $report_date;
	    }

	    $sql .= "
	        GROUP BY pc.pos_checkout_code
	        ORDER BY pos_checkout_date DESC
	    ";

	    $query = $this->db->query($sql, $params);

	    echo json_encode([
	        'status' => 'success',
	        'data' => $query->result_array()
	    ]);

	    exit;
	}
	public function load_pos_checkout_receipt()
	{
		$sale_code = $_POST['sale_code'];

		header('Content-Type: application/json');

		$sql = "
		SELECT 
		pc.*,

		CONCAT(
			ui.first_name, ' ',
			IFNULL(CONCAT(LEFT(ui.middle_name, 1), '. '), ''),
			ui.last_name
			) AS cashier_name

		FROM pos_checkouts pc
		LEFT JOIN user_info ui ON ui.user_id = pc.user_id
		WHERE pc.pos_checkout_code = ?
		";

		$query = $this->db->query($sql, [$sale_code]);

		echo json_encode([
			'status' => 'success',
			'data' => $query->result_array()
		]);

		exit;
	}
	public function load_low_stock_items() {
	    $sql = "SELECT pos_item_name, pos_item_code, pos_item_stock, pos_item_low
	            FROM pos_inventory
	            WHERE pos_item_stock <= pos_item_low
	              AND pos_item_status = 1
	            ORDER BY pos_item_stock ASC
	            LIMIT 100";

	    $query = $this->db->query($sql);
	    $data = [];

	    foreach ($query->result() as $row) {
	        $data[] = [
	            'pos_item_name' => $row->pos_item_name,
	            'pos_item_code' => $row->pos_item_code,
	            'pos_item_stock' => $row->pos_item_stock,
	            'pos_item_low' => $row->pos_item_low
	        ];
	    }

	    echo json_encode(['data' => $data]);
	}
	public function void_pos_restocking()
	{
		header('Content-Type: application/json');

		$pos_item_id = $this->input->post('pos_item_id', true);
		$pos_restocking_code = $this->input->post('pos_restocking_code', true);

		if (empty($pos_item_id)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid restocking code'
			]);
			return;
		}

		$sql = "SELECT pos_restocking_status 
		FROM pos_restocking 
		WHERE pos_item_id = ? AND pos_restocking_code = ?";
		$query = $this->db->query($sql, [$pos_item_id, $pos_restocking_code]);

		if ($query->num_rows() == 0) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Record not found'
			]);
			return;
		}

		$row = $query->row();

		if ($row->pos_restocking_status == 2) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Already voided'
			]);
			return;
		}

		$sql = "SELECT pos_item_id, pos_item_quantity 
	        	FROM pos_restocking 
				WHERE pos_item_id = ? AND pos_restocking_code = ?";
		$query_item = $this->db->query($sql, [$pos_item_id, $pos_restocking_code]);

		if ($query_item->num_rows() == 0) {
		    echo json_encode([
		        'status' => 'error',
		        'message' => 'Restocking item not found'
		    ]);
		    return;
		}

		$item = $query_item->row();

		$sql = "UPDATE pos_inventory 
		        SET pos_item_stock = pos_item_stock - ? 
		        WHERE pos_item_id = ?";
		$this->db->query($sql, [
		    $item->pos_item_quantity,
		    $item->pos_item_id
		]);

		$sql = "UPDATE pos_restocking 
		SET pos_restocking_status = 2 
		WHERE pos_item_id = ? AND pos_restocking_code = ?";
		$this->db->query($sql, [$pos_item_id, $pos_restocking_code]);

		if ($this->db->affected_rows() > 0) {
			echo json_encode([
				'status' => 'success',
				'message' => 'Restocking voided'
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'No changes made'
			]);
		}
	}




























	public function save_child_profile()
	{
	    $guardian_name      = $_POST['guardian_name'];
	    $guardian_contact   = $_POST['guardian_contact'];
	    $full_name          = $_POST['full_name'];
	    $gender             = $_POST['gender'];
	    $birthdate          = $_POST['birthdate'];
	    $profile_image_name = $_POST['profile_image_name'];

	    $profile_image = $_POST['profile_image'] ?? null;

	    // Check if profile already exists
	    $sql = "SELECT client_id FROM client_profiles WHERE full_name = ? AND birthdate = ?";
	    $query = $this->db->query($sql, [$full_name, $birthdate]);

	    if ($query->num_rows() > 0) {
	        echo "duplicate";
	        return;
	    }

	    if (empty($profile_image)) {
	    	$profile_image_name = 'avatar.jpg';
	    }
	    elseif (!empty($profile_image)) {

	        if (strpos($profile_image, 'base64,') !== false) {

	            list($meta, $content) = explode('base64,', $profile_image);

	            $image_binary = base64_decode($content);

	            $upload_path = FCPATH . 'photos/profile_pictures/';

	            if (!is_dir($upload_path)) {
	                mkdir($upload_path, 0755, true);
	            }

	            file_put_contents($upload_path . $profile_image_name, $image_binary);
	        }
	    }
	    $sql = "INSERT INTO client_profiles 
	            (guardian_name, guardian_contact, full_name, gender, birthdate, profile_image)
	            VALUES (?, ?, ?, ?, ?, ?)";

	    $this->db->query($sql, [
	        $guardian_name,
	        $guardian_contact,
	        $full_name,
	        $gender,
	        $birthdate,
	        $profile_image_name
	    ]);

	    if ($this->db->affected_rows() > 0) {

	        echo "success";

	        $client_id = $this->db->insert_id();

	        $activity = "<strong>Account Created</strong>";
	        $sql = "INSERT INTO time_logs (client_id, activity) VALUES (?, ?)";
	        $this->db->query($sql, [$client_id, $activity]);

	    } else {

	        echo "error";
	    }
	}

	public function update_child_profile()
	{
	    $client_id = $_POST['update_client_id'];
	    $guardian_name = $_POST['update_guardian_name'];
	    $guardian_contact = $_POST['update_guardian_contact'];
	    $full_name = $_POST['update_full_name'];
	    $gender = $_POST['update_gender'];
	    $birthdate = $_POST['update_birthdate'];
	    $profile_image_b64 = $_POST['update_profile_image'];
	    $profile_image_name = $_POST['update_profile_image_name'];

	    $sql = "SELECT * FROM client_profiles WHERE client_id=?";
	    $query = $this->db->query($sql, array($client_id));
	    $current = $query->row_array();

	    $file_path = null;
	    if (!empty($profile_image_b64)) {
	        $image_parts = explode(";base64,", $profile_image_b64);
	        if (count($image_parts) == 2) {
	            $image_base64 = base64_decode($image_parts[1]);
	            $file_name = 'profile_' . time() . '.png';
	            $upload_path = FCPATH . 'photos/profile_pictures/';
	            if (!is_dir($upload_path)) {
	                mkdir($upload_path, 0755, true);
	            }
	            file_put_contents($upload_path . $file_name, $image_base64);
	            $profile_image_name = $file_name;
	            $file_path = 'photos/profile_pictures/' . $file_name;
	        }
	    }

	    if ($file_path) {
	        $sql = "UPDATE client_profiles 
	                   SET guardian_name=?, guardian_contact=?, full_name=?, gender=?, birthdate=?, profile_image=? 
	                 WHERE client_id=?";
	        $update_query = $this->db->query($sql, array($guardian_name,$guardian_contact,$full_name,$gender,$birthdate,$profile_image_name,$client_id));
	    } else {
	        $sql = "UPDATE client_profiles 
	                   SET guardian_name=?, guardian_contact=?, full_name=?, gender=?, birthdate=? 
	                 WHERE client_id=?";
	        $update_query = $this->db->query($sql, array($guardian_name,$guardian_contact,$full_name,$gender,$birthdate,$client_id));
	    }

	    $changed = array();
	    if ($current['guardian_name'] != $guardian_name) $changed[] = 'Guardian Name';
	    if ($current['guardian_contact'] != $guardian_contact) $changed[] = 'Guardian Contact';
	    if ($current['full_name'] != $full_name) $changed[] = 'Full Name';
	    if ($current['gender'] != $gender) $changed[] = 'Gender';
	    if ($current['birthdate'] != $birthdate) $changed[] = 'Birthdate';
	    if ($file_path && $current['profile_image'] != $profile_image_name) $changed[] = 'Profile Image';

	    if ($update_query) {
	        echo "success";
	        if (!empty($changed)) {
	            $activity = "<strong>Updated:</strong><br>" . implode(', ', $changed);
	            $sql = "INSERT INTO time_logs (client_id, activity) VALUES (?, ?)";
	            $this->db->query($sql, array($client_id, $activity));
	        }
	    } else {
	        echo "error";
	    }
	}
	public function load_inactive_clients()
	{
		$sql = "SELECT * FROM client_profiles WHERE client_id NOT IN(SELECT client_id FROM time_manager) AND client_status = 1";
		// $sql = "SELECT * FROM client_profiles LEFT JOIN time_manager ON client_profiles.client_id = time_manager.client_id";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function load_active1_clients()
	{
		date_default_timezone_set('Asia/Manila');
		$current_date = date('Y-m-d');

		$sql = "
			WITH RECURSIVE split_rates AS (
			    SELECT 
			        tm.client_id,
			        tm.time_date,
			        tm.start_time,
			        tm.rate_id AS tm_id,
			        TRIM(SUBSTRING_INDEX(tm.rate_id, ',', 1)) AS single_rate,
			        CASE 
			            WHEN INSTR(tm.rate_id, ',') > 0 THEN TRIM(SUBSTR(tm.rate_id, INSTR(tm.rate_id, ',') + 1))
			            ELSE '' 
			        END AS rest
			    FROM time_manager tm

			    UNION ALL

			    SELECT 
			        client_id,
			        time_date,
			        start_time,
			        tm_id,
			        TRIM(SUBSTRING_INDEX(rest, ',', 1)),
			        CASE 
			            WHEN INSTR(rest, ',') > 0 THEN TRIM(SUBSTR(rest, INSTR(rest, ',') + 1))
			            ELSE '' 
			        END
			    FROM split_rates
			    WHERE rest <> ''
			)

			SELECT 
			    cp.client_id,
			    FLOOR(SUM(tr.hour * 60 + tr.minute) / 60) AS total_hours,
			    MOD(SUM(tr.hour * 60 + tr.minute), 60) AS total_minutes,
			    SUM(tr.price) AS total_price
			FROM client_profiles cp
			JOIN time_manager tm 
			    ON cp.client_id = tm.client_id
			JOIN split_rates sr 
			    ON sr.client_id = tm.client_id 
			    AND sr.time_date = tm.time_date 
			    AND sr.start_time = tm.start_time
			JOIN time_rates tr 
			    ON tr.rate_id = CAST(sr.single_rate AS UNSIGNED)
			WHERE sr.time_date != ?
			GROUP BY cp.client_id;
		";
		$query = $this->db->query($sql, $current_date);
		foreach ($query->result() as $row) {
 			$res_client_id = $row->client_id;
 			$total_hours = $row->total_hours;
 			$total_minutes = $row->total_minutes;
 			$time = $total_hours.':'.$total_minutes;
 			$rate = $row->total_price;
		}
		if (isset($res_client_id)) {
			$sql = "INSERT INTO time_reports (client_id, time, rate)
		            VALUES (?, ?, ?)";
		    $this->db->query($sql, array($res_client_id, $time, $rate));

			$sql = "DELETE FROM time_manager WHERE client_id = ?";
			$this->db->query($sql, [$res_client_id]);	
		}

		$sql = "
			WITH RECURSIVE split_rates AS (
			    SELECT 
			        tm.client_id,
			        tm.start_time,
			        TRIM(SUBSTRING_INDEX(tm.rate_id, ',', 1)) AS single_rate,
			        CASE 
			            WHEN INSTR(tm.rate_id, ',') > 0 
			            THEN TRIM(SUBSTR(tm.rate_id, INSTR(tm.rate_id, ',') + 1))
			            ELSE '' 
			        END AS rest
			    FROM time_manager tm

			    UNION ALL

			    SELECT 
			        client_id,
			        start_time,
			        TRIM(SUBSTRING_INDEX(rest, ',', 1)),
			        CASE 
			            WHEN INSTR(rest, ',') > 0 
			            THEN TRIM(SUBSTR(rest, INSTR(rest, ',') + 1))
			            ELSE '' 
			        END
			    FROM split_rates
			    WHERE rest <> ''
			)

			SELECT 
			    cp.client_id,
			    cp.full_name,
			    cp.gender,
			    cp.birthdate,
			    cp.profile_image,
			    cp.guardian_name,
			    cp.guardian_contact,
			    MIN(sr.start_time) AS start_time,  -- earliest active time session
			    FLOOR(SUM(tr.hour * 60 + tr.minute) / 60) AS total_hours,
			    MOD(SUM(tr.hour * 60 + tr.minute), 60) AS total_minutes,
			    SUM(tr.price) AS total_price
			FROM client_profiles cp
			JOIN split_rates sr ON cp.client_id = sr.client_id
			JOIN time_rates tr ON tr.rate_id = CAST(sr.single_rate AS UNSIGNED)
			WHERE cp.client_status = 1
			GROUP BY cp.client_id;
		";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function load_active_clients()
	{
		date_default_timezone_set('Asia/Manila');
		$current_date = date('Y-m-d');

		$sql = "SELECT client_profiles.client_id, guardian_name, guardian_contact, full_name, gender, birthdate, profile_image, client_status, start_time, rate_id FROM time_manager, client_profiles WHERE client_profiles.client_id = time_manager.client_id AND time_manager.time_date != ?";
		$query = $this->db->query($sql, [$current_date]);

		$output_data = array();

		foreach ($query->result() as $row) {
		    $client_id        = $row->client_id;
		    $guardian_name    = $row->guardian_name;
		    $guardian_contact = $row->guardian_contact;
		    $full_name        = $row->full_name;
		    $gender           = $row->gender;
		    $birthdate        = $row->birthdate;
		    $profile_image    = $row->profile_image;
		    $start_time       = $row->start_time;
		    $client_status    = $row->client_status;

		    $rate_ids = explode(',', $row->rate_id);

		    $total_hour   = 0;
		    $total_minute = 0;
		    $total_price  = 0;

		    foreach ($rate_ids as $rate) {

		        $rate = trim($rate);

		        $sql = "SELECT hour, minute, price FROM time_rates WHERE rate_id = ?";
		        $query2 = $this->db->query($sql, array($rate));

		        foreach ($query2->result() as $row2) {
		            $total_hour   += $row2->hour;
		            $total_minute += $row2->minute;
		            $total_price  += $row2->price;
		        }
		    }

		    // Normalize minutes
		    if ($total_minute >= 60) {
		        $extra_hours  = floor($total_minute / 60);
		        $total_hour  += $extra_hours;
		        $total_minute = $total_minute % 60;
		    }

		    $time = $total_hour.':'.$total_minute;
			$rate = $total_price;

			if (isset($client_id)) {
				$sql = "INSERT INTO time_reports (client_id, time, rate)
			            VALUES (?, ?, ?)";
			    $this->db->query($sql, array($client_id, $time, $rate));

				$sql = "DELETE FROM time_manager WHERE client_id = ?";
				$this->db->query($sql, [$client_id]);	
			}
		}

		$sql = "SELECT client_profiles.client_id, guardian_name, guardian_contact, full_name, gender, birthdate, profile_image, client_status, start_time, rate_id FROM time_manager, client_profiles WHERE client_profiles.client_id = time_manager.client_id";
		$query = $this->db->query($sql);

		$output_data = array();

		foreach ($query->result() as $row) {

		    $client_id        = $row->client_id;
		    $guardian_name    = $row->guardian_name;
		    $guardian_contact = $row->guardian_contact;
		    $full_name        = $row->full_name;
		    $gender           = $row->gender;
		    $birthdate        = $row->birthdate;
		    $profile_image    = $row->profile_image;
		    $start_time       = $row->start_time;
		    $client_status    = $row->client_status;

		    $rate_ids = explode(',', $row->rate_id);

		    $total_hour   = 0;
		    $total_minute = 0;
		    $total_price  = 0;

		    foreach ($rate_ids as $rate) {

		        $rate = trim($rate);

		        $sql = "SELECT hour, minute, price FROM time_rates WHERE rate_id = ?";
		        $query2 = $this->db->query($sql, array($rate));

		        foreach ($query2->result() as $row2) {
		            $total_hour   += $row2->hour;
		            $total_minute += $row2->minute;
		            $total_price  += $row2->price;
		        }
		    }

		    // Normalize minutes
		    if ($total_minute >= 60) {
		        $extra_hours  = floor($total_minute / 60);
		        $total_hour  += $extra_hours;
		        $total_minute = $total_minute % 60;
		    }

		    // Store results
		    $output_data[] = array(
		        'client_id'        => $client_id,
		        'guardian_name'    => $guardian_name,
		        'guardian_contact' => $guardian_contact,
		        'full_name'        => $full_name,
		        'gender'           => $gender,
		        'birthdate'        => $birthdate,
		        'profile_image'    => $profile_image,
		        'client_status'    => $client_status,
		        'start_time'       => $start_time,
		        'total_hours'       => $total_hour,
		        'total_minutes'     => $total_minute,
		        'total_price'      => $total_price
		    );
		}
	    
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function load_registered_clients()
	{
		$sql = "SELECT * FROM client_profiles WHERE client_status = 1";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function load_archived_clients()
	{
		$sql = "SELECT * FROM client_profiles WHERE client_status = 0";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function load_time_rates()
	{
		$sql = "SELECT * FROM time_rates";
		// $sql = "SELECT * FROM client_profiles LEFT JOIN time_manager ON client_profiles.client_id = time_manager.client_id";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function new_active_client()
	{
		date_default_timezone_set('Asia/Manila');
		$current_date = date('Y-m-d');

	    $client_id = $_POST['client_id'];
		$start_time = date("H:i:s");
	    $time_rate = $_POST['time_rate'];

		$sql = "SELECT client_id FROM time_manager WHERE client_id = ?";
		$query = $this->db->query($sql, $client_id);
		foreach ($query->result() as $row) {
 			$res_client_id = $row->res_client_id;
		}
		if (isset($res_client_id)) {
			echo "duplicate";
		}
		else {

		    $sql = "INSERT INTO time_manager (client_id, time_date, start_time, rate_id)
		            VALUES (?, ?, ?, ?)";
		    $this->db->query($sql, array($client_id, $current_date, $start_time, $time_rate));

		    if ($this->db->affected_rows() > 0) {
		        echo "success";
		        $sql = "SELECT hour, minute, price FROM time_rates WHERE rate_id = ?";
				$query = $this->db->query($sql, $time_rate);
				foreach ($query->result() as $row) {
		 			$hour = $row->hour;
		 			$minute = $row->minute;
		 			$price = $row->price;
				}
				$time = '';
				if ($price != 0) {
					if ($hour > 0 && $minute > 0) {
					    $time = $hour . ' hour' . ($hour > 1 ? 's ' : ' ') . $minute . ' min' . ($minute > 1 ? 's' : '');
					} elseif ($hour > 0) {
					    $time = $hour . ' hour' . ($hour > 1 ? 's' : '');
					} elseif ($minute > 0) {
					    $time = $minute . ' min' . ($minute > 1 ? 's' : '');
					} else {
					    $time = 'Unlimited';
					}
				}
				else {
					$time = 'Loyalty';
				}

	        	$activity = "<strong>Time Created:</strong><br>Time: ".$time.", "."Rate: ₱".$price;
		        $sql = "INSERT INTO time_logs (client_id, activity)
		            VALUES (?, ?)";
		    	$this->db->query($sql, array($client_id, $activity));
		    } else {
		        echo "error";
		    }	
		}
	}
	public function extend_client_time()
	{
		date_default_timezone_set('Asia/Manila');
		$current_date = date('Y-m-d');

	    $client_id = $_POST['extend_client_id'];
		$start_time = date("H:i:s");
	    $time_rate = $_POST['extend_time_rate'];

	    if ($time_rate == 0) {
		    $sql = "UPDATE time_manager SET rate_id = ? WHERE client_id = ?";
	    }
	    else {
	    	$time_rate = ','.$time_rate;
		    $sql = "UPDATE time_manager SET rate_id = CONCAT(rate_id, ?) WHERE client_id = ?";
	    }

	    $this->db->query($sql, array($time_rate, $client_id));

	    if ($this->db->affected_rows() > 0) {
	        $sql = "SELECT hour, minute, price FROM time_rates WHERE rate_id = ?";
			$query = $this->db->query($sql, [$_POST['extend_time_rate']]);
			foreach ($query->result() as $row) {
	 			$hour = $row->hour;
	 			$minute = $row->minute;
	 			$price = $row->price;
			}
			$time = '';
			if ($price != 0) {
				if ($hour > 0 && $minute > 0) {
				    $time = $hour . ' hour' . ($hour > 1 ? 's ' : ' ') . $minute . ' min' . ($minute > 1 ? 's' : '');
				} elseif ($hour > 0) {
				    $time = $hour . ' hour' . ($hour > 1 ? 's' : '');
				} elseif ($minute > 0) {
				    $time = $minute . ' min' . ($minute > 1 ? 's' : '');
				} else {
				    $time = 'Unlimited';
				}
			}
			else {
				$time = 'Loyalty';
			}

	        $activity = "<strong>Time Extended:</strong><br>Time: ".$time.", "."Rate: ₱".$price;
	        $sql = "INSERT INTO time_logs (client_id, activity)
	            VALUES (?, ?)";
	    	$this->db->query($sql, array($client_id, $activity));
	    	echo $client_id;
	    } else {
	        echo "error";
	    }	
	}
	public function end_client_time()
	{
	    $client_id = $_POST['client_id'];
	    $sql = "SELECT rate_id FROM time_manager WHERE client_id = ?";
		$query = $this->db->query($sql, [$client_id]);

		$output_data = array();

		foreach ($query->result() as $row) {
		    $rate_ids = explode(',', $row->rate_id);

		    $total_hour   = 0;
		    $total_minute = 0;
		    $total_price  = 0;

		    foreach ($rate_ids as $rate) {

		        $rate = trim($rate);

		        $sql = "SELECT hour, minute, price FROM time_rates WHERE rate_id = ?";
		        $query2 = $this->db->query($sql, array($rate));

		        foreach ($query2->result() as $row2) {
		            $total_hour   += $row2->hour;
		            $total_minute += $row2->minute;
		            $total_price  += $row2->price;
		        }
		    }

		    // Normalize minutes
		    if ($total_minute >= 60) {
		        $extra_hours  = floor($total_minute / 60);
		        $total_hour  += $extra_hours;
		        $total_minute = $total_minute % 60;
		    }

		    $time = $total_hour.':'.$total_minute;
			$rate = $total_price;
		}

	    $sql = "INSERT INTO time_reports (client_id, time, rate)
		            VALUES (?, ?, ?)";
	    $this->db->query($sql, array($client_id, $time, $rate));

	    $time = '';
		if ($hour > 0 && $minute > 0) {
		    $time = $hour . ' hour' . ($hour > 1 ? 's ' : ' ') . $minute . ' min' . ($minute > 1 ? 's' : '');
		} elseif ($hour > 0) {
		    $time = $hour . ' hour' . ($hour > 1 ? 's' : '');
		} elseif ($minute > 0) {
		    $time = $minute . ' min' . ($minute > 1 ? 's' : '');
		} else {
		    $time = 'Unlimited';
		}

	    $activity = "<strong>Time Ended:</strong><br>Time: ".$time.", "."Rate: ₱".$rate;
        $sql = "INSERT INTO time_logs (client_id, activity)
            VALUES (?, ?)";
    	$this->db->query($sql, array($client_id, $activity));

		$sql = "DELETE FROM time_manager WHERE client_id = ?";
		$query = $this->db->query($sql, [$client_id]);

		if ($query) {
		    echo $client_id;
		} else {
		    echo 'error';
		}
	}
	public function remove_client_time()
	{
	    $client_id = $_POST['client_id'];
	    $hour = $_POST['hour'];
	    $minute = $_POST['minute'];
	    $price = $_POST['price'];

		$sql = "DELETE FROM time_manager WHERE client_id = ?";
		$query = $this->db->query($sql, [$client_id]);

		if ($query) {
		    $time = '';
			if ($price != 0) {
				if ($hour > 0 && $minute > 0) {
				    $time = $hour . ' hour' . ($hour > 1 ? 's ' : ' ') . $minute . ' min' . ($minute > 1 ? 's' : '');
				} elseif ($hour > 0) {
				    $time = $hour . ' hour' . ($hour > 1 ? 's' : '');
				} elseif ($minute > 0) {
				    $time = $minute . ' min' . ($minute > 1 ? 's' : '');
				} else {
				    $time = 'Unlimited';
				}
			}
			else {
				$time = 'Loyalty';
			}

        	$activity = "<strong>Time Cancelled:</strong><br>Time: ".$time.", "."Rate: ₱".$price;
	        $sql = "INSERT INTO time_logs (client_id, activity)
	            VALUES (?, ?)";
	    	$this->db->query($sql, array($client_id, $activity));
	    	
		    echo $client_id;
		} else {
		    echo 'error';
		}
	}
	public function archive_client()
	{
	    $client_id = $_POST['client_id'];

	    $sql = "UPDATE client_profiles SET client_status = 0 WHERE client_id = ?";
		$query = $this->db->query($sql, [$client_id]);

		if ($query) {
		    echo 'success';
		} else {
		    echo 'error';
		}
	}
	public function unarchive_client()
	{
	    $client_id = $_POST['client_id'];

	    $sql = "UPDATE client_profiles SET client_status = 1 WHERE client_id = ?";
		$query = $this->db->query($sql, [$client_id]);

		if ($query) {
		    echo 'success';
		} else {
		    echo 'error';
		}
	}
	public function delete_client()
	{
	    $client_id = $_POST['client_id'];

	    $sql = "UPDATE client_profiles SET client_status = 3 WHERE client_id = ?";
		$query = $this->db->query($sql, [$client_id]);

		if ($query) {
		    echo 'success';
		} else {
		    echo 'error';
		}
	}
	public function load_tm_reports()
	{
	    $report_type = $_POST['report_type'];
	    $report_date = $_POST['report_date'];

	    if ($report_type == 'daily') {
	    	$sql = "SELECT report_id, full_name, birthdate, profile_image, time_reports.client_id, SUM(rate) AS total_rate, FLOOR(SUM(SUBSTRING_INDEX(time, ':', 1)) + (SUM(SUBSTRING_INDEX(time, ':', -1)) DIV 60)) AS total_hours, MOD(SUM(SUBSTRING_INDEX(time, ':', -1)), 60) AS total_minutes FROM client_profiles, time_reports WHERE client_profiles.client_id = time_reports.client_id AND DATE(time_stamp) = ? GROUP BY time_reports.client_id ORDER BY time_reports.client_id ASC";
	    }
	    else if ($report_type == 'monthly') {
	    	$sql = "SELECT report_id, full_name, birthdate, profile_image, time_reports.client_id, SUM(rate) AS total_rate, FLOOR(SUM(SUBSTRING_INDEX(time, ':', 1)) + (SUM(SUBSTRING_INDEX(time, ':', -1)) DIV 60)) AS total_hours, MOD(SUM(SUBSTRING_INDEX(time, ':', -1)), 60) AS total_minutes FROM client_profiles, time_reports WHERE client_profiles.client_id = time_reports.client_id AND DATE_FORMAT(time_stamp, '%Y-%m') = DATE_FORMAT(?, '%Y-%m') GROUP BY time_reports.client_id ORDER BY time_reports.client_id ASC";
	    }
	    else if ($report_type == 'annual') {
	    	$sql = "SELECT report_id, full_name, birthdate, profile_image, time_reports.client_id, SUM(rate) AS total_rate, FLOOR(SUM(SUBSTRING_INDEX(time, ':', 1)) + (SUM(SUBSTRING_INDEX(time, ':', -1)) DIV 60)) AS total_hours, MOD(SUM(SUBSTRING_INDEX(time, ':', -1)), 60) AS total_minutes FROM client_profiles, time_reports WHERE client_profiles.client_id = time_reports.client_id AND YEAR(time_stamp) = YEAR(?) GROUP BY time_reports.client_id ORDER BY time_reports.client_id ASC";
	    }
		$query = $this->db->query($sql, $report_date);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function load_tm_logs()
	{
	    $log_type = $_POST['log_type'];
	    $log_date = $_POST['log_date'];

	    if ($log_type == 'daily') {
	    	$sql = "SELECT * FROM client_profiles JOIN time_logs ON client_profiles.client_id=time_logs.client_id WHERE DATE(time_logs.time_stamp)=? ORDER BY time_logs.log_id ASC";
	    }
	    else if ($log_type == 'monthly') {
	    	$sql = "SELECT * FROM client_profiles JOIN time_logs ON client_profiles.client_id=time_logs.client_id WHERE DATE_FORMAT(time_logs.time_stamp,'%Y-%m')=DATE_FORMAT(?,'%Y-%m') ORDER BY time_logs.log_id ASC";
	    }
	    else if ($log_type == 'annual') {
	    	$sql = "SELECT * FROM client_profiles JOIN time_logs ON client_profiles.client_id=time_logs.client_id WHERE YEAR(time_logs.time_stamp)=YEAR(?) ORDER BY time_logs.log_id ASC";
	    }
		$query = $this->db->query($sql, $log_date);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function new_pos_item()
	{
	    // Handle pluralization of units
	    function pluralize_unit($unit, $count) {
	        $unit = strtolower(trim($unit));

	        // Irregular plural forms
	        $irregulars = [
	            'man' => 'men',
	            'woman' => 'women',
	            'person' => 'people',
	            'mouse' => 'mice',
	            'goose' => 'geese',
	            'tooth' => 'teeth',
	            'foot' => 'feet',
	            'child' => 'children',
	        ];

	        if ($count == 1) {
	            // Return singular
	            foreach ($irregulars as $singular => $plural) {
	                if ($unit === $plural) return $singular;
	            }
	            if (preg_match('/(sh|ch|x|z|s)$/', $unit)) {
	                return preg_replace('/(es)$/', '', $unit);
	            } else {
	                return preg_replace('/s$/', '', $unit);
	            }
	        } else {
	            // Return plural
	            if (array_key_exists($unit, $irregulars)) return $irregulars[$unit];
	            if (in_array($unit, $irregulars)) return $unit;
	            if (preg_match('/(sh|ch|x|z|s)$/', $unit)) return $unit . 'es';
	            return preg_match('/s$/', $unit) ? $unit : $unit . 's';
	        }
	    }

	    // Retrieve form inputs
	    $new_pos_item_name = $_POST['new_pos_item_name'];
	    $new_pos_item_price = $_POST['new_pos_item_price'];
	    $new_pos_item_stock = $_POST['new_pos_item_stock'];
	    $new_pos_item_unit = $_POST['new_pos_item_unit'];
	    $new_pos_item_low = $_POST['new_pos_item_low'];
	    $new_pos_item_image_base64 = $_POST['new_pos_item_image'] ?? '';
	    $new_pos_item_image_name = $_POST['new_pos_item_image_name'] ?? '';

	    // Check for duplicate item name
	    $sql = "SELECT pos_item_name FROM pos_inventory WHERE pos_item_name = ?";
	    $query = $this->db->query($sql, [$new_pos_item_name]);
	    if ($query->num_rows() > 0) {
	        echo "duplicate";
	        return;
	    }

	    // Handle image saving
	    $saved_file_path = null;
	    if (!empty($new_pos_item_image_base64)) {
	        $image_parts = explode(";base64,", $new_pos_item_image_base64);
	        if (count($image_parts) == 2) {
	            $image_base64 = base64_decode($image_parts[1]);
	            $file_name = $new_pos_item_image_name;
	            $upload_path = FCPATH . 'photos/pos_images/';

	            if (!is_dir($upload_path)) {
	                mkdir($upload_path, 0755, true);
	            }

	            file_put_contents($upload_path . $file_name, $image_base64);
	            $saved_file_path = 'photos/pos_images/' . $file_name;
	        }
	    }

	    // Insert new item into the database
	    $sql = "INSERT INTO pos_inventory (pos_item_name, pos_item_price, pos_item_image, pos_item_stock, pos_item_unit, pos_item_low)
	            VALUES (?, ?, ?, ?, ?, ?)";
	    $this->db->query($sql, [
	        $new_pos_item_name,
	        $new_pos_item_price,
	        $new_pos_item_image_name,
	        $new_pos_item_stock,
	        $new_pos_item_unit,
	        $new_pos_item_low
	    ]);

	    if ($this->db->affected_rows() > 0) {
	        echo "success";

	        $pos_item_id = $this->db->insert_id();
	        $unit_label = pluralize_unit($new_pos_item_unit, $new_pos_item_stock);
	        $activity_type = "Item Creation";
        	$pos_code = "Item ID: ". $pos_item_id;
	        $activity = "
	            <strong>Item '$new_pos_item_name' created.</strong>
	            <br>Price: ₱$new_pos_item_price
	            <br>Stock: $new_pos_item_stock $unit_label
	            <br>Low: $new_pos_item_low
	        ";
	        $sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $pos_code, $activity]);
	    } else {
	        echo "error";
	    }
	}


	public function pos_checkout(){
	    date_default_timezone_set('Asia/Manila');
	    $current_date = date('Y-m-d H:i:s');

	    // Generate unique checkout code
	    $random_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
	    $pos_checkout_code = 'POS-' . date('Ymd') . '-' . $random_code;

	    // Retrieve posted cart data
	    $cart_items = $this->input->post('cart_items');
	    if (is_string($cart_items)) {
	        $cart_items = json_decode($cart_items, true);
	    }
	    
	    if (empty($cart_items) || !is_array($cart_items)) {
	        echo "empty_cart";
	        return;
	    }

	    $checked_out_items = [];
	    $failed = false; // <-- final status tracker

	    foreach ($cart_items as $item) {
	        $pos_item_id        = $item['pos_item_id'];
	        $pos_item_name      = $item['pos_item_name'];
	        $pos_item_price     = $item['pos_item_price'];
	        $pos_item_count     = $item['item_count'];
	        $pos_item_unit      = $item['pos_item_unit'];
	        $pos_item_image     = $item['pos_item_image'];
	        $pos_item_subtotal  = $item['total_item_price'];

	        // Insert checkout item
	        $sql = "INSERT INTO pos_checkouts 
	                (pos_checkout_code, pos_item_id, pos_item_name, pos_item_price, pos_item_count, pos_item_unit, pos_item_image, pos_item_subtotal, pos_checkout_date)
	                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

	        $insert_query = $this->db->query($sql, [
	            $pos_checkout_code,
	            $pos_item_id,
	            $pos_item_name,
	            $pos_item_price,
	            $pos_item_count,
	            $pos_item_unit,
	            $pos_item_image,
	            $pos_item_subtotal,
	            $current_date
	        ]);

	        if (!$insert_query) {
	            $failed = true;
	            continue; // skip stock update for this item
	        }

	        // Update inventory
	        $sql = "UPDATE pos_inventory 
	                SET pos_item_stock = pos_item_stock - ? 
	                WHERE pos_item_id = ?";
	        $update_query = $this->db->query($sql, [$pos_item_count, $pos_item_id]);

	        if (!$update_query) {
	            $failed = true;
	        }

	        $checked_out_items[] = "{$pos_item_name} ({$pos_item_count} {$pos_item_unit})";
	    }

	    // Log only if at least something was processed
	    if (!empty($checked_out_items)) {
	        $activity_type = 'Checkout';
	        $activity = implode('<br>', $checked_out_items);
	        $sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity)
	                VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $pos_checkout_code, $activity]);
	    }

	    // Final output
	    echo $failed ? "error" : "success";
	}

	public function load_pos_checkout_codes(){
	    $report_type = $_POST['pos_checkouts_type'];
		$report_date = $_POST['pos_checkouts_date'];

		if ($report_type == 'daily') {
		    $sql = "
		    	SELECT 
				    c.pos_checkout_code,
				    SUM(c.pos_item_count) AS total_item_count,
				    MAX(c.pos_checkout_date) AS pos_checkout_date
				FROM pos_checkouts c
				WHERE DATE(c.pos_checkout_date) = ?
				GROUP BY c.pos_checkout_code
				ORDER BY c.pos_checkout_date DESC;
		    ";
		}
		else if ($report_type == 'monthly') {
		    $sql = "
		    	SELECT 
				    c.pos_checkout_code,
				    SUM(c.pos_item_count) AS total_item_count,
				    MAX(c.pos_checkout_date) AS pos_checkout_date
				FROM pos_checkouts c
				WHERE DATE_FORMAT(c.pos_checkout_date, '%Y-%m') = DATE_FORMAT(?, '%Y-%m')
				GROUP BY c.pos_checkout_code
				ORDER BY c.pos_checkout_date DESC;
		    ";
		}
		else if ($report_type == 'annual') {
		    $sql = "
		    	SELECT 
				    c.pos_checkout_code,
				    SUM(c.pos_item_count) AS total_item_count,
				    MAX(c.pos_checkout_date) AS pos_checkout_date
				FROM pos_checkouts c
				WHERE DATE_FORMAT(c.pos_checkout_date, '%Y') = DATE_FORMAT(?, '%Y')
				GROUP BY c.pos_checkout_code
				ORDER BY c.pos_checkout_date DESC;
		    ";
		}

		$query = $this->db->query($sql, $report_date);

		foreach ($query->result() as $row) {
		    $output_data[] = $row;
		}

		if (isset($output_data)) {
		    echo json_encode($output_data);
		} else {
		    echo json_encode('');
		}
	}

	public function load_pos_checkout()
	{
	    $pos_checkout_code = $_POST['pos_checkout_code'];

	    $sql = "
	        SELECT 
	            c.pos_checkout_id,
	            i.pos_item_image,
	            i.pos_item_name,
	            i.pos_item_price,
	            c.pos_item_count,
	            i.pos_item_unit
	        FROM 
	            pos_checkouts c,
	            pos_inventory i
	        WHERE 
	            c.pos_item_id = i.pos_item_id 
	            AND
	            pos_checkout_code = ?
	        ORDER BY pos_checkout_id DESC;
	    ";

	    $query = $this->db->query($sql, [$pos_checkout_code]);

	    foreach ($query->result() as $row) {
	        $output_data[] = $row;
	    }

	    if (isset($output_data)) {
	        echo json_encode($output_data);
	    } else {
	        echo json_encode('');
	    }
	}
	public function void_pos_checkout_item(){
	    $pos_checkout_id = $_POST['pos_checkout_id'];
	
	    $sql = "SELECT pos_item_id, pos_item_count, pos_checkout_code, pos_item_name FROM pos_checkouts WHERE pos_checkout_id = ?";
	    $select_query = $this->db->query($sql, [$pos_checkout_id]);
		foreach ($select_query->result() as $row) {
 			$pos_item_id = $row->pos_item_id;
 			$pos_item_count = $row->pos_item_count;
 			$pos_checkout_code = $row->pos_checkout_code;
 			$pos_item_name = $row->pos_item_name;
		}
        
        $sql = "UPDATE pos_inventory SET pos_item_stock = pos_item_stock + ? WHERE pos_item_id = ?";
	    $update_query = $this->db->query($sql, [$pos_item_count, $pos_item_id]);

	    if ($update_query) {
			$sql = "DELETE FROM pos_checkouts WHERE pos_checkout_id = ?";
		    $delete_query = $this->db->query($sql, [$pos_checkout_id]);	 

		    if ($delete_query) {
		    	$sql = "SELECT COUNT(*) AS total FROM pos_checkouts WHERE pos_checkout_code = ?";
				$query = $this->db->query($sql, [$pos_checkout_code]);
				$result = $query->row();
				$pos_checkout_count = $result->total;

				$activity_type = "Checkout Item Voided";
	        	$pos_code = $pos_checkout_code;
		        $activity = "
		            Voided $pos_item_name * $pos_item_count from '$pos_checkout_code'.
		        ";
		        $sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)";
		        $this->db->query($sql, [$activity_type, $pos_code, $activity]);

				if ($pos_checkout_count == 0) {
		    		echo "success-null";
				}
				else {
		    		echo "success";
				}
	       	}
	       	else {
	    		echo "error";
	       	}
	    }
	    else {
    		echo "error";
	    }
	}
	public function void_pos_checkout(){
	    $pos_checkout_code = $_POST['pos_checkout_code'];
	
	    $sql = "SELECT pos_item_id, pos_item_count FROM pos_checkouts WHERE pos_checkout_code = ?";
	    $select_query = $this->db->query($sql, [$pos_checkout_code]);
		foreach ($select_query->result() as $row) {
 			$pos_item_id = $row->pos_item_id;
 			$pos_item_count = $row->pos_item_count;
		
 			$sql = "UPDATE pos_inventory SET pos_item_stock = pos_item_stock + ? WHERE pos_item_id = ?";
	    	$update_query = $this->db->query($sql, [$pos_item_count, $pos_item_id]);
		}

	    if ($update_query) {
			$sql = "DELETE FROM pos_checkouts WHERE pos_checkout_code = ?";
		    $delete_query = $this->db->query($sql, [$pos_checkout_code]);	 

		    $activity_type = "Checkout Voided";
        	$pos_code = $pos_checkout_code;
	        $activity = "
	            Voided the whole checkout with code '$pos_checkout_code'.
	        ";
	        $sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $pos_code, $activity]);

		    if ($delete_query) {
	    		echo "success";
	       	}
	       	else {
	    		echo "error";
	       	}
	    }
	    else {
    		echo "error";
	    }
	}
	public function pos_restock()
	{
	    $pos_restocking_date = $_POST['pos_restocking_date'];

	    $random_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
	    $pos_restocking_code = 'STK-' . $pos_restocking_date . '-' . $random_code;

	    $pos_restocking_items = $this->input->post('pos_restocking_items');
	    if (is_string($pos_restocking_items)) {
	        $pos_restocking_items = json_decode($pos_restocking_items, true);
	    }

	    if (empty($pos_restocking_items) || !is_array($pos_restocking_items)) {
	        echo "empty_cart";
	        return;
	    }

	    $failed = false;
	    $restocked_items = [];

	    foreach ($pos_restocking_items as $item) {

	        $pos_item_id = $item['pos_item_id'];
	        $pos_item_count = $item['pos_item_count'];

	        // get item details
	        $sql = "SELECT pos_item_name, pos_item_unit FROM pos_inventory WHERE pos_item_id = ?";
	        $select_query = $this->db->query($sql, [$pos_item_id]);

	        if ($select_query->num_rows() == 0) {
	            $failed = true;
	            continue;
	        }

	        $row = $select_query->row();
	        $pos_item_name = $row->pos_item_name;
	        $pos_item_unit = $row->pos_item_unit;

	        // insert restocking record
	        $sql = "INSERT INTO pos_restocking
	                (pos_restocking_code, pos_item_id, pos_item_count, pos_restocking_date)
	                VALUES (?, ?, ?, ?)";

	        $insert_query = $this->db->query($sql, [
	            $pos_restocking_code,
	            $pos_item_id,
	            $pos_item_count,
	            $pos_restocking_date
	        ]);

	        if (!$insert_query) {
	            $failed = true;
	            continue;
	        }

	        // update stock
	        $sql = "UPDATE pos_inventory SET pos_item_stock = pos_item_stock + ? WHERE pos_item_id = ?";
	        $update_query = $this->db->query($sql, [$pos_item_count, $pos_item_id]);

	        if ($update_query) {
	            $restocked_items[] = "{$pos_item_name} ({$pos_item_count} {$pos_item_unit})";
	        } else {
	            $failed = true;
	        }
	    }

	    // insert one log AFTER all items
	    if (!empty($restocked_items)) {
			$activity_type = 'Restocking';
	        $activity = implode('<br>', $restocked_items);
	        $sql = "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $pos_restocking_code, $activity]);
	    }

	    echo $failed ? "error" : "success";
	}
	public function load_pos_reports()
	{
	    $log_type = $_POST['pos_log_type'];
	    $log_date = $_POST['pos_log_date'];

	    if ($log_type == 'daily') {
	    	$sql = "
	    		SELECT 
				    'Checkout' AS activity_type,
				    c.pos_checkout_code AS reference_code,
				    c.pos_item_name AS item_name,
				    c.pos_item_count AS quantity,
				    c.pos_item_subtotal AS amount,
				    c.pos_item_image AS item_image,
				    c.pos_checkout_date AS log_date
				FROM pos_checkouts c
				WHERE DATE(c.pos_checkout_date) = ?

				UNION ALL

				SELECT 
				    'Restock' AS activity_type,
				    r.pos_restocking_code AS reference_code,
				    i.pos_item_name AS item_name,
				    r.pos_item_count AS quantity,
				    NULL AS amount,
				    i.pos_item_image AS item_image,
				    r.pos_restocking_timestamp AS log_date
				FROM pos_restocking r
				JOIN pos_inventory i ON r.pos_item_id = i.pos_item_id
				WHERE DATE(r.pos_restocking_timestamp) = ?

				ORDER BY log_date DESC;
	    	";
	    }
	    else if ($log_type == 'monthly') {
	    	$sql = "
	    		SELECT 
				    'Checkout' AS activity_type,
				    c.pos_checkout_code AS reference_code,
				    c.pos_item_name AS item_name,
				    c.pos_item_count AS quantity,
				    c.pos_item_subtotal AS amount,
				    c.pos_item_image AS item_image,
				    c.pos_checkout_date AS log_date
				FROM pos_checkouts c
				WHERE MONTH(c.pos_checkout_date) = MONTH(?)

				UNION ALL

				SELECT 
				    'Restock' AS activity_type,
				    r.pos_restocking_code AS reference_code,
				    i.pos_item_name AS item_name,
				    r.pos_item_count AS quantity,
				    NULL AS amount,
				    i.pos_item_image AS item_image,
				    r.pos_restocking_timestamp AS log_date
				FROM pos_restocking r
				JOIN pos_inventory i ON r.pos_item_id = i.pos_item_id
				WHERE MONTH(r.pos_restocking_timestamp) = MONTH(?)

				ORDER BY log_date DESC;
	    	";
	    }
	    else if ($log_type == 'annual') {
	    	$sql = "
	    		SELECT 
				    'Checkout' AS activity_type,
				    c.pos_checkout_code AS reference_code,
				    c.pos_item_name AS item_name,
				    c.pos_item_count AS quantity,
				    c.pos_item_subtotal AS amount,
				    c.pos_item_image AS item_image,
				    c.pos_checkout_date AS log_date
				FROM pos_checkouts c
				WHERE YEAR(c.pos_checkout_date) = YEAR(?)

				UNION ALL

				SELECT 
				    'Restock' AS activity_type,
				    r.pos_restocking_code AS reference_code,
				    i.pos_item_name AS item_name,
				    r.pos_item_count AS quantity,
				    NULL AS amount,
				    i.pos_item_image AS item_image,
				    r.pos_restocking_timestamp AS log_date
				FROM pos_restocking r
				JOIN pos_inventory i ON r.pos_item_id = i.pos_item_id
				WHERE YEAR(r.pos_restocking_timestamp) = YEAR(?)

				ORDER BY log_date DESC;
	    	";
	    }
		$query = $this->db->query($sql, [$log_date, $log_date]);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function load_pos_restocking_codes()
	{
	    $report_type = $_POST['pos_restocking_report_type'];
	    $report_date = $_POST['pos_restocking_report_date'];

	    if ($report_type == 'daily') {
	    	$sql = "
	    		SELECT 
				    r.pos_restocking_code,
				    SUM(r.pos_item_count) AS total_item_count,
				    MAX(r.pos_restocking_date) AS pos_restocking_date,
				    MAX(r.pos_restocking_timestamp) AS pos_restocking_timestamp
				FROM pos_restocking r
				WHERE DATE(r.pos_restocking_date) = ?
				GROUP BY r.pos_restocking_code
				ORDER BY r.pos_restocking_timestamp DESC;
	    	";
	    }
	    else if ($report_type == 'monthly') {
	    	$sql = "
	    		SELECT 
				    r.pos_restocking_code,
				    SUM(r.pos_item_count) AS total_item_count,
				    MAX(r.pos_restocking_date) AS pos_restocking_date,
				    MAX(r.pos_restocking_timestamp) AS pos_restocking_timestamp
				FROM pos_restocking r
				WHERE MONTH(r.pos_restocking_date) = MONTH(?)
				GROUP BY r.pos_restocking_code
				ORDER BY r.pos_restocking_timestamp DESC;
	    	";
	    }
	    else if ($report_type == 'annual') {
	    	$sql = "
	    		SELECT 
				    r.pos_restocking_code,
				    SUM(r.pos_item_count) AS total_item_count,
				    MAX(r.pos_restocking_date) AS pos_restocking_date,
				    MAX(r.pos_restocking_timestamp) AS pos_restocking_timestamp
				FROM pos_restocking r
				WHERE YEAR(r.pos_restocking_date) = YEAR(?)
				GROUP BY r.pos_restocking_code
				ORDER BY r.pos_restocking_timestamp DESC;
	    	";
	    }
		$query = $this->db->query($sql, [$report_date]);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}

	public function load_pos_restocking()
	{
	    $pos_restocking_code = $_POST['pos_restocking_code'];
    	$sql = "
    		SELECT 
			    r.pos_restocking_id,
			    i.pos_item_image,
			    i.pos_item_name,
			    i.pos_item_price,
			    r.pos_item_count,
			    i.pos_item_unit
			FROM 
				pos_restocking r, 
				pos_inventory i
			WHERE 
				r.pos_item_id = i.pos_item_id 
				AND
				pos_restocking_code = ?
			ORDER BY pos_restocking_id DESC;
    	";
		$query = $this->db->query($sql, [$pos_restocking_code]);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}

	public function load_supply_inventory()
	{
	    $sql = "SELECT * FROM supply_inventory WHERE supply_item_status != 0";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function new_supply_item()
	{
	    // Handle pluralization of units
	    function pluralize_unit($unit, $count) {
	        $unit = strtolower(trim($unit));

	        // Irregular plural forms
	        $irregulars = [
	            'man' => 'men',
	            'woman' => 'women',
	            'person' => 'people',
	            'mouse' => 'mice',
	            'goose' => 'geese',
	            'tooth' => 'teeth',
	            'foot' => 'feet',
	            'child' => 'children',
	        ];

	        if ($count == 1) {
	            // Return singular
	            foreach ($irregulars as $singular => $plural) {
	                if ($unit === $plural) return $singular;
	            }
	            if (preg_match('/(sh|ch|x|z|s)$/', $unit)) {
	                return preg_replace('/(es)$/', '', $unit);
	            } else {
	                return preg_replace('/s$/', '', $unit);
	            }
	        } else {
	            // Return plural
	            if (array_key_exists($unit, $irregulars)) return $irregulars[$unit];
	            if (in_array($unit, $irregulars)) return $unit;
	            if (preg_match('/(sh|ch|x|z|s)$/', $unit)) return $unit . 'es';
	            return preg_match('/s$/', $unit) ? $unit : $unit . 's';
	        }
	    }

	    // Retrieve form inputs
	    $new_supply_item_name = $_POST['new_supply_item_name'];
	    $new_supply_item_price = $_POST['new_supply_item_price'];
	    $new_supply_item_stock = $_POST['new_supply_item_stock'];
	    $new_supply_item_unit = $_POST['new_supply_item_unit'];
	    $new_supply_item_low = $_POST['new_supply_item_low'];
	    $new_supply_item_image_base64 = $_POST['new_supply_item_image'] ?? '';
	    $new_supply_item_image_name = $_POST['new_supply_item_image_name'] ?? '';

	    // Check for duplicate item name
	    $sql = "SELECT supply_item_name FROM supply_inventory WHERE supply_item_name = ?";
	    $query = $this->db->query($sql, [$new_supply_item_name]);
	    if ($query->num_rows() > 0) {
	        echo "duplicate";
	        return;
	    }

	    // Handle image saving
	    $saved_file_path = null;
	    if (!empty($new_supply_item_image_base64)) {
	        $image_parts = explode(";base64,", $new_supply_item_image_base64);
	        if (count($image_parts) == 2) {
	            $image_base64 = base64_decode($image_parts[1]);
	            $file_name = $new_supply_item_image_name;
	            $upload_path = FCPATH . 'photos/supply_images/';

	            if (!is_dir($upload_path)) {
	                mkdir($upload_path, 0755, true);
	            }

	            file_put_contents($upload_path . $file_name, $image_base64);
	            $saved_file_path = 'photos/supply_images/' . $file_name;
	        }
	    }

	    // Insert new item into the database
	    $sql = "INSERT INTO supply_inventory (supply_item_name, supply_item_price, supply_item_image, supply_item_stock, supply_item_unit, supply_item_low)
	            VALUES (?, ?, ?, ?, ?, ?)";
	    $this->db->query($sql, [
	        $new_supply_item_name,
	        $new_supply_item_price,
	        $new_supply_item_image_name,
	        $new_supply_item_stock,
	        $new_supply_item_unit,
	        $new_supply_item_low
	    ]);

	    if ($this->db->affected_rows() > 0) {
	        echo "success";

	        $supply_item_id = $this->db->insert_id();
	        $unit_label = pluralize_unit($new_supply_item_unit, $new_supply_item_stock);
	        $activity_type = "Item Creation";
        	$supply_code = "Item ID: ". $supply_item_id;
	        $activity = "
	            <strong>Item '$new_supply_item_name' created.</strong>
	            <br>Price: ₱$new_supply_item_price
	            <br>Stock: $new_supply_item_stock $unit_label
	            <br>Low: $new_supply_item_low
	        ";
	        $sql = "INSERT INTO supply_logs (supply_activity_type, supply_code, supply_activity) VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $supply_code, $activity]);
	    } else {
	        echo "error";
	    }
	}

	public function update_supply_item()
	{
	    $supply_item_id        = $_POST['update_supply_item_id'];
	    $supply_item_name      = $_POST['update_supply_item_name'];
	    $supply_item_price     = $_POST['update_supply_item_price'];
	    $supply_item_unit      = $_POST['update_supply_item_unit'];
	    $supply_item_stock     = $_POST['update_supply_item_stock'];
	    $supply_item_low       = $_POST['update_supply_item_low'];
	    $supply_item_image_b64 = $_POST['update_supply_item_image'];
	    $supply_item_image_name = $_POST['update_supply_item_image_name'];

	    // Fetch current record for comparison
	    $sql = "SELECT * FROM supply_inventory WHERE supply_item_id = ?";
	    $query = $this->db->query($sql, array($supply_item_id));
	    $current = $query->row_array();

	    // Handle image update (if new image is provided)
	    $file_path = null;
	    if (!empty($supply_item_image_b64)) {
	        $image_parts = explode(";base64,", $supply_item_image_b64);
	        if (count($image_parts) == 2) {
	            $image_base64 = base64_decode($image_parts[1]);
	            $file_name = $supply_item_image_name;
	            $upload_path = FCPATH . 'photos/supply_images/';

	            if (!is_dir($upload_path)) {
	                mkdir($upload_path, 0755, true);
	            }

	            file_put_contents($upload_path . $file_name, $image_base64);
	            $supply_item_image_name = $file_name;
	            $file_path = 'photos/supply_images/' . $file_name;
	        }
	    }

	    // Prepare update query (with or without image)
	    if ($file_path) {
	        $sql = "UPDATE supply_inventory 
	                   SET supply_item_name=?, supply_item_price=?, supply_item_unit=?, supply_item_stock=?, supply_item_low=?, supply_item_image=? 
	                 WHERE supply_item_id=?";
	        $update_query = $this->db->query($sql, array($supply_item_name, $supply_item_price, $supply_item_unit, $supply_item_stock, $supply_item_low, $supply_item_image_name, $supply_item_id));
	    } else {
	        $sql = "UPDATE supply_inventory 
	                   SET supply_item_name=?, supply_item_price=?, supply_item_unit=?, supply_item_stock=?, supply_item_low=? 
	                 WHERE supply_item_id=?";
	        $update_query = $this->db->query($sql, array($supply_item_name, $supply_item_price, $supply_item_unit, $supply_item_stock, $supply_item_low, $supply_item_id));
	    }

	    // Track what changed
	    $changed = array();
	    if ($current['supply_item_name'] != $supply_item_name) $changed[] = 'Item Name';
	    if ($current['supply_item_price'] != $supply_item_price) $changed[] = 'Item Price';
	    if ($current['supply_item_unit'] != $supply_item_unit) $changed[] = 'Item Unit';
	    if ($current['supply_item_stock'] != $supply_item_stock) $changed[] = 'Current Stock';
	    if ($current['supply_item_low'] != $supply_item_low) $changed[] = 'Low Stock Level';
	    if ($file_path && $current['supply_item_image'] != $supply_item_image_name) $changed[] = 'Item Image';

	    // Respond and log
	    if ($update_query) {
	        echo "success";
	        if (!empty($changed)) {
	        	$activity_type = "Item Updating";
	        	$supply_code = "Item ID: ". $supply_item_id;
	            $activity = "<strong>Updated:</strong><br>" . implode(', ', $changed);
	            $sql = "INSERT INTO supply_logs (supply_activity_type, supply_code, supply_activity) VALUES (?, ?, ?)";
	        	$this->db->query($sql, [$activity_type, $supply_code, $activity]);
	        }
	    } else {
	        echo "error";
	    }
	}

	public function supply_checkout(){
	    date_default_timezone_set('Asia/Manila');
	    $current_date = date('Y-m-d H:i:s');

	    // Generate unique checkout code
	    $random_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
	    $supply_checkout_code = 'SPL-' . date('Ymd') . '-' . $random_code;

	    // Retrieve POSted cart data
	    $cart_items = $this->input->post('cart_items');
	    if (is_string($cart_items)) {
	        $cart_items = json_decode($cart_items, true);
	    }
	    
	    if (empty($cart_items) || !is_array($cart_items)) {
	        echo "empty_cart";
	        return;
	    }

	    $checked_out_items = [];
	    $failed = false; // <-- final status tracker

	    foreach ($cart_items as $item) {
	        $supply_item_id        = $item['supply_item_id'];
	        $supply_item_name      = $item['supply_item_name'];
	        $supply_item_price     = $item['supply_item_price'];
	        $supply_item_count     = $item['item_count'];
	        $supply_item_unit      = $item['supply_item_unit'];
	        $supply_item_image     = $item['supply_item_image'];
	        $supply_item_subtotal  = $item['total_item_price'];

	        // Insert checkout item
	        $sql = "INSERT INTO supply_checkouts 
	                (supply_checkout_code, supply_item_id, supply_item_name, supply_item_price, supply_item_count, supply_item_unit, supply_item_image, supply_item_subtotal, supply_checkout_date)
	                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

	        $insert_query = $this->db->query($sql, [
	            $supply_checkout_code,
	            $supply_item_id,
	            $supply_item_name,
	            $supply_item_price,
	            $supply_item_count,
	            $supply_item_unit,
	            $supply_item_image,
	            $supply_item_subtotal,
	            $current_date
	        ]);

	        if (!$insert_query) {
	            $failed = true;
	            continue; // skip stock update for this item
	        }

	        // Update inventory
	        $sql = "UPDATE supply_inventory 
	                SET supply_item_stock = supply_item_stock - ? 
	                WHERE supply_item_id = ?";
	        $update_query = $this->db->query($sql, [$supply_item_count, $supply_item_id]);

	        if (!$update_query) {
	            $failed = true;
	        }

	        $checked_out_items[] = "{$supply_item_name} ({$supply_item_count} {$supply_item_unit})";
	    }

	    // Log only if at least something was processed
	    if (!empty($checked_out_items)) {
	        $activity_type = 'Checkout';
	        $activity = implode('<br>', $checked_out_items);
	        $sql = "INSERT INTO supply_logs (supply_activity_type, supply_code, supply_activity)
	                VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $supply_checkout_code, $activity]);
	    }

	    // Final output
	    echo $failed ? "error" : "success";
	}

	public function load_supply_checkout_codes(){
	    $report_type = $_POST['supply_checkouts_type'];
		$report_date = $_POST['supply_checkouts_date'];

		if ($report_type == 'daily') {
		    $sql = "
		    	SELECT 
				    c.supply_checkout_code,
				    SUM(c.supply_item_count) AS total_item_count,
				    MAX(c.supply_checkout_date) AS supply_checkout_date
				FROM supply_checkouts c
				WHERE DATE(c.supply_checkout_date) = ?
				GROUP BY c.supply_checkout_code
				ORDER BY c.supply_checkout_date DESC;
		    ";
		}
		else if ($report_type == 'monthly') {
		    $sql = "
		    	SELECT 
				    c.supply_checkout_code,
				    SUM(c.supply_item_count) AS total_item_count,
				    MAX(c.supply_checkout_date) AS supply_checkout_date
				FROM supply_checkouts c
				WHERE DATE_FORMAT(c.supply_checkout_date, '%Y-%m') = DATE_FORMAT(?, '%Y-%m')
				GROUP BY c.supply_checkout_code
				ORDER BY c.supply_checkout_date DESC;
		    ";
		}
		else if ($report_type == 'annual') {
		    $sql = "
		    	SELECT 
				    c.supply_checkout_code,
				    SUM(c.supply_item_count) AS total_item_count,
				    MAX(c.supply_checkout_date) AS supply_checkout_date
				FROM supply_checkouts c
				WHERE DATE_FORMAT(c.supply_checkout_date, '%Y') = DATE_FORMAT(?, '%Y')
				GROUP BY c.supply_checkout_code
				ORDER BY c.supply_checkout_date DESC;
		    ";
		}

		$query = $this->db->query($sql, $report_date);

		foreach ($query->result() as $row) {
		    $output_data[] = $row;
		}

		if (isset($output_data)) {
		    echo json_encode($output_data);
		} else {
		    echo json_encode('');
		}
	}

	public function load_supply_checkout()
	{
	    $supply_checkout_code = $_POST['supply_checkout_code'];

	    $sql = "
	        SELECT 
	            c.supply_checkout_id,
	            i.supply_item_image,
	            i.supply_item_name,
	            i.supply_item_price,
	            c.supply_item_count,
	            i.supply_item_unit
	        FROM 
	            supply_checkouts c,
	            supply_inventory i
	        WHERE 
	            c.supply_item_id = i.supply_item_id 
	            AND
	            supply_checkout_code = ?
	        ORDER BY supply_checkout_id DESC;
	    ";

	    $query = $this->db->query($sql, [$supply_checkout_code]);

	    foreach ($query->result() as $row) {
	        $output_data[] = $row;
	    }

	    if (isset($output_data)) {
	        echo json_encode($output_data);
	    } else {
	        echo json_encode('');
	    }
	}
	public function void_supply_checkout_item(){
	    $supply_checkout_id = $_POST['supply_checkout_id'];
	
	    $sql = "SELECT supply_item_id, supply_item_count, supply_checkout_code, supply_item_name FROM supply_checkouts WHERE supply_checkout_id = ?";
	    $select_query = $this->db->query($sql, [$supply_checkout_id]);
		foreach ($select_query->result() as $row) {
 			$supply_item_id = $row->supply_item_id;
 			$supply_item_count = $row->supply_item_count;
 			$supply_checkout_code = $row->supply_checkout_code;
 			$supply_item_name = $row->supply_item_name;
		}
        
        $sql = "UPDATE supply_inventory SET supply_item_stock = supply_item_stock + ? WHERE supply_item_id = ?";
	    $update_query = $this->db->query($sql, [$supply_item_count, $supply_item_id]);

	    if ($update_query) {
			$sql = "DELETE FROM supply_checkouts WHERE supply_checkout_id = ?";
		    $delete_query = $this->db->query($sql, [$supply_checkout_id]);	 

		    if ($delete_query) {
		    	$sql = "SELECT COUNT(*) AS total FROM supply_checkouts WHERE supply_checkout_code = ?";
				$query = $this->db->query($sql, [$supply_checkout_code]);
				$result = $query->row();
				$supply_checkout_count = $result->total;

				$activity_type = "Checkout Item Voided";
	        	$supply_code = $supply_checkout_code;
		        $activity = "
		            Voided $supply_item_name * $supply_item_count from '$supply_checkout_code'.
		        ";
		        $sql = "INSERT INTO supply_logs (supply_activity_type, supply_code, supply_activity) VALUES (?, ?, ?)";
		        $this->db->query($sql, [$activity_type, $supply_code, $activity]);

				if ($supply_checkout_count == 0) {
		    		echo "success-null";
				}
				else {
		    		echo "success";
				}
	       	}
	       	else {
	    		echo "error";
	       	}
	    }
	    else {
    		echo "error";
	    }
	}
	public function void_supply_checkout(){
	    $supply_checkout_code = $_POST['supply_checkout_code'];
	
	    $sql = "SELECT supply_item_id, supply_item_count FROM supply_checkouts WHERE supply_checkout_code = ?";
	    $select_query = $this->db->query($sql, [$supply_checkout_code]);
		foreach ($select_query->result() as $row) {
 			$supply_item_id = $row->supply_item_id;
 			$supply_item_count = $row->supply_item_count;
		
 			$sql = "UPDATE supply_inventory SET supply_item_stock = supply_item_stock + ? WHERE supply_item_id = ?";
	    	$update_query = $this->db->query($sql, [$supply_item_count, $supply_item_id]);
		}

	    if ($update_query) {
			$sql = "DELETE FROM supply_checkouts WHERE supply_checkout_code = ?";
		    $delete_query = $this->db->query($sql, [$supply_checkout_code]);	 

		    $activity_type = "Checkout Voided";
        	$supply_code = $supply_checkout_code;
	        $activity = "
	            Voided the whole checkout with code '$supply_checkout_code'.
	        ";
	        $sql = "INSERT INTO supply_logs (supply_activity_type, supply_code, supply_activity) VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $supply_code, $activity]);

		    if ($delete_query) {
	    		echo "success";
	       	}
	       	else {
	    		echo "error";
	       	}
	    }
	    else {
    		echo "error";
	    }
	}
	public function supply_restock()
	{
	    $supply_restocking_date = $_POST['supply_restocking_date'];

	    $random_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
	    $supply_restocking_code = 'STK-' . $supply_restocking_date . '-' . $random_code;

	    $supply_restocking_items = $this->input->POSt('supply_restocking_items');
	    if (is_string($supply_restocking_items)) {
	        $supply_restocking_items = json_decode($supply_restocking_items, true);
	    }

	    if (empty($supply_restocking_items) || !is_array($supply_restocking_items)) {
	        echo "empty_cart";
	        return;
	    }

	    $failed = false;
	    $restocked_items = [];

	    foreach ($supply_restocking_items as $item) {

	        $supply_item_id = $item['supply_item_id'];
	        $supply_item_count = $item['supply_item_count'];

	        // get item details
	        $sql = "SELECT supply_item_name, supply_item_unit FROM supply_inventory WHERE supply_item_id = ?";
	        $select_query = $this->db->query($sql, [$supply_item_id]);

	        if ($select_query->num_rows() == 0) {
	            $failed = true;
	            continue;
	        }

	        $row = $select_query->row();
	        $supply_item_name = $row->supply_item_name;
	        $supply_item_unit = $row->supply_item_unit;

	        // insert restocking record
	        $sql = "INSERT INTO supply_restocking
	                (supply_restocking_code, supply_item_id, supply_item_count, supply_restocking_date)
	                VALUES (?, ?, ?, ?)";

	        $insert_query = $this->db->query($sql, [
	            $supply_restocking_code,
	            $supply_item_id,
	            $supply_item_count,
	            $supply_restocking_date
	        ]);

	        if (!$insert_query) {
	            $failed = true;
	            continue;
	        }

	        // update stock
	        $sql = "UPDATE supply_inventory SET supply_item_stock = supply_item_stock + ? WHERE supply_item_id = ?";
	        $update_query = $this->db->query($sql, [$supply_item_count, $supply_item_id]);

	        if ($update_query) {
	            $restocked_items[] = "{$supply_item_name} ({$supply_item_count} {$supply_item_unit})";
	        } else {
	            $failed = true;
	        }
	    }

	    // insert one log AFTER all items
	    if (!empty($restocked_items)) {
			$activity_type = 'Restocking';
	        $activity = implode('<br>', $restocked_items);
	        $sql = "INSERT INTO supply_logs (supply_activity_type, supply_code, supply_activity) VALUES (?, ?, ?)";
	        $this->db->query($sql, [$activity_type, $supply_restocking_code, $activity]);
	    }

	    echo $failed ? "error" : "success";
	}
	public function load_supply_reports()
	{
	    $log_type = $_POST['supply_log_type'];
	    $log_date = $_POST['supply_log_date'];

	    if ($log_type == 'daily') {
	    	$sql = "
	    		SELECT 
				    'Checkout' AS activity_type,
				    c.supply_checkout_code AS reference_code,
				    c.supply_item_name AS item_name,
				    c.supply_item_count AS quantity,
				    c.supply_item_subtotal AS amount,
				    c.supply_item_image AS item_image,
				    c.supply_checkout_date AS log_date
				FROM supply_checkouts c
				WHERE DATE(c.supply_checkout_date) = ?

				UNION ALL

				SELECT 
				    'Restock' AS activity_type,
				    r.supply_restocking_code AS reference_code,
				    i.supply_item_name AS item_name,
				    r.supply_item_count AS quantity,
				    NULL AS amount,
				    i.supply_item_image AS item_image,
				    r.supply_restocking_timestamp AS log_date
				FROM supply_restocking r
				JOIN supply_inventory i ON r.supply_item_id = i.supply_item_id
				WHERE DATE(r.supply_restocking_timestamp) = ?

				ORDER BY log_date DESC;
	    	";
	    }
	    else if ($log_type == 'monthly') {
	    	$sql = "
	    		SELECT 
				    'Checkout' AS activity_type,
				    c.supply_checkout_code AS reference_code,
				    c.supply_item_name AS item_name,
				    c.supply_item_count AS quantity,
				    c.supply_item_subtotal AS amount,
				    c.supply_item_image AS item_image,
				    c.supply_checkout_date AS log_date
				FROM supply_checkouts c
				WHERE MONTH(c.supply_checkout_date) = MONTH(?)

				UNION ALL

				SELECT 
				    'Restock' AS activity_type,
				    r.supply_restocking_code AS reference_code,
				    i.supply_item_name AS item_name,
				    r.supply_item_count AS quantity,
				    NULL AS amount,
				    i.supply_item_image AS item_image,
				    r.supply_restocking_timestamp AS log_date
				FROM supply_restocking r
				JOIN supply_inventory i ON r.supply_item_id = i.supply_item_id
				WHERE MONTH(r.supply_restocking_timestamp) = MONTH(?)

				ORDER BY log_date DESC;
	    	";
	    }
	    else if ($log_type == 'annual') {
	    	$sql = "
	    		SELECT 
				    'Checkout' AS activity_type,
				    c.supply_checkout_code AS reference_code,
				    c.supply_item_name AS item_name,
				    c.supply_item_count AS quantity,
				    c.supply_item_subtotal AS amount,
				    c.supply_item_image AS item_image,
				    c.supply_checkout_date AS log_date
				FROM supply_checkouts c
				WHERE YEAR(c.supply_checkout_date) = YEAR(?)

				UNION ALL

				SELECT 
				    'Restock' AS activity_type,
				    r.supply_restocking_code AS reference_code,
				    i.supply_item_name AS item_name,
				    r.supply_item_count AS quantity,
				    NULL AS amount,
				    i.supply_item_image AS item_image,
				    r.supply_restocking_timestamp AS log_date
				FROM supply_restocking r
				JOIN supply_inventory i ON r.supply_item_id = i.supply_item_id
				WHERE YEAR(r.supply_restocking_timestamp) = YEAR(?)

				ORDER BY log_date DESC;
	    	";
	    }
		$query = $this->db->query($sql, [$log_date, $log_date]);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function load_supply_logs()
	{
	    $log_type = $_POST['supply_log_type'];
	    $log_date = $_POST['supply_log_date'];

	    if ($log_type == 'daily') {
	        $sql = "
	            SELECT *
	            FROM supply_logs
	            WHERE DATE(timestamp) = ?
	            ORDER BY supply_log_id ASC
	        ";
	    }
	    else if ($log_type == 'monthly') {
	        $sql = "
	            SELECT *
	            FROM supply_logs
	            WHERE DATE_FORMAT(timestamp, '%Y-%m') = DATE_FORMAT(?, '%Y-%m')
	            ORDER BY supply_log_id ASC
	        ";
	    }
	    else if ($log_type == 'annual') {
	        $sql = "
	            SELECT *
	            FROM supply_logs
	            WHERE YEAR(timestamp) = YEAR(?)
	            ORDER BY supply_log_id ASC
	        ";
	    }

	    $query = $this->db->query($sql, [$log_date]);

	    foreach ($query->result() as $row) {
	        $output_data[] = $row;
	    }

	    if (isset($output_data)) {
	        echo json_encode($output_data);
	    } else {
	        echo json_encode('');
	    }
	}
	public function load_supply_restocking_codes()
	{
	    $report_type = $_POST['supply_restocking_report_type'];
	    $report_date = $_POST['supply_restocking_report_date'];

	    if ($report_type == 'daily') {
	    	$sql = "
	    		SELECT 
				    r.supply_restocking_code,
				    SUM(r.supply_item_count) AS total_item_count,
				    MAX(r.supply_restocking_date) AS supply_restocking_date,
				    MAX(r.supply_restocking_timestamp) AS supply_restocking_timestamp
				FROM supply_restocking r
				WHERE DATE(r.supply_restocking_date) = ?
				GROUP BY r.supply_restocking_code
				ORDER BY r.supply_restocking_timestamp DESC;
	    	";
	    }
	    else if ($report_type == 'monthly') {
	    	$sql = "
	    		SELECT 
				    r.supply_restocking_code,
				    SUM(r.supply_item_count) AS total_item_count,
				    MAX(r.supply_restocking_date) AS supply_restocking_date,
				    MAX(r.supply_restocking_timestamp) AS supply_restocking_timestamp
				FROM supply_restocking r
				WHERE MONTH(r.supply_restocking_date) = MONTH(?)
				GROUP BY r.supply_restocking_code
				ORDER BY r.supply_restocking_timestamp DESC;
	    	";
	    }
	    else if ($report_type == 'annual') {
	    	$sql = "
	    		SELECT 
				    r.supply_restocking_code,
				    SUM(r.supply_item_count) AS total_item_count,
				    MAX(r.supply_restocking_date) AS supply_restocking_date,
				    MAX(r.supply_restocking_timestamp) AS supply_restocking_timestamp
				FROM supply_restocking r
				WHERE YEAR(r.supply_restocking_date) = YEAR(?)
				GROUP BY r.supply_restocking_code
				ORDER BY r.supply_restocking_timestamp DESC;
	    	";
	    }
		$query = $this->db->query($sql, [$report_date]);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}

	public function load_supply_restocking()
	{
	    $supply_restocking_code = $_POST['supply_restocking_code'];
    	$sql = "
    		SELECT 
			    r.supply_restocking_id,
			    i.supply_item_image,
			    i.supply_item_name,
			    i.supply_item_price,
			    r.supply_item_count,
			    i.supply_item_unit
			FROM 
				supply_restocking r, 
				supply_inventory i
			WHERE 
				r.supply_item_id = i.supply_item_id 
				AND
				supply_restocking_code = ?
			ORDER BY supply_restocking_id DESC;
    	";
		$query = $this->db->query($sql, [$supply_restocking_code]);
		foreach ($query->result() as $row) {
 			$output_data[] = $row;
		}
		if (isset($output_data)) {
			echo json_encode($output_data);	
		}
		else {
			echo json_encode('');
		}
	}
	public function void_supply_restocking_item(){
	    $supply_restocking_id = $_supplyT['supply_restocking_id'];
	
	    $sql = "SELECT supply_inventory.supply_item_id, supply_item_count, supply_restocking_code, supply_item_name FROM supply_restocking, supply_inventory WHERE supply_restocking.supply_item_id = supply_inventory.supply_item_id AND supply_restocking_id = ?";
	    $select_query = $this->db->query($sql, [$supply_restocking_id]);
		foreach ($select_query->result() as $row) {
 			$supply_item_id = $row->supply_item_id;
 			$supply_item_count = $row->supply_item_count;
 			$supply_restocking_code = $row->supply_restocking_code;
 			$supply_item_name = $row->supply_item_name;
		}
        
        $sql = "UPDATE supply_inventory SET supply_item_stock = supply_item_stock - ? WHERE supply_item_id = ?";
	    $update_query = $this->db->query($sql, [$supply_item_count, $supply_item_id]);

	    if ($update_query) {
			$sql = "DELETE FROM supply_restocking WHERE supply_restocking_id = ?";
		    $delete_query = $this->db->query($sql, [$supply_restocking_id]);	 

		    if ($delete_query) {
		    	$sql = "SELECT COUNT(*) AS total FROM supply_restocking WHERE supply_restocking_code = ?";
				$query = $this->db->query($sql, [$supply_restocking_code]);
				$result = $query->row();
				$supply_restocking_count = $result->total;

				$activity_type = "Restock Item Voided";
	        	$supply_code = $supply_restocking_code;
		        $activity = "
		            Voided $supply_item_name * $supply_item_count from '$supply_restocking_code'.
		        ";
		        $sql = "INSERT INTO supply_logs (supply_activity_type, supply_code, supply_activity) VALUES (?, ?, ?)";
		        $this->db->query($sql, [$activity_type, $supply_code, $activity]);

				if ($supply_restocking_count == 0) {
		    		echo "success-null";
				}
				else {
		    		echo "success";
				}
	       	}
	       	else {
	    		echo "error";
	       	}
	    }
	    else {
    		echo "error";
	    }
	}
	public function void_supply_restocking(){
	    $supply_restocking_code = $_supplyT['supply_restocking_code'];
	
	    $sql = "SELECT supply_item_id, supply_item_count FROM supply_restocking WHERE supply_restocking_code = ?";
	    $select_query = $this->db->query($sql, [$supply_restocking_code]);
		foreach ($select_query->result() as $row) {
 			$supply_item_id = $row->supply_item_id;
 			$supply_item_count = $row->supply_item_count;
		
 			$sql = "UPDATE supply_inventory SET supply_item_stock = supply_item_stock - ? WHERE supply_item_id = ?";
	    	$update_query = $this->db->query($sql, [$supply_item_count, $supply_item_id]);
		}

	    if ($update_query) {
			$sql = "DELETE FROM supply_restocking WHERE supply_restocking_code = ?";
		    $delete_query = $this->db->query($sql, [$supply_restocking_code]);	 

		    if ($delete_query) {
		        $activity_type = "Restock Voided";
	        	$supply_code = $supply_restocking_code;
		        $activity = "
		            Voided the whole restocking with code '$supply_restocking_code'.
		        ";
		        $sql = "INSERT INTO supply_logs (supply_activity_type, supply_code, supply_activity) VALUES (?, ?, ?)";
		        $this->db->query($sql, [$activity_type, $supply_code, $activity]);
	    		echo "success";
	       	}
	       	else {
	    		echo "error";
	       	}
	    }
	    else {
    		echo "error";
	    }
	}

	public function shadow() {
		global $top_shadow;
		global $bottom_shadow;

		$top_shadow = array	('0' => "a",	'1' => "b",	'2' => "c",	'3' => "d",	'4' => "e",	'5' => "f",	'6' => "g",	'7' => "h",	'8' => "i",	'9' => "j", '10' => "k", '11' => "l", '12' => "m", '13' => "n", '14' => "o", '15' => "p", '16' => "q", '17' => "r", '18' => "s", '19' => "t", '20' => "u", '21' => "v", '22' => "w", '23' => "x", '24' => "y", '25' => "z", '26' => "1",'27' => "2", '28' => "3", '29' => "4", '30' => "5", '31' => "6", '32' => "7", '33' => "8", '34' => "9",'35' => "0", '36' => "!", '37' => '"', '38' => "£", '39' => "$", '40' => "%", '41' => "^", '42' => "&", '43' => "*", '44' => "(", '45' => ")",'46' => "_", '47' => "-", '48' => "+", '49' => "=", '50' => ":", '51' => ";",'52' => "@", '53' => "'", '54' => "<", '55' => ",",'56' => ">", '57' => "/", '58' => "?", '59' => ".", '60' => "{", '61' => "[", '62' => "}", '63' => "]", '64' => "~", '65' => "#", '66' => "\\",'67' => "¬",'68' => "`",'69' => "A",'70' => "B",'71' => "C", '72' => "D", '73' => "E", '74' => "F", '75' => "G", '76' => "H", '77' => "I", '78' => "J", '79' => "K", '80' => "L", '81' => "M", '82' => "N", '83' => "O", '84' => "P", '85' => "Q", '86' => "R", '87' => "S", '88' => "T", '89' => "U", '90' => "V", '91' => "W", '92' => "X", '93' => "Y", '94' => "Z", '95' => " "
		);
		$bottom_shadow = array('0' => "1x", '1' => "a9", '2' => "q5", '3' => "K5", '4' => "87", '5' => "jk", '6' => "p1", '7' => "0x", '8' => "xl", '9' => "p8",'10' => "la",'11' => "mj",'12' => "t1",'13' => "9g",'14' => "kp",'15' => "41",'16' => "9b",'17' => "7k",'18' => "bc",'19' => "mX",'20' => "z9",'21' => "gh",'22' => "f7",'23' => "h8",'24' => "a6",'25' => "j1",'26' => "uj",'27' => "hl",'28' => "0j",'29' => "6y",'30' => "k1",'31' => "ap",'32' => "fg",'33' => "jN",'34' => "0k",'35' => "1j",'36' => "0u",'37' => "2j",'38' => "j7",'39' => "7s",'40' => "O2",'41' => "j9",'42' => "mN",'43' => "0o",'44' => "l2",'45' => "uV",'46' => "fH",'47' => "63",'48' => "y7",'49' => "bm",'50' => "aA",'51' => "hj",'52' => "77",'53' => "k3",'54' => "po",'55' => "78",'56' => "bh",'57' => "vk",'58' => "uA",'59' => "02",'60' => "5t",'61' => "8u",'62' => "90",'63' => "lq",'64' => "tu",'65' => "60",'66' => "ak",'67' => "09",'68' => "67",'69' => "hi",'70' => "yr",'71' => "Jf",'72' => "9j",'73' => "7h",'74' => "bu",'75' => "ln",'76' => "g2",'77' => "91",'78' => "b7",'79' => "iO",'80' => "Rh",'81' => "08",'82' => "7g",'83' => "jO",'84' => "uy",'85' => "0y",'86' => "9U",'87' => "lK",'88' => "p4",'89' => "jg",'90' => "ho",'91' => "jv",'92' => "bk",'93' => "0d",'94' => "Ih",'95' => "Xa"
		);

		function encrypt($str) {
			global $top_shadow;
			global $bottom_shadow;

			$str_pass = $str;
			$length = strlen($str);
			$content_holder = '';
			$content_accumulator = '';
			for ($i=0; $i < $length; $i++) {
				$component = $str_pass[$i];
				$array_length = count($top_shadow);
				for ($x=0; $x < $array_length; $x++) { 
					if ($component == $top_shadow[$x]) {
						$content_holder = $bottom_shadow[$x];
					}
				}
				$content_accumulator = $content_accumulator.$content_holder;
			}
			return $content_accumulator;
		}
		function decrypt($str) {
			global $top_shadow;
			global $bottom_shadow;

			$str_pass = $str;
			$length = strlen($str);
			$length = $length/2;
			$content_holder = '';
			$content_accumulator = '';
			for ($i=0; $i < $length; $i++) {
				if ($i == 0) {
					$y = $i;
				}
				else {
					$y = $y + 2;
				}
				$component = substr($str_pass, $y, 2);
				$array_length = count($top_shadow);
				for ($x=0; $x < $array_length; $x++) { 
					if ($component == $bottom_shadow[$x]) {
						$content_holder = $top_shadow[$x];
					}
				}
				$content_accumulator = $content_accumulator.$content_holder;
			}

			return $content_accumulator;
		}
	}
}