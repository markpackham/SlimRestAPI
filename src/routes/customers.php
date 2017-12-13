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


//Add Customer
//Notice we are using post instead of get, a 3rd party app could be used to submit the data in json
//This data would then populate our database providing it was done via post
//A good plugin to use would be Chrome's RestEasy
$app->post('/api/customer/add', function (Request $request, Response $response) {

    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state) VALUES
    (:first_name,:last_name,:phone,:email,:address,:city,:state)";

    try {
        // Get Database Object
        $db = new db();
        // Connect to database
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Added"}';

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

// Update Customer
//Use PUT instead of POST
$app->put('/api/customer/update/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "UPDATE customers SET
				first_name 	= :first_name,
				last_name 	= :last_name,
                phone		= :phone,
                email		= :email,
                address 	= :address,
                city 		= :city,
                state		= :state
			WHERE id = $id";

    try {
        // Get Database Object
        $db = new db();
        // Connect to database
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Updated"}';

    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

// Delete Customer
$app->delete('/api/customer/delete/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM customers WHERE id = $id";

    try {
        // Get Database Object
        $db = new db();
        // Connect to database
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Customer Deleted"}';
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});