<?php
// 데이터베이스 연결
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");
// 폼 데이터 수집 및 쿼리 작성
$name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$stmt = $conn->prepare("SELECT * FROM users WHERE name = ? AND email = ?");
if ($stmt === false) {
    die("Error: " . mysqli_error($conn));
}
$stmt->bind_param('ss', $name, $email);

// 쿼리 실행 및 결과 처리
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  // 로그인 성공
  echo "로그인 성공!";
} else {
  // 로그인 실패
  echo "아이디나 비밀번호가 올바르지 않습니다.";
}

// 데이터베이스 연결 종료
$stmt->close();
$conn->close();
?>
