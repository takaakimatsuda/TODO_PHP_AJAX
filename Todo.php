<?php



namespace MyApp;

class Todo {
  private $_db;

  public function __construct() {
    $this->_createToken();

    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      // エラーが発生したときに、PDOExceptionの例外を投げてくれるようになる
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
  // CSRF対策にトークンを作成
  private function _createToken() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
  }
  
  public function getAll() {
    // DBから全てのタスクデータを降順に取り出す
    $stmt = $this->_db->query("select * from todos order by id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function post() {
    // 起動時にバリデーションを呼び出す
    $this->_validateToken();

    if (!isset($_POST['mode'])) {
      throw new \Exception('mode not set!');
    }

    switch ($_POST['mode']) {
      case 'create':
        return $this->_create();
      case 'delete':
        return $this->_delete();
    }
  }

  private function _validateToken() {
    if (
      !isset($_SESSION['token']) ||
      !isset($_POST['token']) ||
      $_SESSION['token'] !== $_POST['token']
    ) {
      throw new \Exception('invalid token!');
    }
  }


  private function _create() {
    if (!isset($_POST['title']) || $_POST['title'] === '') {
      throw new \Exception('[create] title not set!');
    }

    $sql = "insert into todos (title) values (:title)";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':title' => $_POST['title']]);

    return [
      'id' => $this->_db->lastInsertId()
    ];
  }

  private function _delete() {
    if (!isset($_POST['id'])) {
      throw new \Exception('[delete] id not set!');
    }

    $sql = sprintf("delete from todos where id = %d", $_POST['id']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();

    return [];
  }
}