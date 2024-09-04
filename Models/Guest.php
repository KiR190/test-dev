<?php

class Guest {
    private $conn;
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $country;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function create($firstName, $lastName, $email, $phone, $country) {
        $validationResult = $this->validate(null, $firstName, $lastName, $email, $phone);
        if (isset($validationResult['error'])) {
            return $validationResult;
        }

        $stmt = $this->conn->prepare("INSERT INTO guests (first_name, last_name, email, phone, country) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $phone, $country]);
        return ['success' => 'Данные успешно добавлены с id ' . $this->conn->lastInsertId()];
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM guests");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM guests WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("SELECT * FROM guests WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $guest = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$guest) {
            return ['error' => 'Гость не найден'];
        }

        $firstName = $data['first_name'] ?? $guest['first_name'];
        $lastName = $data['last_name'] ?? $guest['last_name'];
        $email = $data['email'] ?? $guest['email'];
        $phone = $data['phone'] ?? $guest['phone'];
        $country = $data['country'] ?? $guest['country'];
        
        $validationResult = $this->validate($id, $firstName, $lastName, $email, $phone);
        if (isset($validationResult['error'])) {
            return $validationResult;
        }

        $stmt = $this->conn->prepare("UPDATE guests SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, country = :country WHERE id = :id");
        $stmt->execute(['first_name' => $firstName, 'last_name' => $lastName, 'email' => $email, 'phone' => $phone, 'country' => $country, 'id' => $id]);
        return ['success' => 'Данные успешно обновлены'];
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM guests WHERE id = :id");    
        if ($stmt->execute(['id' => $id])) {
            return ['success' => 'Данные успешно удалены'];
        } else {
            return ['error' => 'Ошибка при удалении данных'];
        }
    }

    private function validate($id, $firstName, $lastName, $email, $phone) {
        if (empty($firstName) || empty($lastName) || empty($phone)) {
            return ['error' => 'Имя, фамилия и телефон обязательны для заполнения'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Некорректный email'];
        }

        if (!preg_match('/^\+[0-9]{10,15}$/', $phone)) {            
            return ['error' => 'Некорректный номер телефона'];
        }

        if (!$this->isUnique('email', $email, $id)) {        
            return ['error' => 'Email уже используется'];
        }

        if (!$this->isUnique('phone', $phone, $id)) {        
            return ['error' => 'Телефон уже используется'];
        }

        return ['success' => 'Валидация пройдена'];
    }

    private function isUnique($field, $value, $id = null) {
        $query = "SELECT COUNT(*) FROM guests WHERE $field = :value";
        $params = ['value' => $value];

        if ($id !== null) {
            $query .= " AND id != :id";
            $params['id'] = $id;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn() == 0;
    }
}
