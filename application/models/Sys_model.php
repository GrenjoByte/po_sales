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

	    $sql     = "SELECT user_id, username, password FROM user_accounts WHERE username = ?";
	    $query   = $this->db->query($sql, [$username]);
	    $account = $query->row();

	    $password_valid = false;

	    if ($account) {
	        if (password_verify($password, $account->password)) {
	            $password_valid = true;
	        } elseif ($password === $account->password) {
	            $password_valid = true;
	            $new_hash = password_hash($password, PASSWORD_DEFAULT);
	            $this->db->query(
	                "UPDATE user_accounts SET password = ? WHERE user_id = ?",
	                [$new_hash, $account->user_id]
	            );
	        }
	    }

	    if ($account && $password_valid) {
	        $user_id = $account->user_id;

	        $sql   = "SELECT first_name, last_name, gender, user_type, user_status FROM user_info WHERE user_id = ?";
	        $query = $this->db->query($sql, [$user_id]);
	        $user  = $query->row();

	        if ($user) {
	            if ($user->user_status == 0) {
	                $attempt_response = [
	                    'status'  => 'inactive',
	                    'message' => 'Account is inactive'
	                ];
	            } else {
	                // Determine redirect based on user type
	                switch ((int) $user->user_type) {
	                    case 8: // Superadmin — access all
	                        $redirect = 'inventory';
	                        break;
	                    case 1: // Inventory admin
	                        $redirect = 'inventory';
	                        break;
	                    case 2: // Sales / cashier
	                        $redirect = 'sales';
	                        break;
	                    default:
	                        $redirect = 'login';
	                        break;
	                }

	                // Core identity
	                $_SESSION['active_user']      = $user_id;
	                $_SESSION['active_username']  = $account->username;
	                $_SESSION['active_user_type'] = (int) $user->user_type;
	                $_SESSION['active_status']    = $user->user_status;

	                // Display info
	                $_SESSION['active_first_name'] = $user->first_name;
	                $_SESSION['active_last_name']  = $user->last_name;
	                $_SESSION['active_gender']     = $user->gender;
	                $_SESSION['active_full_name']  = trim($user->first_name . ' ' . $user->last_name);

	                // Security
	                $_SESSION['session_token']   = bin2hex(random_bytes(32));
	                $_SESSION['session_started'] = time();
	                $_SESSION['session_ip']      = $_SERVER['REMOTE_ADDR'];
	                $_SESSION['session_ua']      = $_SERVER['HTTP_USER_AGENT'];

	                $attempt_response = [
	                    'status'    => 'success',
	                    'user_type' => $user->user_type,
	                    'last_name' => $user->last_name,
	                    'gender'    => $user->gender,
	                    'redirect'  => $redirect
	                ];
	            }
	        } else {
	            $attempt_response = [
	                'status'  => 'error',
	                'message' => 'User info not found'
	            ];
	        }
	    } else {
	        $attempt_response = [
	            'status'  => 'error',
	            'message' => 'Invalid username or password'
	        ];
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
	    $this->flag_db_change();
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
	    $this->flag_db_change();
	    exit;
	}
	public function delete_pos_item()
	{
	    header('Content-Type: application/json');
	    $pos_item_id = $this->input->post('pos_item_id', true);
	    if (empty($pos_item_id)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid item ID']);
	        return;
	    }
	    $item = $this->db->query(
	        "SELECT pos_item_name FROM pos_inventory WHERE pos_item_id = ?",
	        [$pos_item_id]
	    )->row();
	    if (!$item) {
	        echo json_encode(['status' => 'error', 'message' => 'Item not found']);
	        return;
	    }
	    // Soft delete — set status to 0
	    $this->db->query(
	        "UPDATE pos_inventory SET pos_item_status = 0 WHERE pos_item_id = ?",
	        [$pos_item_id]
	    );
	    if ($this->db->affected_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'No changes made']);
	        return;
	    }
	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Item Deletion',
	            'Item ID: ' . $pos_item_id,
	            '<strong>Deleted Item:</strong><br>' . $item->pos_item_name
	        ]
	    );
	    echo json_encode(['status' => 'success', 'message' => 'Item deleted']);
	    exit;
	}
	public function load_manage_items()
	{
	    header('Content-Type: application/json');
	    $data = $this->db->query(
	        "SELECT pos_item_id, pos_item_name, pos_item_code, pos_item_price,
	                pos_item_stock, pos_item_unit, pos_item_low
	         FROM pos_inventory
	         WHERE pos_item_status = 0
	         ORDER BY pos_item_name ASC"
	    )->result_array();
	    echo json_encode(['status' => 'success', 'data' => $data]);
	    exit;
	}

	public function restore_pos_item()
	{
	    header('Content-Type: application/json');
	    $pos_item_id = $this->input->post('pos_item_id', true);
	    if (empty($pos_item_id)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid item ID']);
	        return;
	    }
	    $item = $this->db->query(
	        "SELECT pos_item_name FROM pos_inventory WHERE pos_item_id = ?",
	        [$pos_item_id]
	    )->row();
	    if (!$item) {
	        echo json_encode(['status' => 'error', 'message' => 'Item not found']);
	        return;
	    }
	    $this->db->query(
	        "UPDATE pos_inventory SET pos_item_status = 1 WHERE pos_item_id = ?",
	        [$pos_item_id]
	    );
	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Item Restore',
	            'Item ID: ' . $pos_item_id,
	            '<strong>Restored Item:</strong><br>' . $item->pos_item_name
	        ]
	    );
	    echo json_encode(['status' => 'success', 'message' => 'Item restored']);
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
	    $this->flag_db_change();
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
	    $this->flag_db_change();
	    exit;
	}
	public function process_restocking()
	{
	    $pos_restocking_date = $_POST['pos_restocking_date'];
	    $items = json_decode($_POST['items'], true);
	    header('Content-Type: application/json');
	    if (empty($items)) {
	        echo json_encode([
	            'status'  => 'error',
	            'message' => 'No items to restock'
	        ]);
	        exit;
	    }
	    $this->db->trans_start();
	    // Generate restocking code: R{sequence}_{MM}_{YYYY}
	    $month = date('m');
	    $year  = date('Y');
	    $sql   = "SELECT IFNULL(MAX(CAST(SUBSTRING_INDEX(SUBSTRING(pos_restocking_code, 2), '_', 1) AS UNSIGNED)), 0) + 1 AS next_seq
	              FROM pos_restocking
	              WHERE pos_restocking_code LIKE ?";
	    $next_seq            = $this->db->query($sql, ["R%_{$month}_{$year}"])->row()->next_seq;
	    $pos_restocking_code = 'R' . str_pad($next_seq, 2, '0', STR_PAD_LEFT) . "_{$month}_{$year}";
	    foreach ($items as $item) {
	        $total = $item['pos_item_price'] * $item['pos_item_quantity'];
		    $item_check = $this->db->query(
		        "SELECT pos_item_status FROM pos_inventory WHERE pos_item_id = ?",
		        [$item['pos_item_id']]
		    )->row();
		    if (!$item_check || $item_check->pos_item_status != 1) {
		        $this->db->trans_rollback();
		        echo json_encode(['status' => 'error', 'message' => "Item '{$item['pos_item_name']}' is archived and cannot be restocked."]);
		        $this->flag_db_change();
		        exit;
		    }
	        $this->db->query(
	            "INSERT INTO pos_restocking 
	             (pos_restocking_code, pos_item_id, pos_item_code, pos_item_name, 
	              pos_item_price, pos_item_quantity, pos_item_unit, pos_restocking_total, pos_restocking_date)
	             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
	            [
	                $pos_restocking_code,
	                $item['pos_item_id'],
	                $item['pos_item_code'],
	                $item['pos_item_name'],
	                $item['pos_item_price'],
	                $item['pos_item_quantity'],
	                $item['pos_item_unit'],
	                $total,
	                $pos_restocking_date
	            ]
	        );
	        $this->db->query(
	            "UPDATE pos_inventory 
	             SET pos_item_stock = pos_item_stock + ?
	             WHERE pos_item_id = ?",
	            [$item['pos_item_quantity'], $item['pos_item_id']]
	        );
	        $this->db->query(
	            "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) 
	             VALUES (?, ?, ?)",
	            [
	                "Restocking",
	                $pos_restocking_code,
	                "<strong>Restocked:</strong><br>" . $item['pos_item_name']
	                    . " (+" . $item['pos_item_quantity'] . " " . $item['pos_item_unit'] . ")"
	            ]
	        );
	    }
	    $this->db->trans_complete();
	    if ($this->db->trans_status() === FALSE) {
	        echo json_encode([
	            'status'  => 'error',
	            'message' => 'Restocking failed (rolled back)'
	        ]);
	    } else {
	        echo json_encode([
	            'status'             => 'success',
	            'message'            => 'Restocking completed successfully',
	            'pos_restocking_code' => $pos_restocking_code
	        ]);
	    }
	    $this->flag_db_change();
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
	                pos_restocking_date,
	                pos_restocking_status
	            FROM pos_restocking";

	    if (!empty($report_date)) {
	        $sql .= " WHERE DATE(pos_restocking_date) = ?";
	        $params[] = $report_date;
	    }

	    $sql .= " ORDER BY pos_restocking_date DESC";

	    $query = $this->db->query($sql, $params);
	    $data        = [];
	    $grand_total = 0;

	    foreach ($query->result() as $row) {
	        if ($row->pos_restocking_status == 1) {
	            $grand_total += $row->pos_restocking_total;
	        }
	        $data[] = [
	            'pos_item_id'            => $row->pos_item_id,
	            'pos_restocking_code'    => $row->pos_restocking_code,
	            'pos_item_code'          => $row->pos_item_code,
	            'pos_item_name'          => $row->pos_item_name,
	            'pos_item_price'         => $row->pos_item_price,
	            'pos_item_quantity'      => $row->pos_item_quantity,
	            'pos_item_unit'          => $row->pos_item_unit,
	            'pos_restocking_total'   => $row->pos_restocking_total,
	            'pos_restocking_date'    => $row->pos_restocking_date,
	            'pos_restocking_status'  => $row->pos_restocking_status
	        ];
	    }

	    echo json_encode([
	        'status'      => 'success',
	        'data'        => $data,
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
		    AND i.pos_item_status = 1
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
	    foreach ($items as $item) {
		    $gross_price     = $item['pos_item_price'];
		    $qty             = $item['pos_item_quantity'];
		    $gross_total     = $gross_price * $qty;
		    $discount_amount = $gross_total * $discount_rate;
		    $final_total     = $gross_total - $discount_amount;

			$item_check = $this->db->query(
			    "SELECT pos_item_status FROM pos_inventory WHERE pos_item_id = ?",
			    [$item['pos_item_id']]
			)->row();

			if (!$item_check || $item_check->pos_item_status != 1) {
			    $this->db->trans_rollback();
			    echo json_encode(['status' => 'error', 'message' => "Item '{$item['pos_item_name']}' is no longer available."]);
			    exit;
			}

		    $this->db->query(
		        "INSERT INTO pos_checkouts 
		        (user_id, 
		         pos_checkout_code, 
		         pos_item_id, 
		         pos_item_code, 
		         pos_item_name,
		         pos_item_price, 
		         pos_item_quantity, 
		         pos_item_unit, 
		         pos_checkout_subtotal,
		         pos_discount_type, 
		         pos_discount_value,
		         pos_checkout_total,
		         pos_checkout_date, 
		         pos_checkout_status
		        )
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)",
		        [
		            $user_id,
		            $sale_code,
		            $item['pos_item_id'],
		            $item['pos_item_code'],
		            $item['pos_item_name'],
		            $gross_price,
		            $qty,
		            $item['pos_item_unit'],
		            $gross_total,
		            $discount_type,
		            $discount_rate,
		            $final_total
		        ]
		    );

		    $this->db->query(
		        "UPDATE pos_inventory 
		         SET pos_item_stock = pos_item_stock - ? 
		         WHERE pos_item_id = ?",
		        [$qty, $item['pos_item_id']]
		    );

		    $item_lines[] = $item['pos_item_name'] . ' (x' . $qty . ' ' . $item['pos_item_unit'] . ')';
		}

		$this->db->query(
		    "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
		    [
		        'Sale',
		        $sale_code,
		        '<strong>Sale processed:</strong><br>'
		            . implode('<br>', $item_lines)
		            . ($discount_rate > 0 ? '<br><em>Discount: ' . ($discount_rate * 100) . '% (' . $discount_type . ')</em>' : '')
		    ]
		);
	    $this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
		    echo json_encode(['status' => 'error', 'message' => 'Sale failed (rolled back)']);
		    exit; // stop here, don't flag
		}

		$this->flag_db_change();
		echo json_encode([
		    'status'    => 'success',
		    'sale_code' => $sale_code
		]);
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
	            COUNT(DISTINCT CASE WHEN pc.pos_checkout_status != 2 THEN pc.pos_item_id END) AS total_items,
	            SUM(CASE WHEN pc.pos_checkout_status != 2 THEN pc.pos_item_quantity ELSE 0 END) AS total_quantity,
	            IFNULL(MAX(CASE WHEN pc.pos_checkout_status != 2 THEN pc.pos_discount_value END), 0) AS pos_discount_value,
	            SUM(CASE WHEN pc.pos_checkout_status != 2 THEN pc.pos_checkout_subtotal ELSE 0 END) AS pos_checkout_subtotal,
	            SUM(CASE WHEN pc.pos_checkout_status != 2 THEN pc.pos_checkout_total ELSE 0 END) AS pos_checkout_total,
	            MAX(pc.pos_checkout_status) AS pos_checkout_status,
	            MAX(pc.pos_checkout_date) AS pos_checkout_date,
	            SUM(CASE WHEN pc.pos_checkout_status = 2 THEN 1 ELSE 0 END) AS voided_count,
	            COUNT(*) AS total_count,
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
	    $pos_item_id         = $this->input->post('pos_item_id', true);
	    $pos_restocking_code = $this->input->post('pos_restocking_code', true);

	    if (empty($pos_item_id) || empty($pos_restocking_code)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
	        return;
	    }

	    $sql = "SELECT pos_item_id, pos_item_name, pos_item_quantity, pos_item_unit, pos_restocking_status 
	            FROM pos_restocking 
	            WHERE pos_item_id = ? AND pos_restocking_code = ?";
	    $query = $this->db->query($sql, [$pos_item_id, $pos_restocking_code]);

	    if ($query->num_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Record not found']);
	        return;
	    }

	    $row = $query->row();

	    if ($row->pos_restocking_status == 2) {
	        echo json_encode(['status' => 'error', 'message' => 'Already voided']);
	        return;
	    }

	    $current = $this->db->query(
		    "SELECT pos_item_stock FROM pos_inventory WHERE pos_item_id = ?",
		    [$row->pos_item_id]
		)->row();

		if ($current->pos_item_stock < $row->pos_item_quantity) {
		    echo json_encode([
		        'status'  => 'error',
		        'message' => "Cannot void — current stock ({$current->pos_item_stock}) is less than the restocked quantity ({$row->pos_item_quantity}). Some items may have already been sold."
		    ]);
		    return;
		}

	    $sql = "UPDATE pos_restocking 
	            SET pos_restocking_status = 2 
	            WHERE pos_item_id = ? AND pos_restocking_code = ? AND pos_restocking_status = 1";
	    $this->db->query($sql, [$pos_item_id, $pos_restocking_code]);

	    if ($this->db->affected_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'No changes made']);
	        return;
	    }

	    $sql = "UPDATE pos_inventory 
	            SET pos_item_stock = pos_item_stock - ? 
	            WHERE pos_item_id = ?";
	    $this->db->query($sql, [$row->pos_item_quantity, $row->pos_item_id]);

	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Restocking Void',
	            'Item ID: ' . $row->pos_item_id,
	            '<strong>Voided Restocking:</strong><br>'
	                . $row->pos_item_name
	                . ' (-' . $row->pos_item_quantity . ' ' . $row->pos_item_unit . ')'
	                . ' [Code: ' . $pos_restocking_code . ']'
	        ]
	    );

	    echo json_encode(['status' => 'success', 'message' => 'Restocking voided']);
	    $this->flag_db_change();
	    exit;
	}
	public function restore_pos_restocking()
	{
	    header('Content-Type: application/json');
	    $pos_item_id         = $this->input->post('pos_item_id', true);
	    $pos_restocking_code = $this->input->post('pos_restocking_code', true);

	    if (empty($pos_item_id) || empty($pos_restocking_code)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
	        return;
	    }

	    $row = $this->db->query(
	        "SELECT pos_item_id, pos_item_name, pos_item_quantity, pos_item_unit, pos_restocking_status
	         FROM pos_restocking
	         WHERE pos_item_id = ? AND pos_restocking_code = ?",
	        [$pos_item_id, $pos_restocking_code]
	    )->row();

	    if (!$row) {
	        echo json_encode(['status' => 'error', 'message' => 'Record not found']);
	        return;
	    }

	    if ($row->pos_restocking_status != 2) {
	        echo json_encode(['status' => 'error', 'message' => 'Restocking is not voided']);
	        return;
	    }

	    $this->db->query(
	        "UPDATE pos_restocking
	         SET pos_restocking_status = 1
	         WHERE pos_item_id = ? AND pos_restocking_code = ? AND pos_restocking_status = 2",
	        [$pos_item_id, $pos_restocking_code]
	    );

	    if ($this->db->affected_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'No changes made']);
	        return;
	    }

	    // Add stock back
	    $this->db->query(
	        "UPDATE pos_inventory
	         SET pos_item_stock = pos_item_stock + ?
	         WHERE pos_item_id = ?",
	        [$row->pos_item_quantity, $row->pos_item_id]
	    );

	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Restocking Restore',
	            $pos_restocking_code,
	            '<strong>Restored Restocking:</strong><br>'
	                . $row->pos_item_name
	                . ' (+' . $row->pos_item_quantity . ' ' . $row->pos_item_unit . ')'
	                . ' [Code: ' . $pos_restocking_code . ']'
	        ]
	    );

	    echo json_encode(['status' => 'success', 'message' => 'Restocking restored']);
	    $this->flag_db_change();
	    exit;
	}
	public function load_accounts()
	{
	    header('Content-Type: application/json');
	    $sql = "SELECT a.user_id, a.username, i.first_name, i.middle_name, i.last_name,
	                   i.gender, i.email_address, i.user_type, i.user_status
	            FROM user_accounts a
	            JOIN user_info i ON a.user_id = i.user_id
	            ORDER BY i.last_name ASC, i.first_name ASC";
	    $query = $this->db->query($sql);
	    echo json_encode([
	        'status' => 'success',
	        'data'   => $query->result()
	    ]);
	}

	public function get_account()
	{
	    header('Content-Type: application/json');
	    $user_id = $this->input->post('user_id', true);
	    if (empty($user_id)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID']);
	        return;
	    }
	    $sql = "SELECT a.user_id, a.username, i.first_name, i.middle_name, i.last_name,
	                   i.gender, i.email_address, i.user_type, i.user_status
	            FROM user_accounts a
	            JOIN user_info i ON a.user_id = i.user_id
	            WHERE a.user_id = ?";
	    $query = $this->db->query($sql, [$user_id]);
	    if ($query->num_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Account not found']);
	        return;
	    }
	    echo json_encode(['status' => 'success', 'data' => $query->row()]);
	}

	public function create_account()
	{
	    header('Content-Type: application/json');

	    $first_name    = $this->input->post('first_name', true);
	    $middle_name   = $this->input->post('middle_name', true);
	    $last_name     = $this->input->post('last_name', true);
	    $gender        = $this->input->post('gender', true);
	    $email_address = $this->input->post('email_address', true);
	    $user_type     = $this->input->post('user_type', true);
	    $username      = $this->input->post('username', true);
	    $password      = $this->input->post('password', true);

	    if (!$first_name || !$last_name || !$gender || !$email_address || !$user_type || !$username || !$password) {
	        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
	        return;
	    }

	    $check_username = $this->db->query(
	        "SELECT user_id FROM user_accounts WHERE username = ?", [$username]
	    );
	    if ($check_username->num_rows() > 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Username already taken']);
	        return;
	    }

	    $check_email = $this->db->query(
	        "SELECT user_id FROM user_info WHERE email_address = ?", [$email_address]
	    );
	    if ($check_email->num_rows() > 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Email address already in use']);
	        return;
	    }

	    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

	    $this->db->trans_start();

	    $this->db->query(
	        "INSERT INTO user_info (first_name, middle_name, last_name, gender, email_address, user_type)
	         VALUES (?, ?, ?, ?, ?, ?)",
	        [$first_name, $middle_name, $last_name, $gender, $email_address, $user_type]
	    );

	    $new_user_id = $this->db->insert_id();

	    $this->db->query(
	        "INSERT INTO user_accounts (user_id, username, password) VALUES (?, ?, ?)",
	        [$new_user_id, $username, $hashed_password]
	    );

	    $this->db->trans_complete();

	    if ($this->db->trans_status() === false) {
	        echo json_encode(['status' => 'error', 'message' => 'Failed to create account']);
	        return;
	    }

	    $type_label = $user_type == 1 ? 'Admin' : 'Cashier';
	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Account Creation',
	            'User ID: ' . $new_user_id,
	            '<strong>Created Account:</strong><br>'
	                . $first_name . ' ' . $last_name
	                . ' (@' . $username . ')'
	                . ' [' . $type_label . ']'
	        ]
	    );

	    echo json_encode(['status' => 'success', 'message' => 'Account created successfully']);
	    $this->flag_db_change();
	    exit;
	}
	public function update_account()
	{
	    header('Content-Type: application/json');
	    $user_id       = $this->input->post('user_id', true);
	    $first_name    = $this->input->post('first_name', true);
	    $middle_name   = $this->input->post('middle_name', true);
	    $last_name     = $this->input->post('last_name', true);
	    $gender        = $this->input->post('gender', true);
	    $email_address = $this->input->post('email_address', true);
	    $user_type     = $this->input->post('user_type', true);
	    $user_status   = $this->input->post('user_status', true);
	    $username      = $this->input->post('username', true);
	    $password      = $this->input->post('password', true);

	    if (!$user_id || !$first_name || !$last_name || !$gender || !$email_address || !$user_type || !$username) {
	        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
	        return;
	    }

	    $check = $this->db->query(
	        "SELECT user_id FROM user_accounts WHERE username = ? AND user_id != ?",
	        [$username, $user_id]
	    );
	    if ($check->num_rows() > 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Username already taken']);
	        return;
	    }

	    $check_email = $this->db->query(
	        "SELECT user_id FROM user_info WHERE email_address = ? AND user_id != ?",
	        [$email_address, $user_id]
	    );
	    if ($check_email->num_rows() > 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Email address already in use']);
	        return;
	    }

	    // Snapshot old values for log diff
	    $old = $this->db->query(
	        "SELECT a.username, i.first_name, i.last_name, i.user_type, i.user_status
	         FROM user_accounts a JOIN user_info i ON a.user_id = i.user_id
	         WHERE a.user_id = ?",
	        [$user_id]
	    )->row();

	    // Prevent modifying superadmin status
	    if ((int) $old->user_type === 8) {
	        $user_status = $old->user_status;
	        $user_type = $old->user_type;
	    }

	    $this->db->query(
	        "UPDATE user_info
	         SET first_name = ?, middle_name = ?, last_name = ?, gender = ?,
	             email_address = ?, user_type = ?, user_status = ?
	         WHERE user_id = ?",
	        [$first_name, $middle_name, $last_name, $gender, $email_address, $user_type, $user_status, $user_id]
	    );

	    $this->db->query(
	        "UPDATE user_accounts SET username = ? WHERE user_id = ?",
	        [$username, $user_id]
	    );

	    if (!empty($password)) {
	        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
	        $this->db->query(
	            "UPDATE user_accounts SET password = ? WHERE user_id = ?",
	            [$hashed_password, $user_id]
	        );
	    }

	    // Type label helper
	    function get_type_label($type) {
	        switch ((int) $type) {
	            case 8:  return 'Superadmin';
	            case 1:  return 'Admin';
	            default: return 'Cashier';
	        }
	    }

	    // Build change list for log
	    $changes = [];
	    if ($old->first_name . ' ' . $old->last_name !== $first_name . ' ' . $last_name)
	        $changes[] = 'Name: ' . $old->first_name . ' ' . $old->last_name . ' → ' . $first_name . ' ' . $last_name;
	    if ($old->username !== $username)
	        $changes[] = 'Username: @' . $old->username . ' → @' . $username;
	    if ($old->user_type != $user_type)
	        $changes[] = 'Type: ' . get_type_label($old->user_type) . ' → ' . get_type_label($user_type);
	    if ($old->user_status != $user_status)
	        $changes[] = 'Status: ' . ($old->user_status == 1 ? 'Active' : 'Inactive') . ' → ' . ($user_status == 1 ? 'Active' : 'Inactive');
	    if (!empty($password))
	        $changes[] = 'Password changed';

	    $change_detail = !empty($changes)
	        ? implode('<br>', $changes)
	        : 'No significant changes';

	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Account Update',
	            'User ID: ' . $user_id,
	            '<strong>Updated Account:</strong><br>' . $change_detail
	        ]
	    );

	    echo json_encode(['status' => 'success', 'message' => 'Account updated']);
	    $this->flag_db_change();
	    exit;
	}
	public function void_pos_sale()
	{
	    header('Content-Type: application/json');
	    $pos_checkout_code = $this->input->post('pos_checkout_code', true);

	    if (empty($pos_checkout_code)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid sale code']);
	        return;
	    }

	    $sql = "SELECT pos_item_id, pos_item_name, pos_item_quantity, pos_item_unit, pos_checkout_status 
	            FROM pos_checkouts 
	            WHERE pos_checkout_code = ?";
	    $query = $this->db->query($sql, [$pos_checkout_code]);

	    if ($query->num_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Sale not found']);
	        return;
	    }

	    $rows = $query->result();
	    $all_voided = array_reduce($rows, fn($carry, $r) => $carry && $r->pos_checkout_status == 2, true);
	    if ($all_voided) {
	        echo json_encode(['status' => 'error', 'message' => 'Sale already voided']);
	        return;
	    }

	    $sql = "UPDATE pos_checkouts 
	            SET pos_checkout_status = 2 
	            WHERE pos_checkout_code = ? AND pos_checkout_status != 2";
	    $this->db->query($sql, [$pos_checkout_code]);

	    if ($this->db->affected_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'No changes made']);
	        return;
	    }

	    $item_lines = [];
	    foreach ($rows as $row) {
	        if ($row->pos_checkout_status != 2) {
	            $this->db->query(
	                "UPDATE pos_inventory SET pos_item_stock = pos_item_stock + ? WHERE pos_item_id = ?",
	                [$row->pos_item_quantity, $row->pos_item_id]
	            );
	            $item_lines[] = $row->pos_item_name . ' (x' . $row->pos_item_quantity . ' ' . $row->pos_item_unit . ')';
	        }
	    }

	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Sale Void',
	            'Sale Code: ' . $pos_checkout_code,
	            '<strong>Voided Sale:</strong><br>' . implode('<br>', $item_lines)
	        ]
	    );

	    echo json_encode(['status' => 'success', 'message' => 'Sale voided']);
	    $this->flag_db_change();
	    exit;
	}

	public function void_pos_checkout_item()
	{
	    header('Content-Type: application/json');
	    $pos_item_id       = $this->input->post('pos_item_id', true);
	    $pos_checkout_code = $this->input->post('pos_checkout_code', true);

	    if (empty($pos_item_id) || empty($pos_checkout_code)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
	        return;
	    }

	    $sql = "SELECT pos_item_id, pos_item_name, pos_item_quantity, pos_item_unit, pos_checkout_status
	            FROM pos_checkouts
	            WHERE pos_item_id = ? AND pos_checkout_code = ?";
	    $query = $this->db->query($sql, [$pos_item_id, $pos_checkout_code]);

	    if ($query->num_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Item not found']);
	        return;
	    }

	    $row = $query->row();

	    if ($row->pos_checkout_status == 2) {
	        echo json_encode(['status' => 'error', 'message' => 'Item already voided']);
	        return;
	    }

	    $sql = "UPDATE pos_checkouts
	            SET pos_checkout_status = 2
	            WHERE pos_item_id = ? AND pos_checkout_code = ? AND pos_checkout_status != 2";
	    $this->db->query($sql, [$pos_item_id, $pos_checkout_code]);

	    if ($this->db->affected_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'No changes made']);
	        return;
	    }

	    $this->db->query(
	        "UPDATE pos_inventory SET pos_item_stock = pos_item_stock + ? WHERE pos_item_id = ?",
	        [$row->pos_item_quantity, $row->pos_item_id]
	    );

	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Sale Item Void',
	            'Sale Code: ' . $pos_checkout_code,
	            '<strong>Voided Item:</strong><br>'
	                . $row->pos_item_name
	                . ' (x' . $row->pos_item_quantity . ' ' . $row->pos_item_unit . ')'
	        ]
	    );

	    echo json_encode(['status' => 'success', 'message' => 'Item voided']);
	    $this->flag_db_change();
	    exit;
	}

	public function restore_pos_checkout_item()
	{
	    header('Content-Type: application/json');
	    $pos_item_id       = $this->input->post('pos_item_id', true);
	    $pos_checkout_code = $this->input->post('pos_checkout_code', true);
	    if (empty($pos_item_id) || empty($pos_checkout_code)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
	        return;
	    }

	    $sql = "SELECT pos_item_id, pos_item_name, pos_item_quantity, pos_item_unit, pos_checkout_status
	            FROM pos_checkouts
	            WHERE pos_item_id = ? AND pos_checkout_code = ?";
	    $query = $this->db->query($sql, [$pos_item_id, $pos_checkout_code]);

	    if ($query->num_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Item not found']);
	        return;
	    }

	    $row = $query->row();

	    if ($row->pos_checkout_status != 2) {
	        echo json_encode(['status' => 'error', 'message' => 'Item is not voided']);
	        return;
	    }

	    $current = $this->db->query(
		    "SELECT pos_item_stock FROM pos_inventory WHERE pos_item_id = ?",
		    [$row->pos_item_id]
		)->row();

		if ($current->pos_item_stock < $row->pos_item_quantity) {
		    echo json_encode([
		        'status'  => 'error',
		        'message' => "Cannot restore — insufficient stock ({$current->pos_item_stock}) to deduct the original sale quantity ({$row->pos_item_quantity})."
		    ]);
		    return;
		}

	    $this->db->query(
	        "UPDATE pos_checkouts
	         SET pos_checkout_status = 1
	         WHERE pos_item_id = ? AND pos_checkout_code = ? AND pos_checkout_status = 2",
	        [$pos_item_id, $pos_checkout_code]
	    );

	    if ($this->db->affected_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'No changes made']);
	        return;
	    }

	    $this->db->query(
	        "UPDATE pos_inventory SET pos_item_stock = pos_item_stock - ? WHERE pos_item_id = ?",
	        [$row->pos_item_quantity, $row->pos_item_id]
	    );
	    // If all items are now active, set sale back to completed
	    $non_active = $this->db->query(
	        "SELECT COUNT(*) AS cnt FROM pos_checkouts
	         WHERE pos_checkout_code = ? AND pos_checkout_status != 1",
	        [$pos_checkout_code]
	    )->row()->cnt;

	    if ($non_active == 0) {
	        $this->db->query(
	            "UPDATE pos_checkouts SET pos_checkout_status = 1 WHERE pos_checkout_code = ?",
	            [$pos_checkout_code]
	        );
	    }

	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Sale Item Restore',
	            'Sale Code: ' . $pos_checkout_code,
	            '<strong>Restored Item:</strong><br>'
	                . $row->pos_item_name
	                . ' (x' . $row->pos_item_quantity . ' ' . $row->pos_item_unit . ')'
	        ]
	    );
	    echo json_encode(['status' => 'success', 'message' => 'Item restored']);
	    $this->flag_db_change();
	    exit;
	}

	public function restore_pos_sale()
	{
	    header('Content-Type: application/json');
	    $pos_checkout_code = $this->input->post('pos_checkout_code', true);

	    if (empty($pos_checkout_code)) {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid sale code']);
	        return;
	    }

	    $sql = "SELECT pos_item_id, pos_item_name, pos_item_quantity, pos_item_unit, pos_checkout_status 
	            FROM pos_checkouts 
	            WHERE pos_checkout_code = ?";
	    $query = $this->db->query($sql, [$pos_checkout_code]);

	    if ($query->num_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'Sale not found']);
	        return;
	    }

	    $rows = $query->result();
	    $all_active = array_reduce($rows, fn($carry, $r) => $carry && $r->pos_checkout_status == 1, true);
	    if ($all_active) {
	        echo json_encode(['status' => 'error', 'message' => 'Sale is not voided']);
	        return;
	    }

	    $sql = "UPDATE pos_checkouts
		        SET pos_checkout_status = 1
		        WHERE pos_checkout_code = ? AND pos_checkout_status IN (2, 3)";
		$this->db->query($sql, [$pos_checkout_code]);

	    if ($this->db->affected_rows() == 0) {
	        echo json_encode(['status' => 'error', 'message' => 'No changes made']);
	        return;
	    }

	    $item_lines = [];
	    foreach ($rows as $row) {
		    if ($row->pos_checkout_status == 2) {
		        $current = $this->db->query(
		            "SELECT pos_item_stock FROM pos_inventory WHERE pos_item_id = ?",
		            [$row->pos_item_id]
		        )->row();

		        if ($current->pos_item_stock < $row->pos_item_quantity) {
		            echo json_encode([
		                'status'  => 'error',
		                'message' => "Cannot restore — insufficient stock for {$row->pos_item_name} ({$current->pos_item_stock} available, {$row->pos_item_quantity} needed)."
		            ]);
		            return;
		        }

		        // Was fully voided — restore stock
		        $this->db->query(
		            "UPDATE pos_inventory SET pos_item_stock = pos_item_stock - ? WHERE pos_item_id = ?",
		            [$row->pos_item_quantity, $row->pos_item_id]
		        );
		        $item_lines[] = $row->pos_item_name . ' (x' . $row->pos_item_quantity . ' ' . $row->pos_item_unit . ')';
		    } else if ($row->pos_checkout_status == 3) {
		        // Was pending void — just reset status, no stock change needed
		        $item_lines[] = $row->pos_item_name . ' (x' . $row->pos_item_quantity . ' ' . $row->pos_item_unit . ') [void request cancelled]';
		    }
		}

	    $this->db->query(
	        "INSERT INTO pos_logs (pos_activity_type, pos_code, pos_activity) VALUES (?, ?, ?)",
	        [
	            'Sale Restore',
	            'Sale Code: ' . $pos_checkout_code,
	            '<strong>Restored Sale:</strong><br>' . implode('<br>', $item_lines)
	        ]
	    );

	    echo json_encode(['status' => 'success', 'message' => 'Sale restored']);
	    $this->flag_db_change();
	    exit;
	}
	public function request_void_pos_checkout_item()
	{
	    $pos_item_id       = $_POST['pos_item_id'];
	    $pos_checkout_code = $_POST['pos_checkout_code'];
	    header('Content-Type: application/json');
	    if (empty($pos_item_id) || empty($pos_checkout_code)) {
	        echo json_encode([
	            'status'  => 'error',
	            'message' => 'Missing required fields'
	        ]);
	        exit;
	    }
	    $this->db->query(
	        "UPDATE pos_checkouts
	         SET pos_checkout_status = 3
	         WHERE pos_item_id = ? AND pos_checkout_code = ?",
	        [$pos_item_id, $pos_checkout_code]
	    );
	    if ($this->db->affected_rows() > 0) {
	        echo json_encode([
	            'status'  => 'success',
	            'message' => 'Void request submitted successfully'
	        ]);
	    } else {
	        echo json_encode([
	            'status'  => 'error',
	            'message' => 'Item not found'
	        ]);
	    }
	    $this->flag_db_change();
	    exit;
	}
	public function cancel_void_request_pos_checkout_item()
	{
	    $pos_item_id       = $_POST['pos_item_id'];
	    $pos_checkout_code = $_POST['pos_checkout_code'];
	    header('Content-Type: application/json');
	    if (empty($pos_item_id) || empty($pos_checkout_code)) {
	        echo json_encode([
	            'status'  => 'error',
	            'message' => 'Missing required fields'
	        ]);
	        exit;
	    }
	    $this->db->query(
	        "UPDATE pos_checkouts
	         SET pos_checkout_status = 1
	         WHERE pos_item_id = ? AND pos_checkout_code = ? AND pos_checkout_status = 3",
	        [$pos_item_id, $pos_checkout_code]
	    );
	    if ($this->db->affected_rows() > 0) {
	        echo json_encode([
	            'status'  => 'success',
	            'message' => 'Void request cancelled successfully'
	        ]);
	    } else {
	        echo json_encode([
	            'status'  => 'error',
	            'message' => 'Item not found or not pending void'
	        ]);
	    }
	    $this->flag_db_change();
	    exit;
	}
	public function load_pos_voiding_requests()
	{
	    header('Content-Type: application/json');
	    $data = $this->db->query(
	        "SELECT 
	            c.pos_checkout_id,
	            c.pos_checkout_code,
	            c.pos_item_id,
	            c.pos_item_name,
	            c.pos_item_price,
	            c.pos_item_quantity,
	            c.pos_item_unit,
	            c.pos_checkout_total,
	            c.pos_checkout_date,
	            CONCAT(u.first_name, ' ', u.last_name) AS cashier_name
	         FROM pos_checkouts c
	         LEFT JOIN user_info u ON u.user_id = c.user_id
	         WHERE c.pos_checkout_status = 3
	         ORDER BY c.pos_checkout_date DESC"
	    )->result_array();
	    echo json_encode([
	        'status' => 'success',
	        'data'   => $data
	    ]);
	    exit;
	}
	public function stream_db_changes()
	{
	    header('Content-Type: text/event-stream');
	    header('Cache-Control: no-cache');
	    header('X-Accel-Buffering: no');
	    header('Connection: keep-alive');
	    if (ob_get_level()) ob_end_clean();
	    session_write_close();

	    // Send connected event immediately
	    echo "event: connected\n";
	    echo "data: " . json_encode(['timestamp' => date('Y-m-d H:i:s')]) . "\n\n";
	    flush();

	    $last_state = null;
	    while (true) {
	        $row = $this->db->query(
	            "SELECT updated_at FROM sse_state WHERE state_key = 'pos' LIMIT 1"
	        )->row();
	        $current_state = $row->updated_at ?? null;
	        if ($current_state !== $last_state) {
	            $last_state = $current_state;
	            echo "event: db_changed\n";
	            echo "data: " . json_encode(['timestamp' => $current_state]) . "\n\n";
	            flush();
	        } else {
	            echo ": heartbeat\n\n";
	            flush();
	        }
	        if (connection_aborted()) break;
	        sleep(1);
	    }
	}
	private function flag_db_change()
	{
	    $this->db->query(
	        "UPDATE sse_state SET updated_at = NOW(6) WHERE state_key = 'pos'"
	    );
	}
}