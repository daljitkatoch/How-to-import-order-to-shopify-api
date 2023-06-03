<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$accessToken = 'enter_access_token_here';
$shopifyDomain = 'shop-url.myshopify.com';

$orderData = [
    'order' => [
        'line_items' => [
            [
                'title' => 'Product 1',
                'quantity' => 2,
                'price' => '10.00',
                'sku' => 'ABC123'
            ],
            // Add more line items as needed
        ],
        'customer' => [
            'id' => '6768497557663',
        ],
		'billing_address' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address1' => '123 Billing St',
            'city' => 'City',
            'province' => 'State',
            'zip' => '12345',
            'country' => 'Country',
        ],
        'shipping_address' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address1' => '123 Shipping St',
            'city' => 'City',
            'province' => 'State',
            'zip' => '12345',
            'country' => 'Country',
        ],
		'subtotal_price' => '25.00',
		'total_price' => '25.00',
		'order_number' => '45353666',
		'paid_amount' => '25.00',
		'financial_status' => 'paid',
        'payment_gateway_names' => [
            'Credit Card',
        ],
        'discount_codes' => [
            [
                'code' => 'DISCOUNT_CODE',
                'amount' => '5.00',
                'type' => 'fixed_amount',
            ],
        ],
        'note_attributes' => [
            [
                'name' => 'Order Note',
                'value' => 'This is a note for the order.',
            ],
        ],
    ],
];

$client = new Client();

try {
    $response = $client->request('POST', "https://shop-url.myshopify.com/admin/api/2023-04/orders.json", [
        'headers' => [
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => $accessToken,
        ],
        'json' => $orderData
    ]);

    $responseBody = json_decode($response->getBody(), true);
    if ($response->getStatusCode() === 201) {
        $createdOrderId = $responseBody['order']['id'];
        echo "Order created with ID: $createdOrderId";
    } else {
        // Handle error
        echo 'Error creating order: ' . $responseBody['errors'][0]['message'];
    }
} catch (\Exception $e) {
    // Handle exception
    echo 'Exception occurred: ' . $e->getMessage();
}
?>
