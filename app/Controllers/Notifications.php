<?php

namespace App\Controllers;

use App\Models\Reports\Inventory_low;
use Config\Services;

class Notifications extends Secure_Controller
{
    private Inventory_low $inventory_low;

    public function __construct()
    {
        parent::__construct('notifications');
        $this->inventory_low = model(Inventory_low::class);
    }

    public function index()
    {
        $data['low_inventory'] = $this->inventory_low->getData([]);
        $data['title'] = "Notifications";
        
        echo view('notifications/list', $data);
    }
}
