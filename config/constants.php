<?php

/* 
 * These are site contants:
 * Custom constants by Alvah Amit Halder.
 * Call constant method 1: config('constants.roles.admin');
 * Call constant method 2: Config::get('constants.roles.admin');
 * After making new config file need to run: php artisan config:cache
 */
return [
    //Quantity type:
    'quantity_type' => [
        'packing' => 'Wholesale Pack',
        'pcs' => 'Retail Pack/Pcs',
        'weight' => 'Weight/Volume'
    ],
    //Wastage area
    'wasted_at'=>[
        'store'=>'Store',
        'transportation'=>'Transportation',
        'handling'=>'Handling',
        'delivery'=>'Delivery',
        'client'=>'Client Store'
    ],
    //Labels 
    'labels'=>[
        'cell'=>'Cell','work'=>'Work','res'=>'Residence','whatsapp'=>'WhatsApp','emergency'=>'Emergency','club'=>'Club','factory'=>'Factory','gym'=>'Gym', 'school'=>'School'
    ],
    //Purchase types
    'purchase' =>[
        'local'=>'Local',
        'import' => 'Import',
    ],
    //Role names
    'roles' => [
        'admin' => 'Administrator', //This is for system admin. 
        'client' => 'Customer', //This is for customer or buyer.
        'supplier' => 'Supplier', //This is for local suppliers.
        'exporter' => 'Exporter', //This is for international suppliers or exporters.
        'management' => 'Management', //This is for top officials to approve, assign tasks and see reports.
        'procure' => 'Procure', //This is for officials in procure department.
        'sales' => 'Sales', //This is for sales staff.
        'marketing' => 'Marketing', //This is for marketing staff.
        'store' => 'Store', //This is for store keepers.
        'lead' => 'Lead', //Lead is for Marketing staff to convert into client.
        'accounts' => 'Accounts', //Handle all monetery actions.
    ],
    //Order types
    'order_type' => [
        'sales' => 1, 
        'sample' => 2, 
    ],
    //Order statuses
    'order_status' => [
        'pending' => 'Pending', 
        'processing' => 'Processing', 
        'complete' => 'Complete', 
        'hold' => 'Hold',
        'cancel' => 'Canceled',
    ],
    //Types of Challan
    'challan_type' => [
        'sales' => 1,
        'transfer' => 2,
        'sample' => 3,
    ],
    //Types of Invoices
    'invoice_type' =>[
        'whole' => 1,
        'partial' => 2,
        'sample' => 3,
    ],
    'default_pass' => 'password',
    'default_address' => 'VSF Distribution&#13;&#10;7/1/A Lake Circus&#13;&#10;Kolabagan, North Dhanmondi&#13;&#10;Dhaka 1205&#13;&#10;+88 02 58153080',
    'messages' => [
        'delete_alert' => "<div class='text-center lead'>Are you doing this by mistake?<br>A record is going to be permantly deleted.<br>Please confirm your action!!!</div>",
        'update_alert' => "<div class='text-center lead'>Records are going to be updated.<br>This will cause change of data.<br>Please confirm your action!!!</div>",
    ],
    
];
