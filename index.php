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

// Lấy người chơi đã chọn từ cookie hoặc POST
$selectedUser = isset($_POST['ten']) ? $_POST['ten'] : (isset($_COOKIE['selected_user']) ? $_COOKIE['selected_user'] : (isset($users[0]) ? $users[0] : ''));

// THÊM: Lấy bàn chơi đã chọn từ POST, mặc định là 1
$selectedBan = isset($_POST['ban']) ? $_POST['ban'] : '1';

// Xử lý đăng nhập
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $ten = $_POST['ten'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $ban = $_POST['ban'] ?? '1'; // Lấy giá trị bàn từ POST
    
    if (empty($pass)) {
        $message = "Mã pin không được để trống!";
    } elseif (!preg_match('/^[0-9]{1,8}$/', $pass)) {
        $message = "Mã pin chỉ được chứa số và tối đa 8 ký tự!";
    } else {
        $stmt = $pdo->prepare("SELECT Pass FROM billiards_users WHERE Ten = ?");
        $stmt->execute([$ten]);
        $storedPass = $stmt->fetchColumn();
        
        if ($storedPass === $pass) {
            setcookie('selected_user', $ten, time() + (30 * 24 * 60 * 60)); // Lưu 30 ngày
            // CẬP NHẬT: Thêm tham số '&b=' (bàn chơi) vào URL chuyển hướng
            header("Location: play.php?u=" . urlencode(openssl_encrypt($ten, "aes-256-cbc", "The Ministry of Public Security", 0, '1234567891011121'))."&p=" . urlencode(openssl_encrypt($storedPass, "aes-256-cbc", "The Ministry of Public Security", 0, '1234567891011121')) . "&b=" . urlencode($ban));
            exit;
        } else {
            $message = "Sai mật khẩu!";
            $selectedUser = $ten; // Giữ nguyên người dùng đã chọn
        }
    }
}

// Xử lý đổi mật khẩu (Giữ nguyên)
if (isset($_POST['action']) && $_POST['action'] == 'change_pass') {
    $ten = $_POST['ten'] ?? '';
    $oldPass = $_POST['old_pass'] ?? '';
    $newPass = $_POST['new_pass'] ?? '';
    
    if (!preg_match('/^[0-9]{1,8}$/', $oldPass) || !preg_match('/^[0-9]{1,8}$/', $newPass)) {
        $message = "Mật khẩu chỉ được chứa số và tối đa 8 ký tự!";
    } else {
        $stmt = $pdo->prepare("SELECT Pass FROM billiards_users WHERE Ten = ?");
        $stmt->execute([$ten]);
        $storedPass = $stmt->fetchColumn();
        
        if ($storedPass === $oldPass) {
            $stmt = $pdo->prepare("UPDATE billiards_users SET Pass = ? WHERE Ten = ?");
            $stmt->execute([$newPass, $ten]);
            $message = "Mật khẩu đã được thay đổi!";
        } else {
            $message = "Mật khẩu cũ không chính xác!";
        }
    }
}
// view.php
function get_base_url() {
    // 1. Lấy giao thức (http hoặc https)
    $protocol = ( !empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' || $_SERVER[ 'SERVER_PORT' ] == 443 ) ? "https://" : "http://";

    // 2. Lấy tên host (domain)
    $host = $_SERVER[ 'HTTP_HOST' ];

    // 3. Lấy đường dẫn của file đang chạy (ví dụ: /abc/index.php)
    $script_path = $_SERVER[ 'SCRIPT_NAME' ];

    // 4. Lấy ra phần thư mục bằng cách loại bỏ tên file cuối cùng (ví dụ: /abc/index.php -> /abc/)
    $base_dir = dirname( $script_path );

    // 5. Thêm dấu gạch chéo cuối nếu chưa có
    if ( substr( $base_dir, -1 ) !== '/' ) {
        $base_dir .= '/';
    }

    // 6. Kết hợp lại: giao thức + host + thư mục
    $base_url = $protocol . $host . $base_dir;

    return $base_url;
}
$domain = get_base_url();
$seed = floor( time() );
srand( $seed );

$domain="https://github.com/quantritnmthn/bia/raw/refs/heads/main/";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="formTitle">Đăng nhập hệ thống Pool Online</title>
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<link rel="manifest" href="webmanifest.json">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#10260f;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            
            padding: 20px;
            
            width: 100%;
            max-width: 400px;
            
        }
        h1 {
            text-align: center;
            color: #fff;
            
            
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #fff;
            font-weight:bold;
        }
        select, input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #aaa;
            border-radius: 4px;
            box-sizing: border-box;  
            color:#fbf62a;        
            font-size:14px; 
            font-weight:bold;
             background-color: transparent;
        }
        option {color:blue;font-weight:bold;font-size:14px; }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px;
            font-weight:bold;
            opacity: 0.8;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            color: red;
            margin-bottom: 15px;
        }
        .link {
            text-align: center;
            margin-top: 10px;
            color: #ffca00;
            cursor: pointer;
        }
        
        
        
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            button {
                font-size: 14px;
            }
        }
        
        
   a:visited {
           color: #00ffc6;
        }


.khung-bai {
            width:100%;
            margin: 20px auto;
            text-align: center;
        }
        .anhbai {
            width: 0px; /* Chiều rộng của mỗi quân bài */
            height: auto;
            margin: 0px;
         
        }
        
        
 #bg-video {
            /* Vị trí cố định (fixed) so với viewport */
            position: fixed;
            top: 0;
            left: 0;
            
            /* Đảm bảo video che phủ toàn bộ viewport */
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            
            /* Cắt video để giữ tỷ lệ khung hình và che phủ */
            object-fit: cover; 
            
            /* Đưa video ra lớp dưới cùng */
            z-index: -100;

            /* Hiệu ứng tối (tùy chọn) để nội dung dễ đọc hơn */
            filter: brightness(100%);
        }

        img {opacity: 0.9;  
         -webkit-animation:spin 1s linear infinite;
    -moz-animation:spin 1s linear infinite;
    animation:spin 1s linear infinite;
         }
         
         @-moz-keyframes spin { 
    100% { -moz-transform: rotate(360deg); } 
}
@-webkit-keyframes spin { 
    100% { -webkit-transform: rotate(360deg); } 
}
@keyframes spin { 
    100% { 
        -webkit-transform: rotate(360deg); 
        transform:rotate(360deg); 
    } 
}


.neon-text {
    
    color: #fff;
    text-shadow: 0 0 5px #ff005e, 0 0 10px #ff005e, 0 0 20px #ff005e, 0 0 40px #ff005e, 0 0 80px #ff005e;
    
}


    </style>
</head>	
<body>
		
	
	 <video autoplay loop muted playsinline id="bg-video">
        <!-- THAY ĐỔI ĐƯỜNG DẪN VIDEO CỦA BẠN TẠI ĐÂY -->
        <source src="<?php echo($domain);?>video/<?php echo(rand(1,60));?>.mp4" type="video/mp4">
        <!-- Fallback cho trình duyệt không hỗ trợ -->
        Trình duyệt của bạn không hỗ trợ thẻ video.
    </video>	
	
		
		
    <div class="container">
    	
        <h1 id="formTitle" class="neon-text">Đăng nhập hệ thống<br>        
        
        Pool Online<br>
        	
        <img src="ball/A.png" style="width:5.5%">        
        <img src="ball/2.png" style="width:5.5%">
        <img src="ball/3.png" style="width:5.5%">
        <img src="ball/4.png" style="width:5.5%">
        <img src="ball/5.png" style="width:5.5%">
        <img src="ball/6.png" style="width:5.5%">
        <img src="ball/7.png" style="width:5.5%">
        <img src="ball/8.png" style="width:5.5%">
        <img src="ball/9.png" style="width:5.5%">
        <img src="ball/10.png" style="width:5.5%">
        <img src="ball/J.png" style="width:5.5%">
        <img src="ball/Q.png" style="width:5.5%">
        <img src="ball/K.png" style="width:5.5%">  
            </h1>
        
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" id="loginForm">
            <label for="ten">Tên người chơi:</label>
            <select id="ten" name="ten">
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user); ?>" <?php echo ($user === $selectedUser) ? 'selected' : ''; ?>><?php echo htmlspecialchars($user); ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="pass" id="passLabel">Mã pin đăng nhập:</label>
            <input type="password" id="pass" name="pass" maxlength="8" pattern="[0-9]*" inputmode="numeric" required>
            
            <label for="ban" id="banLabel">Chọn bàn chơi:</label>
            <select id="ban" name="ban">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i == $selectedBan) ? 'selected' : ''; ?>>Bàn <?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="old_pass" id="oldPassLabel" style="display:none;">Mật khẩu cũ:</label>
            <input type="password" id="old_pass" name="old_pass" maxlength="8" pattern="[0-9]*" inputmode="numeric" style="display:none;" >
            
            <label for="new_pass" id="newPassLabel" style="display:none;">Mật khẩu mới:</label>
            <input type="password" id="new_pass" name="new_pass" maxlength="8" pattern="[0-9]*" inputmode="numeric" style="display:none;" >
            
            <input type="hidden" name="action" id="action" value="login">
            
            <button type="submit" id="submitBtn">Đăng nhập</button>
        </form>
        
        <p class="link" id="changePassLink">Đổi mật khẩu</p>
        	<br>
        	<div style="width:100%; text-align:center" >
        	<a href="huongdan.html" style="text-decoration:none" >Hướng dẫn chơi</a>
        	</div>
      <div id="cardContainer" class="khung-bai">
        </div>

    <script>
        // Danh sách các giá trị bài
        const values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        // Danh sách các chất bài và ký hiệu (R: Rô, C: Cơ, B: Bích, T: Tép)
        const suits = ['R', 'C', 'B', 'T'];
        // Thư mục chứa file ảnh
        const folder = 'desk/';
        // Phần tử để chèn HTML vào
        const container = document.getElementById('cardContainer');
        let htmlContent = '';

        // Vòng lặp để tạo tên file và thẻ <img>
        for (const suit of suits) {
            for (const value of values) {
                // Tên file theo định dạng: [Giá Trị][Chất].[svg] (ví dụ: AR.svg, 10C.svg)
                const fileName = `${value}${suit}.svg`;
                const filePath = folder + fileName;

                // Tạo thẻ <img>
                htmlContent += `<img src="${filePath}" class="anhbai" alt="${value} ${suit}" />`;
            }
        }

        // Chèn chuỗi HTML vào container
        container.innerHTML = htmlContent;
    </script>
        <p class="link" id="backLink" style="display:none;">Quay lại đăng nhập</p>
    </div>

    <script>
        const formTitle = document.getElementById('formTitle');
        const passLabel = document.getElementById('passLabel');
        const passInput = document.getElementById('pass');
        // THÊM BIẾN DOM CHO BÀN CHƠI
        const banLabel = document.getElementById('banLabel');
        const banInput = document.getElementById('ban');
        
        const oldPassLabel = document.getElementById('oldPassLabel');
        const oldPassInput = document.getElementById('old_pass');
        const newPassLabel = document.getElementById('newPassLabel');
        const newPassInput = document.getElementById('new_pass');
        const submitBtn = document.getElementById('submitBtn');
        const actionInput = document.getElementById('action');
        const changePassLink = document.getElementById('changePassLink');
        const backLink = document.getElementById('backLink');

        // Lưu giá trị dropdown vào cookie ngay khi thay đổi
        document.getElementById('ten').addEventListener('change', function() {
            document.cookie = "selected_user=" + this.value + "; path=/; max-age=" + (30 * 24 * 60 * 60);
        });

        // Chặn ký tự chữ và giới hạn độ dài
        ['pass', 'old_pass', 'new_pass'].forEach(id => {
            document.getElementById(id).addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 8) this.value = this.value.slice(0, 8);
            });
        });

        changePassLink.addEventListener('click', () => {
            formTitle.textContent = "Đổi mật khẩu";
            passLabel.style.display = 'none';
            passInput.style.display = 'none';
            // ẨN BÀN CHƠI KHI ĐỔI MẬT KHẨU
            banLabel.style.display = 'none';
            banInput.style.display = 'none';
            
            oldPassLabel.style.display = 'block';
            oldPassInput.style.display = 'block';
            newPassLabel.style.display = 'block';
            newPassInput.style.display = 'block';
            submitBtn.textContent = "Đổi mật khẩu";
            actionInput.value = "change_pass";
            changePassLink.style.display = 'none';
            backLink.style.display = 'block';
            oldPassInput.required = true;
            newPassInput.required = true;
            passInput.required = false;
        });

        backLink.addEventListener('click', () => {
            formTitle.textContent = "Đăng nhập hệ thống Pool";
            passLabel.style.display = 'block';
            passInput.style.display = 'block';
            // HIỆN BÀN CHƠI KHI QUAY LẠI ĐĂNG NHẬP
            banLabel.style.display = 'block';
            banInput.style.display = 'block';
            
            oldPassLabel.style.display = 'none';
            oldPassInput.style.display = 'none';
            newPassLabel.style.display = 'none';
            newPassInput.style.display = 'none';
            submitBtn.textContent = "Đăng nhập";
            actionInput.value = "login";
            changePassLink.style.display = 'block';
            backLink.style.display = 'none';
            oldPassInput.required = false;
            newPassInput.required = false;
            passInput.required = true;
        });
    </script>
</body>
</html>