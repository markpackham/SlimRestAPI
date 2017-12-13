<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get All Customers
$app->get('/api/customers', function (Request $request, Response $response) {
    //Show Customers when we go to http://localhost/slimRestAPI/public/api/customers
    //echo 'Customers';

    $sql = "SELECT * FROM customers";

    try {
        //Get database object
        $db = new db();
        //Connect to database
        $db = $db->connect();

        //Our statment
        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);

    } catch (PDOException $e) {
        //output error as JSON
        echo '{"error":{"text": ' . $e->getMessage() . '}';
    }
});

//Get Single Customer
$app->get('/api/customer/{id}', function (Request $request, Response $response) {
    //Show Customers when we go to http://localhost/slimRestAPI/public/api/customers
    //echo 'Customers';

    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM customers WHERE id = $id";

    try {
        //Get database object
        $db = new db();
        //Connect to database
        $db = $db->connect();

        //Our statment
        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //Visit somewhere like this to get a result http://localhost/slimRestAPI/public/api/customer/2
        echo json_encode($customer);

    } catch (PDOException $e) {
        //output error as JSON
        echo '{"error":{"text": ' . $e->getMessage() . '}';
    }
});