<?php
include 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// SỬA LỖI FONT: Thiết lập charset cho phiên kết nối MySQL
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Lấy danh sách tên người chơi
$stmt = $pdo->query("SELECT Ten FROM billiards_users");
$users = $stmt->fetchAll(PDO::FETCH_COLUMN);

$message = '';

// Xử lý reset mật khẩu
if (isset($_POST['action']) && $_POST['action'] == 'reset') {
    $ten = $_POST['ten'] ?? '';
    if ($ten && isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
        $stmt = $pdo->prepare("UPDATE billiards_users SET Pass = ? WHERE Ten = ?");
        $stmt->execute(['123456', $ten]);
        $message = "Mật khẩu cho $ten đã được đặt lại thành 123456!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        
    

        
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
             opacity: 0.8;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            color: green;
            margin-bottom: 15px;
        }
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            button {
                font-size: 14px;
            }
        }
        
        
        body {
    margin: auto;
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, rgba(101,0,94,1) 3%, rgba(60,132,206,1) 38%, rgba(48,238,226,1) 68%, rgba(255,25,25,1) 98%);
    animation: gradient 15s ease infinite;
    background-size: 400% 400%;
    background-attachment: fixed;
}

@keyframes gradient {
    0% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0% 0%;
    }
}

.wave {
    background: rgb(255 255 255 / 25%);
    border-radius: 1000% 1000% 0 0;
    position: fixed;
    width: 200%;
    height: 12em;
    animation: wave 10s -3s linear infinite;
    transform: translate3d(0, 0, 0);
    opacity: 0.8;
    bottom: 0;
    left: 0;
    z-index: -1;
}

.wave:nth-of-type(2) {
    bottom: -1.25em;
    animation: wave 18s linear reverse infinite;
    opacity: 0.8;
}

.wave:nth-of-type(3) {
    bottom: -2.5em;
    animation: wave 20s -1s reverse infinite;
    opacity: 0.9;
}

@keyframes wave {
    2% {
        transform: translateX(1);
    }

    25% {
        transform: translateX(-25%);
    }

    50% {
        transform: translateX(-50%);
    }

    75% {
        transform: translateX(-25%);
    }

    100% {
        transform: translateX(1);
    }
}

    </style>
</head>
<body>
				<div>
     <div class="wave"></div>
     <div class="wave"></div>
     <div class="wave"></div>
  </div>

<div class="min-h-screen w-full flex justify-center items-center p-4 main">		
		
		
    <div class="container">
        <h1>Reset Mật Khẩu</h1>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" id="resetForm">
            <label for="ten">Chọn người chơi:</label>
            <select id="ten" name="ten">
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user); ?>"><?php echo htmlspecialchars($user); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="action" value="reset">
            <input type="hidden" id="confirm" name="confirm" value="">
            <button type="submit" id="resetBtn" onclick="return confirmReset()">Reset</button>
        </form>
    </div>

    <script>
        function confirmReset() {
            const ten = document.getElementById('ten').value;
            if (confirm("Bạn có muốn đặt mật khẩu mặc định cho " + ten + " không?")) {
                document.getElementById('confirm').value = 'yes';
                return true;
            }
            return false;
        }
    </script>
    
 </div>   
    
</body>
</html>