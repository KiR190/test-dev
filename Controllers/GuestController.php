<?php

require 'Models/Guest.php';
require 'Services/CountryService.php';

class GuestController {

    private $guestModel;
    private $countryService;

    public function __construct($dbConnection) {
        $this->guestModel = new Guest($dbConnection);
        $this->countryService = new CountryService();
    }

    public function handleRequest($requestMethod, $id = null) {
        switch ($requestMethod) {
            case 'POST':
                $data = json_decode(file_get_contents("php://input"), true);
                $country = $data['country'] ?? $this->countryService->getCountryByPhone($data['phone']);
                $response = $this->guestModel->create($data['first_name'], $data['last_name'], $data['email'], $data['phone'], $country);
                break;

            case 'GET':
                $response = $id ? $this->guestModel->getById($id) : $this->guestModel->getAll();
                break;

            case 'PUT':
                $data = json_decode(file_get_contents("php://input"), true);
                $response = $this->guestModel->update($id, $data);
                break;

            case 'DELETE':
                $response = $this->guestModel->delete($id);
                break;

            default:
                $response = ['error' => 'Метод не поддерживается'];
        }

        echo json_encode($response);
    }
}
