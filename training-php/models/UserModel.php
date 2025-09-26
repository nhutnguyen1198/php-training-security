<?php

require_once 'BaseModel.php';

class UserModel extends BaseModel {

    public function findUserById($id) {
        $stmt = self::$_connection->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = [];
        while ($row = $result->fetch_assoc()) {
            $user[] = $row;
        }
        $stmt->close();
        return $user;
    }

    public function findUser($keyword) {
        $like = '%' . $keyword . '%';
        $stmt = self::$_connection->prepare('SELECT * FROM users WHERE user_name LIKE ? OR user_email LIKE ?');
        $stmt->bind_param('ss', $like, $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = [];
        while ($row = $result->fetch_assoc()) {
            $user[] = $row;
        }
        $stmt->close();
        return $user;
    }

    /**
     * Authentication user
     * @param $userName
     * @param $password
     * @return array
     */
    public function auth($userName, $password) {
        $md5Password = md5($password);
        $stmt = self::$_connection->prepare('SELECT * FROM users WHERE name = ? AND password = ?');
        $stmt->bind_param('ss', $userName, $md5Password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = [];
        while ($row = $result->fetch_assoc()) {
            $user[] = $row;
        }
        $stmt->close();
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id) {
        $stmt = self::$_connection->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Update user
     * @param $input
     * @return mixed
     */
    public function updateUser($input) {
        $md5Password = md5($input['password']);
        $stmt = self::$_connection->prepare('UPDATE users SET name = ?, password = ? WHERE id = ?');
        $stmt->bind_param('ssi', $input['name'], $md5Password, $input['id']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Insert user
     * @param $input
     * @return mixed
     */
    public function insertUser($input) {
        $md5Password = md5($input['password']);
        $stmt = self::$_connection->prepare('INSERT INTO users (name, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $input['name'], $md5Password);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getUsers($params = []) {
        if (!empty($params['keyword'])) {
            $like = '%' . $params['keyword'] . '%';
            $stmt = self::$_connection->prepare('SELECT * FROM users WHERE name LIKE ?');
            $stmt->bind_param('s', $like);
            $stmt->execute();
            $result = $stmt->get_result();
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            $stmt->close();
            return $users;
        } else {
            $sql = 'SELECT * FROM users';
            $result = self::$_connection->query($sql);
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        }
    }
}