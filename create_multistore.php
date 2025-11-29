<?php
$mysqli = new mysqli("localhost", "ospos", "ospos", "ospos", 3306);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

function create_location($mysqli, $name) {
    $stmt = $mysqli->prepare("INSERT INTO ospos_stock_locations (location_name, deleted) VALUES (?, 0)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $location_id = $stmt->insert_id;
    $stmt->close();
    echo "Created Location: $name (ID: $location_id)\n";

    $modules = ['items', 'sales', 'receivings'];
    $perm_suffix = str_replace(' ', '_', $name);

    foreach ($modules as $module) {
        $perm_id = $module . "_" . $perm_suffix;
        $stmt = $mysqli->prepare("INSERT IGNORE INTO ospos_permissions (permission_id, module_id, location_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $perm_id, $module, $location_id);
        $stmt->execute();
        $stmt->close();
        echo "  Created Permission: $perm_id\n";
    }
    return $location_id;
}

function create_user($mysqli, $username, $password, $firstname, $company_id) {
    // Insert Person
    $stmt = $mysqli->prepare("INSERT INTO ospos_people (first_name, last_name, phone_number, email, address_1, address_2, city, state, zip, country, comments, company_id) VALUES (?, 'Owner', '555-0000', ?, 'Address', '', 'City', 'State', '00000', 'Pakistan', '', ?)");
    $email = $username . "@example.com";
    $stmt->bind_param("ssi", $firstname, $email, $company_id);
    $stmt->execute();
    $person_id = $stmt->insert_id;
    $stmt->close();

    // Insert Employee
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $mysqli->prepare("INSERT INTO ospos_employees (username, password, person_id, deleted, hash_version) VALUES (?, ?, ?, 0, 2)");
    $stmt->bind_param("ssi", $username, $hash, $person_id);
    $stmt->execute();
    $stmt->close();

    echo "Created User: $username (Person ID: $person_id, Company ID: $company_id)\n";
    return $person_id;
}

function assign_grant($mysqli, $person_id, $permission_id) {
    $stmt = $mysqli->prepare("INSERT IGNORE INTO ospos_grants (permission_id, person_id, menu_group) VALUES (?, ?, 'home')");
    $stmt->bind_param("si", $permission_id, $person_id);
    $stmt->execute();
    $stmt->close();
    echo "  Granted: $permission_id\n";
}

// 1. Create Locations
$talha_loc_id = create_location($mysqli, "Talha Store");
$hashim_loc_id = create_location($mysqli, "Hashim Store");

// 2. Create Users
$talha_id = create_user($mysqli, "talha", "pointofsale", "Talha", 2);
$hashim_id = create_user($mysqli, "hashim", "pointofsale", "Hashim", 3);

// 3. Assign Base Permissions
$base_perms = ['home', 'items', 'sales', 'customers', 'receivings', 'reports', 'suppliers', 'messages'];
foreach ($base_perms as $perm) {
    assign_grant($mysqli, $talha_id, $perm);
    assign_grant($mysqli, $hashim_id, $perm);
}

// 4. Assign Location Specific Permissions
// Talha gets Talha Store
assign_grant($mysqli, $talha_id, "items_Talha_Store");
assign_grant($mysqli, $talha_id, "sales_Talha_Store");
assign_grant($mysqli, $talha_id, "receivings_Talha_Store");

// Hashim gets Hashim Store
assign_grant($mysqli, $hashim_id, "items_Hashim_Store");
assign_grant($mysqli, $hashim_id, "sales_Hashim_Store");
assign_grant($mysqli, $hashim_id, "receivings_Hashim_Store");

// 5. Initialize Inventory for new locations (set to 0 for all existing items)
$result = $mysqli->query("SELECT item_id FROM ospos_items");
while ($row = $result->fetch_assoc()) {
    $item_id = $row['item_id'];
    $mysqli->query("INSERT INTO ospos_item_quantities (item_id, location_id, quantity) VALUES ($item_id, $talha_loc_id, 0)");
    $mysqli->query("INSERT INTO ospos_item_quantities (item_id, location_id, quantity) VALUES ($item_id, $hashim_loc_id, 0)");
}
echo "Initialized inventory for new locations.\n";

$mysqli->close();
?>
