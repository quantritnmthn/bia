<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Billiards</title>
<script src="js/jquery-3.7.1.min.js" ></script> 
    

<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<link rel="manifest" href="webmanifest.json">
<style>
html, body {
    font-family: Arial, sans-serif;
    padding: 10px;
    background-color: #fff;
    margin: 0;
    height: 100%;
    display: flex;
    flex-direction: column; /* Xếp các phần tử theo chiều dọc */
    min-height: 100dvh;
    min-height: -webkit-fill-available;
     height: -webkit-fill-available;
}
.table-container {
    overflow-x: auto;
    margin-bottom: 20px;
    position: relative;
}
#resultTable {
    width: 100%;
    border-collapse: collapse;
    font-weight: bold;
    table-layout: fixed;
    font-size: 14px;
}
#resultTable th, #resultTable td {
    border: 1px solid #ddd;
    padding: 4px 2px;
    text-align: center;
}
#resultTable thead th {
    background-color: #116281;
    position: sticky;
    top: 0;
    z-index: 20;
    text-align: center;
}
.player-name-col {
    background-color: #f9f9f9;
    text-align: center !important;
    font-weight: normal;
    left: 0;
    z-index: 10;
    width: 12%;
}
#resultTable thead th.player-name-col {
    z-index: 30;
}
.result-col {
    font-weight: bold;
}
.game-score-col {
    background-color: #fff;
    color: #cc0000;
}
.score-m {
    background-color: #cc0000 !important;
    color: white !important;
}
.score-u {
    background-color: #a5eba7 !important;
    color: #1b620e !important;
}
.score-s {
    background-color: #ff4500 !important;
    color: yellow !important;
}
.score-0u {
    background-color: #f4fb6b !important;
    color: #7c761e !important;
}
.total-moms {
    background-color: #cc0000 !important;
    color: #ffffff !important;
}
.total-us {
    background-color: #4dd150 !important;
    color: #1b620e !important;
}
.total-scars {
    background-color: #ff4500 !important;
    color: #ffff00 !important;
}
.baou {
    padding: 3px;
    margin-top: 2px;
    -webkit-animation: pulse 400ms infinite alternate;
    animation: pulse 400ms infinite alternate;
}
@-webkit-keyframes pulse {
0% {
background-color: red;
}
100% {
background-color: yellow;
}
}
#resultTable thead th.player-name-col {
    z-index: 30;
}
#largeScore {
    font-size: 136px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    margin-top: 3px;
    display: none;
    color: #FFFFFF;
    background: #0e8dbc;
    text-shadow: 0 1px 0 #CCCCCC, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9, 0 5px 0 #aaa, 0 6px 1px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1), 0 1px 3px rgba(0,0,0,.3), 0 3px 5px rgba(0,0,0,.2), 0 5px 10px rgba(0,0,0,.25), 0 10px 10px rgba(0,0,0,.2), 0 20px 20px rgba(0,0,0,.15);
}
#playerSelect {
    width: 100%;
    font-size: 16px;
    padding: 8px;
    box-sizing: border-box;
    margin-bottom: 3px;
    margin-top: 3px;
}
.total-cays {
    font-size: 18px;
    background-color: #000;
    color: #f4fb6b
}
.diff-row {
    color: red;
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 768px) {
body {
    padding: 5px;
}
#resultTable {
    min-width: 100%;
}
#resultTable th:not(.player-name-col), #resultTable td:not(.player-name-col) {
    width: calc(70% / var(--num-players, 3)); /* Dynamic width */
}

 .controls {
               display: flex;        /* Kích hoạt Flexbox */
    gap: 10px;            /* Tạo khoảng cách giữa 2 nút */
    margin-bottom: 5px;
            }
          

 .action-button {
                /* Tính toán để có 2 nút trên 1 dòng */
                /* width: calc(50% - 5px); */ /* 50% trừ đi 1 nửa gap (10px/2) cho 2 nút liền kề */
                width: 48%; /* Hoặc dùng giá trị nhỏ hơn 50% để đảm bảo đủ chỗ cho gap */
                padding: 10px; /* Giảm nhẹ padding để tối ưu không gian */
                font-size: 14px; /* Giảm nhẹ font size */
            }
           


#largeScore {
    font-size: 136px;
    color: #FFFFFF;
    background: #0e8dbc;
    text-shadow: 0 1px 0 #CCCCCC, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9, 0 5px 0 #aaa, 0 6px 1px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1), 0 1px 3px rgba(0,0,0,.3), 0 3px 5px rgba(0,0,0,.2), 0 5px 10px rgba(0,0,0,.25), 0 10px 10px rgba(0,0,0,.2), 0 20px 20px rgba(0,0,0,.15);
}
}

@media (max-width: 480px) {
#largeScore {
    font-size: 124px;
    color: #FFFFFF;
    background: #0e8dbc;
    text-shadow: 0 1px 0 #CCCCCC, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9, 0 5px 0 #aaa, 0 6px 1px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1), 0 1px 3px rgba(0,0,0,.3), 0 3px 5px rgba(0,0,0,.2), 0 5px 10px rgba(0,0,0,.25), 0 10px 10px rgba(0,0,0,.2), 0 20px 20px rgba(0,0,0,.15);
}
}
/* 1. Đặt thuộc tính dính (sticky) cho thẻ <thead> */
#resultTable thead {
    /* Quan trọng: Đặt thead dính vào vị trí top: 0 */
    position: sticky;
    top: 0;
    /* Đảm bảo thead nằm trên nội dung khi cuộn */
    z-index: 10;
    /* Thêm màu nền để nội dung phía dưới không bị nhìn xuyên qua */
    background-color: #f7f7f7;
}
/* 2. Đảm bảo thẻ <th> lấp đầy toàn bộ chiều rộng (nếu cần thiết) */
#resultTable th {
    /* Tùy chỉnh thêm: Có thể áp dụng màu nền khác nếu muốn */
    background-color: #e0e0e0;
    padding: 10px; /* Thêm khoảng cách cho dễ nhìn */
    text-align: left; /* Căn chỉnh nội dung */
}
.view-btn {
    background-color: #4CAF50;
    font-weight: bold
}
.table-container {
    flex-grow: 1; /* Quan trọng: Cho phép container này giãn nở */
    /* Thiết lập cuộn cho bảng bên trong */
    overflow-y: auto;
}
.action-button {
    padding: 8px 15px;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    flex-grow: 1; /* QUAN TRỌNG: Cho phép nút giãn ra để lấp đầy không gian */
    white-space: nowrap;
       width: 48%; /* Hoặc dùng giá trị nhỏ hơn 50% để đảm bảo đủ chỗ cho gap */
                padding: 10px; /* Giảm nhẹ padding để tối ưu không gian */
                font-size: 14px; 
}
#biMucTieuTable {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
#biMucTieuTable th, #biMucTieuTable td {
    border: 1px solid #ddd;
    padding: 4px;
    text-align: center;
}
#biMucTieuTable th {
    background-color: #add8e6;
    font-weight: bold;
}
#biMucTieuTable td {
    vertical-align: top;
}
#baiCuaBan, #cayDaAn {
    width: 50%;
    background-color: #f9f9f9;
}
#biMucTieuTable td {
    vertical-align: top;
}
#eatenTable {
    border-collapse: collapse;
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    width: 100%;
    table-layout: fixed;
}
#eatenTable th, #eatenTable td {
    border: 1px solid #ddd;
    padding: 4px;
    text-align: center;
    vertical-align: top
}
#eatenTable thead {
    background-color: #f0ffdd;
    font-weight: bold;        
    z-index:10;
}
#eatenTable td {
    vertical-align: top;
}
.deskcard {
    cursor: pointer;
    width: 46%;
    margin: 2px;
    transition: opacity 0.3s ease, transform 0.3s ease;
    border-radius: 3px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
.nutbocnoc {
    cursor: pointer;
    width: 50%;
    margin: 2px;
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.deskcard:hover, .nutbocnoc:hover {
    transform: scale(1.20);
}
.deskcard.disabled {
    pointer-events: none;
    opacity: 0.3;
}
#eatenTable .deskcard {
    pointer-events: none;
    width: 100%;
    display: block;
    /* Các thuộc tính này cần thiết cho hiệu ứng xếp chồng */
    position: relative;
    /* Z-index sẽ được điều chỉnh cho từng lá bài */
    z-index: 1;
    /* Khoảng dịch chuyển: -99% chiều cao sẽ chồng gần như hoàn toàn */
    margin-top: -99%; 
}
.poolball {
    width: 23%;
    margin: 1%;

}



.image-stack {
    position: relative; /* Quan trọng: đặt khung tham chiếu cho ảnh con */
    display: inline-block; /* Giúp container ôm vừa nội dung */
}
#eatenTable .deskcard:first-child {
    margin-top: 0;
}
.caythoi {
    opacity: 0.3;
}



/* CSS MỚI CHO HIỆU ỨNG HIỂN THỊ LÁ BÀI LỚN */
#cardDisplayOverlay {
    position: fixed; /* Cố định vị trí trên màn hình */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Nền mờ */
    display: none; /* Mặc định ẩn */
    justify-content: center; /* Căn giữa theo chiều ngang */
    align-items: center; /* Căn giữa theo chiều dọc */
    z-index: 9999; /* Đảm bảo luôn hiển thị trên cùng */
    opacity: 0; /* Mặc định trong suốt để chuẩn bị cho fade-in */
    transition: opacity 0.5s ease-out; /* Hiệu ứng chuyển đổi cho độ mờ */
}

#cardDisplayOverlay img {
    max-width: 90vw; /* Chiều rộng lá bài bằng 80% chiều rộng khung nhìn */
    height: auto;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
    transform: scale(1); /* Đảm bảo không bị co dãn ban đầu */
}

#BallDisplayOverlay {
    position: fixed; /* Cố định vị trí trên màn hình */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Nền mờ */
    display: none; /* Mặc định ẩn */
    justify-content: center; /* Căn giữa theo chiều ngang */
    align-items: center; /* Căn giữa theo chiều dọc */
    z-index: 9999; /* Đảm bảo luôn hiển thị trên cùng */
    opacity: 0; /* Mặc định trong suốt để chuẩn bị cho fade-in */
    
    transition: opacity 0.5s ease-out; /* Hiệu ứng chuyển đổi cho độ mờ */
}

#BallDisplayOverlay img {
    max-width: 90vw; /* Chiều rộng lá bài bằng 80% chiều rộng khung nhìn */
    height: auto;   
    transform: scale(1); /* Đảm bảo không bị co dãn ban đầu */
}

.ballan {width:26px; margin-right:3px}

#fixed-box {
    /* Đảm bảo div luôn ở vị trí cố định trên màn hình */
    position: fixed;
    top: 5px;       /* Cách mép trên 20px */
    left: 5px;      /* Cách mép trái 20px */
    z-index: 1000;  /* Đảm bảo nó luôn nằm trên các thành phần khác */
    
    /* Thiết lập Flexbox để căn chỉnh ảnh và đồng hồ ngang hàng */
    display: flex; /* BẮT BUỘC */
    align-items: center; /* Căn giữa theo chiều dọc */
    justify-content: space-around; /* Căn đều khoảng cách (hoặc flex-start nếu bạn muốn sát mép trái) */

    width: 70px;    /* Đảm bảo có đủ không gian cho cả ảnh và số */
    white-space: nowrap; /* Giữ nguyên thuộc tính này cho chắc chắn, nhưng Flexbox sẽ ưu tiên hơn */

    /* Thiết kế hộp */
    background-color: white; /* Nền trắng */
    padding-right: 5px;           /* Khoảng đệm bên trong */
    
    /* Viền bo tròn màu xanh đậm */
    border: 2px solid #004085; /* Viền 2px, màu xanh đậm */
    border-radius: 4px;       /* Bo tròn góc */
    
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Tạo bóng nhẹ */
}

/* Quan trọng: Điều chỉnh lại #countdown để nó hiển thị nội tuyến */
#countdown {
    font-family: sans-serif;
    font-style: normal;
    font-weight: bold;
    color: rgb(0, 0, 0);
    font-size: 22px;    
    /* Thêm một chút lề trái để tách khỏi ảnh */
   
}


.cardthoi {width:22%; margin:3px}

  

</style>
</head>
<body>
	
	
	
<?php


// Store the cipher method
$ciphering = "aes-256-cbc";
$options = 0;
$encryption_iv = '1234567891011121';
$encryption_key = "The Ministry of Public Security";

$decryption_iv = '1234567891011121';
$decryption_key = "The Ministry of Public Security";

$NguoiChoi="";
$TenNguoiChoi="";

if ( !isset( $_GET[ "u" ] ) )$encryption = "";
else {
    $encryption = $_GET[ "u" ];
    $NguoiChoi = openssl_decrypt( $encryption, $ciphering, $decryption_key, $options, $decryption_iv );
}

$ban=1;
if ( isset( $_GET["b"] ) ) $ban=$_GET["b"];

if ($NguoiChoi!="") { $TenNguoiChoi="của ".$NguoiChoi; }

$CheckQuyen = KiemTraQuyen();

if ($CheckQuyen==3) $NguoiChoi="";
function KiemTraQuyen() {
    if ( !isset( $_GET[ 'u' ] ) || !isset( $_GET[ 'p' ] ) ) {
        return 0;
    }

    $encrypted_u = $_GET[ 'u' ];
    $encrypted_p = $_GET[ 'p' ];

    $ciphering = "aes-256-cbc";
    $options = 0;
    $decryption_iv = '1234567891011121';
    $decryption_key = "The Ministry of Public Security";

    $u = openssl_decrypt( $encrypted_u, $ciphering, $decryption_key, $options, $decryption_iv );
    $p = openssl_decrypt( $encrypted_p, $ciphering, $decryption_key, $options, $decryption_iv );

    include 'config.php';

    try {
        $pdo = new PDO( "mysql:host=$host;dbname=$dbname", $username, $password );
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        // SỬA LỖI FONT: Thiết lập charset cho phiên kết nối MySQL
        $pdo->exec( "SET NAMES 'utf8'" );
    } catch ( PDOException $e ) {
        return 0;
    }

    $stmt = $pdo->prepare( "SELECT COUNT(*) FROM billiards_users WHERE Ten = ? AND Pass = ?" );
    $stmt->execute( [ $u, $p ] );
    $count = $stmt->fetchColumn();

    if ( $count == 0 ) {
        return 0;
    } else {
        $result = 1;
    }

    if ( $result == 1 ) {
        // Kiểm tra tiếp billiards_deals
        $stmt = $pdo->prepare( "SELECT COUNT(*) FROM billiards_deals WHERE player_name = '" . "HAND_" . $u . "'" );
        $stmt->execute();
        $playerCount = $stmt->fetchColumn();

        if ( $playerCount > 0 ) {

            $result = 2;

        } else {
            $result = 3;
        }
    }

    return $result;
}


if ( $CheckQuyen == 0 ) {
    echo( "<a href='index.php'>Quay lại trang Đăng nhập</a></body></html>" );
    exit;
}


?>
<audio id="dynamicAudioPlayer"></audio>
<audio id="playlistAudioPlayer"></audio>
	
	 <div id="fixed-box" style="display:none">
      <img src="img/clock.gif" style="width:35px" /><div id="countdown" ></div>
      </div>
	
	
<div class="controls">
  <button class="action-button" id="BatDauBamGio" style="background-color: #b32511; font-weight:bold"  >Bấm giờ</button>
  <button class="action-button view-btn" id="ViewScore">Kết quả <?php echo($TenNguoiChoi);?></button>
</div>
<div id="ScoreDiv" style="<?php if ($CheckQuyen==2) echo("display:none");  if ($CheckQuyen==3) echo("display:block");  ?>">
  <select id="playerSelect" style="<?php if ($CheckQuyen==2) echo("display:none");  if ($CheckQuyen==3) echo("display:block");           ?>  ">
    <option value="">-- Chọn người chơi --</option>
  </select>
  <div style="width:100%; text-align:center; background: #0e8dbc; padding-bottom:8px"><span id="largeScore"></span> <span id="ThuTuChoi" style="font-weight:bold; color:#fff;"></span></div>
  <div class="table-container">
    <table id="resultTable">
      <thead>
        <tr id="headerRow">
          <th class="player-name-col" style="font-weight:bold">Kết quả</th>
        </tr>
        <tr id="totalCaysRow"  ></tr>
      </thead>
      <tbody id="resultBody">
      </tbody>
    </table>
  </div>
</div>
<div id="DeskDiv"  style="<?php if ($CheckQuyen==3) echo("display:none");  if ($CheckQuyen==2) echo("display:block");  ?>">
  <table id="biMucTieuTable" border="1" style="width:100%; margin-bottom:20px;">
    <tr>
      <th style="width:50%">Bi mục tiêu</th>
      <th style="width:50%">Bốc sẹo</th>
    </tr>
    <tr>
      <td id="BiMucTieu"></td>
      <td id="BocNoc" style="padding:4px"></td>
    </tr>
    <tr>
      <th style="width:50%">Bài <?php echo($TenNguoiChoi);?></th>
      <th style="width:50%">Cây bạn đã ăn</th>
    </tr>
    <tr>
      <td id="baiCuaBan"></td>
      <td id="cayDaAn"></td>
    </tr>
  </table>
  <table id="eatenTable" border="1" style="width:100%;">
    <thead id="eatenHeader" >
    </thead>
    <tbody id="eatenBody">
    </tbody>
  </table>
</div>
	
	
	<div id="cardDisplayOverlay">
    </div>
	<div id="BallDisplayOverlay">
    </div>
	
<script>
	
	
	$.fn.isInViewport = function() {
    var element = $(this);
    var viewport = $(window);

    var elementTop = element.offset().top;
    var elementBottom = elementTop + element.outerHeight();

    var viewportTop = viewport.scrollTop();
    var viewportBottom = viewportTop + viewport.height();

    // Check if any part of the element is within the viewport
    return elementTop < viewportBottom;
};

// Example usage:
$(window).on('scroll resize load', function() {
	
	
    if ($('#eatenTable').isInViewport()) {
    	
        $("#eatenTable thead").css({
        	"width": $("#eatenTable").width() + "px",	
        	"position": "sticky",  			
  			"top": "-1px"	
		});
			
    } else {
        console.log($(window).height());
        $("#eatenTable thead").css({
        	"position": "fixed",  			
        	"width": $("#eatenTable").width() + "px",	
  			"top": 100 - ( ($("#eatenHeader").height() / $(window).height() * 100) ) + "dvh"	
		});
        
    }
});
	
	
	
    let currentPlayer = '<?php echo($NguoiChoi);?>'.trim();
    let timecount = 0;

    const storageKey = 'selectedPlayerID'; 
    

    const tableId = "<?php echo htmlspecialchars($ban); ?>";


    $(document).ready(function(){
        $("#ViewScore").click(function(){
            $("#ScoreDiv").toggle(); 
            if($('#ScoreDiv').is(':visible')) { $("#ViewScore").html('Ẩn bảng thống kê');} else { $("#ViewScore").html('Kết quả <?php echo($TenNguoiChoi);?>');}
        });
    });
    
    
    /**
         * Kiểm tra xem tất cả các giá trị "ANBI_" trong deskData.hands có phải là chuỗi rỗng hay không.
         * @param {object} deskData - Đối tượng JSON chứa dữ liệu bàn chơi.
         * @returns {boolean} - Trả về TRUE nếu tất cả các giá trị ANBI_ đều rỗng, FALSE nếu có bất kỳ giá trị nào khác rỗng.
         */
        function areAllAnbiEmpty(deskData) {
            // Đảm bảo đối tượng và mảng 'hands' tồn tại
            if (!deskData || !deskData.hands || !Array.isArray(deskData.hands)) {
                console.error("Dữ liệu deskData hoặc hands không hợp lệ.");
                return false; 
            }

            const anbiPrefix = "ANBI_";

            // Sử dụng phương thức 'every' để kiểm tra tất cả các phần tử thỏa mãn điều kiện
            const allEmpty = deskData.hands.every(item => {
                // Chỉ xử lý các chuỗi bắt đầu bằng "ANBI_"
                if (item.startsWith(anbiPrefix)) {
                    // Cấu trúc: "ANBI_TênNgườiChơi:GiáTrị"
                    // Lấy giá trị sau dấu hai chấm (:)
                    const value = item.substring(item.indexOf(':') + 1).trim();

                    // Nếu bất kỳ giá trị nào không rỗng, hàm 'every' sẽ dừng và trả về FALSE
                    if (value !== "") {
                        return false; 
                    }
                }
                
                // Nếu không phải là mục ANBI_, hoặc là mục ANBI_ và rỗng, tiếp tục vòng lặp
                return true;
            });

            return allEmpty;
        }
    
    /**
     * Hàm xử lý dữ liệu nhận được từ SSE (thay thế cho logic loadData() cũ)
     * @param {string} response - Dữ liệu JSON string tổng hợp từ stream.php
     */
    
     
    function handleSseData(response) {
        let combinedData;
        try {
            // Bước 1: Parse JSON tổng thể từ SSE stream
            combinedData = JSON.parse(response);
        } catch (e) {
            console.error("Lỗi parse JSON tổng thể từ SSE:", e);
            return;
        }

        const gameDataJsonString = combinedData.game_data || '{}';
        const thutuchoi = combinedData.thutuchoi || '';
        const deskData = combinedData.desk_data || {}; // <<-- DÒNG MỚI: Lấy dữ liệu bài/bàn

        // Kiểm tra dữ liệu bị lặp (chống lag)
        if (typeof window._prevLoadResponse !== 'undefined' && response === window._prevLoadResponse) {
            return;
        }
        window._prevLoadResponse = response;

        

        
        
        
        // DÒNG MỚI: GỌI HÀM XỬ LÝ DỮ LIỆU BÀN/BÀI
        if (Object.keys(deskData).length > 0) {
            handleDeskData(deskData); 
        }

        let data;
        try {
            // Bước 2: Parse JSON dữ liệu game chính
            data = JSON.parse(gameDataJsonString);
        } catch (e) {
            data = {};
            console.error("Lỗi parse JSON dữ liệu game:", e);
            return;
        }
                
        const players = data.players || [];
        const gameCount = data.settings ? data.settings.gameCount || 20 : 20;
        
        const select = $('#playerSelect');
        const options = ['<option value="">-- Chọn người chơi --</option>'];
        
        players.forEach(p => {
            options.push(`<option value="${p.name}" ${p.name === currentPlayer ? 'selected' : ''}>${p.name}</option>`);
        });
        select.html(options.join(''));
        
        const headerRow = $('#headerRow');
        headerRow.html('<th class="player-name-col" style="font-weight:bold; color:#f4fb6b">#</th>');
        players.forEach(p => {
            headerRow.append(`<th style="color:#d4f3ff">${p.name}</th>`);
        });
        
        document.documentElement.style.setProperty('--num-players', players.length);
        
        const body = $('#resultBody');
        body.empty();
        
        let maxGame = 0;
        players.forEach(p => {
            p.scores.forEach((score, idx) => {
                if (score.trim()) maxGame = Math.max(maxGame, idx + 1);
            });
        });
        
        for (let i = 1; i <= maxGame; i++) {
            let row = `<tr><td class="player-name-col">Ván ${i}</td>`;
            players.forEach(p => {
                        const score = p.scores[i-1] || '';
                        let className = '';
                        const lowerScore = score.trim().toLowerCase();
                        if (lowerScore === '0u') className = 'score-0u';
                        else if (lowerScore.endsWith('m')) className = 'score-m';
                        else if (lowerScore.endsWith('u')) className = 'score-u';
                        else if (lowerScore.endsWith('s')) className = 'score-s';
                        else if (!isNaN(parseInt(lowerScore))) className = 'game-score-col';
                        
                        row += `<td class="${className}">${score}</td>`;
            });
            row += '</tr>';
            body.append(row);
            
            
         ///// Thêm dòng bi đã ăn /////////////////////////////   
            row = `<tr class="dongbi"><td></td>`;
            players.forEach(p => {
                         const bi = p.bi[i-1] || '';                        
                        row += '<td >' + generateBallImages(bi) + '</td>';
            });
            row += '</tr>';
            body.append(row);            
        }
        ////////////////
        
           
        
        //////////////////////////
        const playersData = players.map(p => {
            let cays = 0, moms = 0, us = 0, scars = 0;
            let totalBi = 0; // <<-- KHỞI TẠO BIẾN MỚI
            
            p.scores.slice(0, maxGame).forEach((score, index) => {
                const lower = score.trim().toLowerCase();
                if (!lower) return;
                cays += extractNumericScore(lower);
                if (lower.endsWith('m')) moms++;
                else if (lower.endsWith('u')) us++;
                else if (lower.endsWith('s')) scars++;
                
                // TÍNH TOÁN TỔNG BI ĐÃ ĂN
                const biForGame = p.bi[index] || '';
                totalBi += countStringElements(biForGame);
            });
            
            return { name: p.name, cays, moms, us, scars, totalBi }; // <<-- THÊM totalBi VÀO PLAYER DATA
        });
        
        playersData.sort((a, b) => {
            if (a.cays !== b.cays) return a.cays - b.cays;
            if (a.us !== b.us) return b.us - a.us;
            if (a.moms !== b.moms) return a.moms - b.moms;
            return a.scars - b.scars;
        });
        
        const leader = playersData[0];
        const venhi = playersData[1];
        
        const totalCaysRow = $('#totalCaysRow');
        let cayCells = `<th class="player-name-col" style="background-color:#116281;color:#f4fb6b">Tổng số cây</th>`;
        players.forEach(p => {
            const player = playersData.find(pd => pd.name === p.name);
            cayCells += `<th class="total-cays">${player.cays}</th>`; 
        });
        totalCaysRow.html(cayCells);
        
        let uRow = '<tr><td class="total-us">Số ván Ù</td>';
        players.forEach(p => {
            const player = playersData.find(pd => pd.name === p.name);
            uRow += `<td class="total-us">${player.us}</td>`;
        });
        uRow += '</tr>';
        body.append(uRow);
        
        let momRow = '<tr><td class="player-name-col">Số ván móm</td>';
        players.forEach(p => {
            const player = playersData.find(pd => pd.name === p.name);
            momRow += `<td class="total-moms">${player.moms}</td>`;
        });
        momRow += '</tr>';
        body.append(momRow);
        
        let scarRow = '<tr><td class="player-name-col">Số ván sẹo</td>';
        players.forEach(p => {
            const player = playersData.find(pd => pd.name === p.name);
            scarRow += `<td class="total-scars">${player.scars}</td>`;
        });
        scarRow += '</tr>';
        body.append(scarRow);
        
        let diffRow = '<tr><td class="player-name-col">Chênh lệch với người dẫn đầu</td>';
        players.forEach(p => {
            const player = playersData.find(pd => pd.name === p.name);
            const diff = player.cays - leader.cays;
            diffRow += `<td class="diff-row">${diff > 0 ? '+' + diff : diff}</td>`;
        });
        diffRow += '</tr>';
        body.append(diffRow);
        
        // --- DÒNG THỐNG KÊ TỔNG SỐ BI ĐÃ ĂN (DÒNG MỚI) ---
        let totalBiRow = '<tr><td class="player-name-col" >Số bi đã ăn</td>';
        players.forEach(p => {
            const player = playersData.find(pd => pd.name === p.name);
            totalBiRow += `<td style="font-weight:bold; background-color:#fff; color:#0056b3">${player.totalBi}</td>`;
        });
        totalBiRow += '</tr>';
        body.append(totalBiRow);
        // ----------------------------------------------------
        
        if (currentPlayer) {
            const selected = playersData.find(pd => pd.name === currentPlayer);
            if (selected) {
                $('#largeScore').text(selected.cays).show();
            }
        } else {
            $('#largeScore').hide();
        }
        
        // Cập nhật Thứ tự chơi
         if (maxGame>0) $('#ThuTuChoi').text(thutuchoi);
        
        /////////////// Nói /////////////
        
        
        
        if (navigator.userActivation.hasBeenActive) {
         if (areAllAnbiEmpty(deskData)) 
         {
            playMp3("voice/baimoi.mp3");
            let docthutu = thutuchoi.replaceAll(">",", rồi đến");
            const selected = playersData.find(pd => pd.name === currentPlayer);            
            var diff = parseInt(selected.cays) - parseInt(leader.cays);
                        
            const khendandau = [
  "Đánh thế ai chơi lại bạn",
  "Bạn đánh hay vãi cứt",  
  "Bạn đánh nét vãi lồn",
  "Bạn vừa hay lại vừa hên",
  "Bạn được thần rùa phù hộ",  				  
  "Đừng vội mừng, thằng "+venhi.name+" nó đang đuổi sát bạn đấy",
  "Bạn nhường các bạn khác tí đi",
  "Hôm nay thần rùa phù hộ bạn rồi",
  "Chơi thế này để ai còn động lực thi đấu với bạn",
  "Thắng mãi không chán à bạn?",
  "Tập trung đánh không là thằng "+venhi.name+" nó đuổi kịp đấy",
  "Ở trên cao gió mát quá",
  "Đỉnh cao của ăn rùa là đây",
  "Đánh nét vãi, hôm nay bạn lại không phải trả tiền rồi",
  "Bạn dẫn đầu mãi mà không ngại à",  
  "Nếu cứ đánh như thế này thì các bạn khác bỏ về hết",
  "Đánh giữ khách tí đi bạn",  
  "Bạn dẫn đầu mãi không chán à",
  "Bạn đánh chậm lại chờ anh em với chứ",  
  "Bạn thắng ít thôi không đối thủ bỏ về hết"
];
			
const cauKhenDeuNguoiThuaCuoc = [
  "Cố lên, sắp đuổi kịp "+leader.name + " rồi",
  "Cố lên, khoảng cách bây giờ chỉ là tạm thời!",
  "Cố lên bạn ơi không là phải chia tiền đấy",
  "Thể hiện Đẳng cấp thực sự của bạn đi nào!",
  "Bạn đánh thế này thì mấy mà phải chia tiền",
  "Cố lên bạn, thằng "+leader.name + " hôm nay được thần rùa phù hộ",
  "Chơi thế này mãi là phải chia tiền đấy",
  "Bạn đang nhường đối thủ quá đà rồi!",
  "Thời tới là cản không kịp, nhưng mãi chưa tới thời của bạn",
  "Bạn lại nhường thằng "+leader.name + " để nó chủ quan à",
  "Cố làm Cú Lội Ngược Dòng vĩ đại đi bạn",
  "Cố lên bạn, Người dẫn đầu không phải đông phương Bất Bại đâu",
  "Hy vọng ván này thần rùa sẽ phù hộ bạn",
  "Đánh nét vào nếu không muốn trả tiền",
  "Cờ bạc ăn nhau về sáng, cố lên bạn",
  "Đây là lúc bạn cần đánh nắn nót vào",
  "Hôm nay bạn cố tình nhường đối thủ à",
  "Chơi thế này thì bao giờ mới đuổi kịp được thằng "+leader.name,
  "Cố lên, đừng để thằng "+leader.name+" dẫn đầu lâu quá",
  "Bình tĩnh mà đánh thôi bạn ơi",
  "Ôi bạn ơi, hôm nay bạn đánh như lồn ấy",
  "Hôm nay thần rùa không phù hộ bạn rồi",
  "Đừng để thằng "+leader.name + " ngồi lên đầu bạn như thế nữa",
  "Cố lên Bạn, sắp không phải chia tiền rồi",
  "Phong độ là nhất thời, đẳng cấp là mãi mãi, cố lên bạn",
  "Bạn đánh thế này thì không đuổi kịp thằng "+leader.name + " đâu",
  "Đánh nét lên đi bạn ơi, xem tíc tóc ít thôi",
  "Bạn đang chờ đối thủ tự thua à?",
  "Đánh thế này thì còn chia tiền dài dài",
  "Bạn định khi nào mới tăng tốc đấy?",
  "Đánh thế này thì bao giờ mới đuổi được thằng "+leader.name,  
  "Hôm nay thần rùa không hiển linh rồi",
  "Thôi bạn đừng cố nữa, chấp nhận Vị Trí hiện tại đi",
  "Cố lên, biết đâu bạn không phải chia tiền",
  "Tập trung vào đánh đi nếu không muốn phải chia tiền",
  "Bạn đang nhường đối thủ à"
];			
         let ran1 = Math.floor(Math.random() * khendandau.length)            
         let ran2 = Math.floor(Math.random() * cauKhenDeuNguoiThuaCuoc.length) 
                        
                        
                        
            let sosanhvoinhat='';
            if (diff==0) sosanhvoinhat='Hiện nay '+selected.name+' đang dẫn đầu.'+khendandau[ran1] ; else sosanhvoinhat='Đang kém '+leader.name+' người dẫn đầu là '+parseInt(diff)+ ' cây.'+cauKhenDeuNguoiThuaCuoc[ran2];
            
            if (maxGame>0)
            {
                setTimeout(() => {
                // responsiveVoice.speak("Đây là ván thứ "+ (maxGame+1) + ". Thứ tự chơi ván này là: "+ docthutu + "."  +currentPlayer + " đang có số cây là "+selected.cays + " cây. Đã ù "+ selected.us + " ván, móm "+ selected.moms + " ván."+sosanhvoinhat, "Vietnamese Male" );            
                responsiveVoice.speak("Đây là ván thứ "+ (maxGame+1) + ". Thứ tự chơi ván này là: "+ docthutu, "Vietnamese Male" );            
                }, 1700); 
            }
         };
        } else {
        console.log("User has not yet interacted with the page.");
        }
         
        
        
        
        
    }
    ////// ẩn / hiện bi trên bảng thống kê
    
    $("#resultBody").click(function() {
    $(".dongbi").toggle();     
    });
    
   // Hàm sinh ảnh bi đã ăn 
    function generateBallImages(handStr) {
    if (!handStr) {
        return ''; // Trả về chuỗi rỗng nếu đầu vào rỗng hoặc null
    }
      handStr = handStr.toUpperCase();
    // 1. Tách chuỗi thành mảng các ký tự (ví dụ: ["1", "5", "A", "K"])
    const cardsArray = handStr.split(',').map(s => s.trim()).filter(s => s.length > 0);
    
    let htmlOutput = '';

    // 2. Lặp qua mảng và tạo thẻ <img>
    cardsArray.forEach(card => {
        // Chuẩn hóa tên file: chuyển sang chữ thường (ví dụ: A -> a, K -> k)
        const fileName = card; 

        // Tạo thẻ <img> với đường dẫn và class "ball"
        htmlOutput += `<img src="ball/${fileName}.png" class="ballan" alt="${card}">`;
    });

    return htmlOutput;
}
    
    
    
    // Khởi tạo và quản lý kết nối SSE
    function startSseStream() {
        if (window.sseSource) {
            window.sseSource.close(); // Đảm bảo đóng kết nối cũ
        }
        
        // Tạo EventSource kết nối tới file stream.php
        // EventSource là cơ chế tự động kết nối lại nếu bị ngắt, giúp giải quyết lỗi bạn gặp
        window.sseSource = new EventSource('stream_load.php?b=' + tableId); 



        // Lắng nghe sự kiện 'message' mặc định từ stream.php
        window.sseSource.onmessage = function(event) {        	
            handleSseData(event.data);
        };
  
       
  
        // Xử lý lỗi kết nối
        window.sseSource.onerror = function(err) {
            console.error("Lỗi EventSource:", err);
        };
    }
    
    function extractNumericScore(value) {
        const match = value.match(/^\s*(\d+)/);
        return match ? parseInt(match[1]) : 0;
    }
    
    $(document).ready(function() {
        const savedID = localStorage.getItem(storageKey);
        if (savedID) {
        	<?php
        	if ($CheckQuyen==2)	echo ("currentPlayer = '".$NguoiChoi."';");
        	if ($CheckQuyen==3)	echo ("currentPlayer = savedID;");
	        
		        		?>
             
        }
        else
        {
            currentPlayer='<?php echo($NguoiChoi);?>';
        }
        startSseStream(); // <--- Bắt đầu luồng SSE, thay thế loadData() và setInterval(loadData, 5000)
        
        $('#playerSelect').change(function() {        	
            currentPlayer = $(this).val();
            localStorage.setItem(storageKey, currentPlayer);             
            location.reload();
        });
        
      //  loadDesk();
      //  setInterval(loadDesk, 1000);
    });
    
  
    function generateCardImages(cardsString, disabledCards = []) {
      let cardsPart = cardsString;
      
      if (disabledCards && disabledCards.length > 0) {
        cardsPart += ',' + disabledCards.join(',');
      }
      
      if (cardsString.includes(':')) {
        cardsPart = cardsString.split(':')[1].trim() + (disabledCards && disabledCards.length > 0 ? ',' + disabledCards.join(',') : '');
      }
      const cards = cardsPart.split(',').filter(card => card.trim());
      return cards.map(card => {
        let code = card.trim().toUpperCase();
        if (/^(A|[2-9]|10|J|Q|K)[RCBT]$/.test(code)) {
          const isDisabled = disabledCards.includes(code);
          return `<img src="desk/${code}.svg" class="deskcard ${isDisabled ? 'disabled' : ''}" data-code="${code}">`;
        }
        return '';
      }).join('');
    }
	
	 function generateThoiCardImages(cardsString) {
      let cardsPart = cardsString;
      
    
      const cards = cardsPart.split(',').filter(card => card.trim());
      return cards.map(card => {
        let code = card.trim().toUpperCase();
        if (/^(A|[2-9]|10|J|Q|K)[RCBT]$/.test(code)) {
          
          return `<img src="desk/${code}.svg" class="deskcard caythoi" data-code="${code}">`;
        }
        return '';
      }).join('');
    }
    
   /**
     * Hàm xử lý dữ liệu Bài/Bàn nhận được từ SSE (thay thế cho logic loadDesk() cũ)
     * @param {object} data - Dữ liệu đã được parse từ desk_data trong SSE
     */
     let Desk;
     
    function handleDeskData(data) {
        // Toàn bộ logic AJAX đã được loại bỏ. Dữ liệu bàn/bài được truyền vào qua tham số 'data'.

        const hand = data.hands.find(h => h.startsWith('HAND_' + currentPlayer + ':'));
        const an = data.ans.find(a => a.startsWith('AN_' + currentPlayer + ':'));
        const thoi = data.thoi.find(t => t.startsWith('THOI_' + currentPlayer + ':'));
        Desk=data;
        let disabledCards = thoi ? thoi.split(':')[1].split(',').map(c => c.trim().toUpperCase()) : [];
        let HandCards = hand ? hand.split(':')[1].split(',').map(c => c.trim().toUpperCase()) : [];
        
        $('#BiMucTieu').html(Get_BiMucTieu(hand));
               
        
        if ((checkAnyPlayerU(data)) && (extractValue(data.hands, "NguoiVuaHaBai")!=currentPlayer))
        disabledCards = disabledCards.concat(HandCards);
        
        if (hand) {
            $('#baiCuaBan').html(generateCardImages(hand, disabledCards));
        } else {
            $('#baiCuaBan').html('');
        }
        
        if (an) {
            $('#cayDaAn').html(generateCardImages(an));
        } else {
            $('#cayDaAn').html('');
        }
        
        let songuoichoi=0;
        let header = '<tr>';
        let row = '<tr>';
        data.ans.forEach(a => {
            
            songuoichoi++;
            const name = a.split(':')[0].substring(3);
            
            ///// Đếm số cây của từng người chơi
        const an1 = data.ans.find(h => h.startsWith('AN_' + name + ':'));
        const hand1 = data.hands.find(h => h.startsWith('HAND_' + name + ':'));
          	const thoi1 = data.thoi.find(t => t.startsWith('THOI_' + name + ':'));               
          	const noc1 = data.bocnoc.find(t => t.startsWith('NOC_' + name + ':'));               
          	const handCount = hand1 ? hand1.split(':')[1].split(',').filter(c => c.trim()).length : 0;
            const anCount = an1 ? an1.split(':')[1].split(',').filter(c => c.trim()).length : 0;
            const thoiCount = thoi1 ? thoi1.split(':')[1].split(',').filter(c => c.trim()).length : 0;
            const seoCount = noc1 ? noc1.split(':')[1].split(',').filter(c => c.trim()).length : 0;
            const socay=handCount+thoiCount;
            	/////////////////////////////////
            
            
                     let uhaymom= checkPlayerStatus(data,name);
                     
        let Bao=BaoU(hand1);
        
        if (uhaymom=="Ù ") Bao="<br><span class='baou'>Ù</span>";
            
            header += `<th>${name}<br><b style="color:#ff0000; font-size:15px">(${uhaymom}${socay} cây)</b>
            <br><span style="color:#1d661c; font-size:13px; font-weight:normal">(Ăn <b style="color:#0b6bfb;">${anCount}</b> cây, thối <b style="color:#0b6bfb;">${thoiCount}</b> cây, bốc sẹo <b style="color:#0b6bfb;">${seoCount}</b> cây, còn <b style="color: #f30dcc; font-size:15px">${handCount}</b> cây để ăn)</span> ${Bao}
            </th>`;
            row += `<td><div class="image-stack">${generateCardImages(a)}</div></td>`;
        });
        header += '</tr>';
        row += '</tr>';
        
        
        /////////// Hiển thị cây đã bốc sẹo
      
        header += '<tr>';
        
		
		row += `<tr><td style="background:#682525; font-weight:bold; color:#fff" colspan="${songuoichoi}">Cây bốc sẹo được</td></tr>  <tr><tr style="background:#ffbbbb">`;
		
        data.bocnoc.forEach(a => {                	
            const name = a.split(':')[0].substring(4);                    
            row += `<td>${name} ${generateCardImages(a)}</td>`;
			
        });
        
        row += '</tr>';
		
		
		   /////////// Hiển thị cây thối
        
        header += `<tr>`;
        row += `<tr><td style="background:#116281; font-weight:bold; color:#fff" colspan="${songuoichoi}">Cây thối</td></tr>  <tr><tr style=" opacity:0.3">`;
        data.thoi.forEach(a => {                	
            const name = a.split(':')[0].substring(5);                                        
            row += `<td>${name} ${generateCardImages(a)}</td>`;
        });
        
        row += '</tr>';
        
        //console.log(data.baiTrenNoc);
        let socaytrennoc = countStringElements(data.baiTrenNoc);
        if (socaytrennoc>0)
        {
        	let laboc=getRandomElement(data.baiTrenNoc);
        $("#BocNoc").html(`<img src="desk/back.svg" class="nutbocnoc" data-code="${laboc}" ><br><span>Nọc còn <b style="color:#0b6bfb;">${socaytrennoc}</b> cây</span>`);    
        }
        else
        {
        	$("#BocNoc").html(`<b style="color:#ff0000;">Nọc không còn cây nào phù hợp để bốc!</span>`);
        }
        
        $('#eatenHeader').html(header);
        $('#eatenBody').html(row);
    }


    
// =========================================================
// ************ HELPER FUNCTIONS (Cần thiết cho logic Ù/Móm) ************
// =========================================================

// Trích xuất giá trị sau dấu hai chấm (:)
const extractValue = (dataArray, prefix, pName = '') => {
    const fullPrefix = prefix + pName;
    
    // SỬA LỖI QUAN TRỌNG: 
    // Chúng ta phải đảm bảo rằng ký tự ngay sau fullPrefix là dấu hai chấm (':')
    // để tránh trường hợp 'Hoàng' khớp với 'Hoàng Anh'.
    const item = dataArray.find(s => s.startsWith(fullPrefix) && s[fullPrefix.length] === ':');

    if (item) {
        const colonIndex = item.indexOf(':');
        if (colonIndex !== -1) {
            // Sau khi tìm thấy chính xác, ta trả về giá trị sau dấu hai chấm
            return item.substring(colonIndex + 1).trim();
        }
    }
    return '';
};

// Đếm số lượng quân bài (phần tử cách nhau bởi dấu phẩy)
const getCardCount = (dataArray, prefix, pName = '') => {
    const value = extractValue(dataArray, prefix, pName);
    if (value === '') {
        return 0;
    }
    // Lọc bỏ các chuỗi rỗng sau khi tách
    return value.split(',').filter(s => s.trim() !== '').length;
};

// Kiểm tra điều kiện tiềm năng Ù (HAND_ rỗng và ANBI_ có >= 1)
const isPotentialU = (data, pName) => {
    const hCount = getCardCount(data.hands, "HAND_", pName);
    const aCount = getCardCount(data.hands, "ANBI_", pName);
    return hCount === 0 && aCount >= 1;
};

// =========================================================
// ************ HÀM 1: KIỂM TRA TRẠNG THÁI NGƯỜI CHƠI ************
// =========================================================

function checkPlayerStatus(data, playerName) {
    // LOGIC 1: KIỂM TRA MÓM (Ưu tiên cao nhất)
    const anCount = getCardCount(data.ans, "AN_", playerName);
    if (anCount === 0) {
        return "Móm ";
    }

    // LOGIC 2: KIỂM TRA Ù CƠ BẢN
    if (!isPotentialU(data, playerName)) {
        return "";
    }

    // LOGIC 3: KIỂM TRA ƯU TIÊN VÀ XÁC ĐỊNH Ù
    const nguoiVuaHaBai = extractValue(data.hands, "NguoiVuaHaBai");
    const isNguoiHaBaiU = isPotentialU(data, nguoiVuaHaBai);
    
    // A. Ù TRỰC TIẾP (Ưu tiên tuyệt đối)
    if (nguoiVuaHaBai === playerName) {
        return "Ù ";
    }

    // B. KHỐI CHẶN ƯU TIÊN TUYỆT ĐỐI
    if (isNguoiHaBaiU) {
        return ""; 
    }

    // C. XỬ LÝ Ù VÒNG / Ù ĐA
    const thuTuChoiStr = extractValue(data.hands, "ThuTuChoi");
    const isOrderEmpty = thuTuChoiStr.trim() === '';

    if (isOrderEmpty) {
        // TRƯỜNG HỢP THUTUCHOI RỖNG: Cho phép Ù đa 
        return "Ù ";
    }
    
    // TRƯỜNG HỢP THUTUCHOI KHÔNG RỖNG: Áp dụng Ù Vòng
    const playerOrderStr = thuTuChoiStr.replace(/ phá bi > /g, ',').replace(/ > /g, ',');
    const playerOrder = playerOrderStr.split(',').map(s => s.trim()).filter(s => s !== '');

    const haBaiIndex = playerOrder.indexOf(nguoiVuaHaBai);

    if (haBaiIndex === -1 || playerOrder.length === 0) {
        return ""; 
    }

    const totalPlayers = playerOrder.length;
    let playerWithHighestPriorityU = null;

    for (let i = 0; i < totalPlayers; i++) {
        const checkIndex = (haBaiIndex + 1 + i) % totalPlayers;
        const pName = playerOrder[checkIndex];
        
        if (isPotentialU(data, pName)) {
            playerWithHighestPriorityU = pName;
            break; 
        }
    }
    
    if (playerWithHighestPriorityU === playerName) {
        return "Ù ";
    }

    return "";
}

// =========================================================
// ************ HÀM 2: KIỂM TRA BẤT KỲ AI Ù ************
// =========================================================

function checkAnyPlayerU(data) {
    let playerNames = [];
    // ... (logic trích xuất playerNames không thay đổi) ...
    if (data && data.players && Array.isArray(data.players)) {
        playerNames = data.players.map(p => p.name);
    } else {
        const playerSet = new Set();
        (data.hands || []).forEach(line => {
            if (line.startsWith('HAND_') || line.startsWith('ANBI_')) {
                const namePart = line.substring(line.indexOf('_') + 1, line.indexOf(':')).trim();
                if (namePart) {
                    playerSet.add(namePart);
                }
            }
        });
        playerNames = Array.from(playerSet);
    }

    if (playerNames.length === 0) {
        return false;
    }

    for (const playerName of playerNames) {
        const status = checkPlayerStatus(data, playerName);
        
        if (status.trim().startsWith('Ù')) {	        	       
            return true;
            
        }
    }

    return false;
}





// Hàm 2: Lấy ra phần tử đầu tiên hợp lệ
function getFirstElement(inputStr) {
    // 1. Kiểm tra chuỗi rỗng
    if (!inputStr || inputStr.trim() === '') {
        return "(Chuỗi rỗng)";
    }

    // 2. Tách chuỗi thành mảng
    const elements = inputStr.split(',');

    // 3. Lọc và loại bỏ các phần tử rỗng hoặc chỉ chứa khoảng trắng
    const validElements = elements
        .map(element => element.trim()) // Loại bỏ khoảng trắng thừa
        .filter(element => element !== ''); // Loại bỏ phần tử rỗng

    // 4. Trả về phần tử đầu tiên nếu có
    if (validElements.length > 0) {
        return validElements[0];
    }

    return "(Không tìm thấy phần tử hợp lệ)";
}


// Hàm 3: Trả về một phần tử ngẫu nhiên hợp lệ
function getRandomElement(inputStr) {
    // 1. Kiểm tra chuỗi rỗng
    if (!inputStr || inputStr.trim() === '') {
        return "(Chuỗi rỗng)";
    }

    // 2. Tách chuỗi và lọc các phần tử hợp lệ
    const elements = inputStr.split(',');
    const validElements = elements
        .map(element => element.trim()) 
        .filter(element => element !== ''); 

    // 3. Nếu không có phần tử nào hợp lệ
    if (validElements.length === 0) {
        return "(Không tìm thấy phần tử hợp lệ)";
    }

    // 4. Tạo chỉ mục (index) ngẫu nhiên
    const randomIndex = Math.floor(Math.random() * validElements.length);

    // 5. Trả về phần tử tại chỉ mục ngẫu nhiên đó
    return validElements[randomIndex];
}



function getCardValue(cardCode) {
const rank = cardCode.slice(0, -1).toUpperCase();
const rankMap = {
'A': 1,
'2': 2,
'3': 3,
'4': 4,
'5': 5,
'6': 6,
'7': 7,
'8': 8,
'9': 9,
'10': 10,
'J': 11,
'Q': 12,
'K': 13
};
return rankMap[rank] || 0; // Trả về 0 nếu không hợp lệ
}






// Hàm đếm số cây trên chuỗi
function countStringElements(inputStr) {
    // 1. Kiểm tra chuỗi rỗng hoặc chỉ chứa khoảng trắng
    if (!inputStr || inputStr.trim() === '') {
        return 0;
    }
    // 2. Tách chuỗi bằng dấu phẩy (',') để tạo ra một mảng
    const elements = inputStr.split(',');
    // 3. Lọc bỏ các phần tử rỗng do có dấu phẩy thừa (ví dụ: "a,,b")
    // và loại bỏ khoảng trắng thừa ở hai đầu mỗi phần tử
    const validElements = elements.filter(element => element.trim() !== '');
    // 4. Trả về độ dài của mảng (số lượng phần tử)
    return validElements.length;
}
    

function getBallFileName(card) {
    let tenball = "";   
        if (!card || typeof card !== 'string') {
        return ""; // Trả về chuỗi rỗng nếu card không hợp lệ
    }
    
    if (card.length === 2) {
        tenball = card.substring(0, 1) + ".png"; 

    } else {
        tenball = card.substring(0, 2) + ".png";
    }
   
    return tenball;
}    
    


/**
 * Trích xuất giá trị (rank) của một lá bài (ví dụ: 7T -> 7, QR -> Q).
 * @param {string} cardCode Mã lá bài (ví dụ: 'AR', '10C', 'JT').
 * @returns {string} Giá trị (rank) của lá bài.
 */
const getCardRank = (cardCode) => {
    // Rank là tất cả ký tự trừ ký tự cuối cùng (là chất R, C, B, T)
    return cardCode.substring(0, cardCode.length - 1);
};

/**
 * Trích xuất chất (suit) của một lá bài (ví dụ: 7T -> T, QR -> R).
 * @param {string} cardCode Mã lá bài (ví dụ: 'AR', '10C', 'JT').
 * @returns {string} Chất (suit) của lá bài.
 */
const getCardSuit = (cardCode) => {
    // Suit là ký tự cuối cùng (R, C, B, T)
    return cardCode.substring(cardCode.length - 1);
};

/**
 * Tạo mã HTML hiển thị Tên người chơi và các quân bài cùng rank khác chất.
 * * @param {string} playerName Tên người chơi hiện tại (cần loại trừ).
 * @param {string} card Mã lá bài đang được kiểm tra (ví dụ: '7T').
 * @param {Object} data Đối tượng JSON chứa dữ liệu ván đấu.
 * @returns {string} Chuỗi mã HTML kết quả.
 */
function getSameRankCardsFromOtherPlayers(playerName, card, data) {
    let resultHtml = '';
    const targetRank = getCardRank(card);
    const targetSuit = getCardSuit(card);
    
    if (!targetRank) {
        // Nếu lá bài đầu vào không hợp lệ, thoát
        return resultHtml; 
    }

    // 1. Trích xuất tất cả các HAND_ và Tên người chơi
    const playerHands = data.hands.filter(s => s.startsWith('HAND_'));

    // 2. Duyệt qua từng người chơi
    for (const handLine of playerHands) {
        // Ví dụ: handLine = "HAND_Dương:6B,7R,8B,9C,KB,KT"
        const nameMatch = handLine.match(/HAND_([^:]+):/);
        
        if (nameMatch && nameMatch[1]) {
            const opponentName = nameMatch[1].trim();

            // Bỏ qua người chơi hiện tại (tham số playerName)
            if (opponentName === playerName) {
                continue;
            }

            // Lấy danh sách bài trên tay đối thủ
            const cardsStr = handLine.substring(handLine.indexOf(':') + 1).trim();
            const opponentCards = cardsStr.split(',').map(s => s.trim()).filter(s => s !== '');
            
            let foundCards = [];
            
            // 3. Tìm các quân bài cùng rank khác chất
            for (const opponentCard of opponentCards) {
                if (opponentCard.length < 2) continue; // Bỏ qua các chuỗi không phải là bài

                const opponentRank = getCardRank(opponentCard);
                const opponentSuit = getCardSuit(opponentCard);

                // Điều kiện: Cùng Rank VÀ Khác Chất
                if (opponentRank === targetRank && opponentSuit !== targetSuit) {
                    foundCards.push(opponentCard);
                }
            }
            
            // 4. Tạo chuỗi HTML nếu tìm thấy bài
            if (foundCards.length > 0) {
                // Thêm tên người chơi
                resultHtml += `<b style="color:#fff">${opponentName} thối</b><br/>`;
                
                // Thêm hình ảnh các quân bài tìm được
                for (const foundCard of foundCards) {
                    // Giả định thư mục ảnh là 'desk/' và định dạng file là '.svg'
                    resultHtml += `<img src="desk/${foundCard}.svg" class="cardthoi" >`;
                }
                resultHtml += '<br/>'; // Xuống dòng sau khi hiển thị tất cả bài của đối thủ
            }
        }
    }

    return resultHtml;
}
    
    
    $(document).on('dblclick', '#baiCuaBan .deskcard', function() {
        if ($(this).hasClass('disabled')) return;
        const $img = $(this);
        const card = $img.data('code');
        const currentThuTuChoi = $('#ThuTuChoi').text().trim(); 
        
        $.ajax({
            url: 'update_desk.php',
            type: 'POST',
            data: { player: currentPlayer, card: card, from: 'hand',ThuTuNguoiChoi: currentThuTuChoi,Ban:tableId },            	
            success: function(response) {
                    
                    
                          
                playMp3("voice/"+getCardValue(card)+".mp3");
                
                
                 // BƯỚC 3: HIỂN THỊ HIỆU ỨNG LÁ BÀI BỐC ĐƯỢC
                const $overlay = $('#BallDisplayOverlay');
                let ball=getBallFileName(card);
                $overlay.html(`<table style="position:fixed; top: 10px; width:100%  "><tr><td  style="text-align: center;" ><img src="ball/${ball}"  /></td></tr>
                	<tr><td style="text-align: center;" >`+
                		
                		    getSameRankCardsFromOtherPlayers(currentPlayer, card, Desk)
                		
                		+
                	`</td></tr></table>`); // Chèn ảnh
                $overlay.css('display', 'flex'); // Bật display để căn giữa
                
                // Dùng setTimeout để đảm bảo trình duyệt đã render display:flex trước khi thay đổi opacity
                setTimeout(() => {
                    $overlay.css('opacity', 1); // Bắt đầu fade-in
                }, 10); // 10ms là đủ

                // Tự động ẩn lá bài sau 1.5 giây
                setTimeout(() => {
                    $overlay.css('opacity', 0); // Bắt đầu fade-out
                    
                    // Ẩn hẳn sau khi transition (0.5s) kết thúc
                    setTimeout(() => {
                        $overlay.css('display', 'none');
                        $overlay.empty(); // Dọn dẹp nội dung
                    }, 500); // Thời gian 500ms (0.5s) khớp với transition: opacity 0.5s
                    
                }, 1200); // 1500ms = 1.5 giây
                
                
          
                 /////////////// Bình luận /////////////
        
       /* if (navigator.userActivation.hasBeenActive) {
         
         
const khen = [
  "Đánh thế ai chơi lại bạn",
  "Bạn đánh hay vãi",
  "Bạn ăn gì lắm thế",
  "Bạn lại ăn rùa à",
  "Thần rùa hiển linh",
  "Bạn đánh nét vãi lồn",
  "Bạn vừa hay lại vừa hên",
  "Bạn đánh thật vãi cứt"
];
         let ran = Math.floor(Math.random() * khen.length)
            setTimeout(() => {
                responsiveVoice.speak(khen[ran], "Vietnamese Male");
            }, 800);             
         
        } else {
        console.log("User has not yet interacted with the page.");
        }*/
  /////////////////////////////////////////    
                  
                
                
            },
            error: function() {
                console.error('Error updating desk');
            }
        });
    });
    
    
    function speakText(van) {
  const text = van;
  const utterance = new SpeechSynthesisUtterance(text);
  utterance.lang = 'vi-VN';

  speechSynthesis.getVoices().forEach(voice => {
    console.log(voice.name, voice.lang);
    // Thử tìm một giọng có tên hoặc ngôn ngữ gợi ý là nữ
    if (voice.lang === 'vi-VN' && voice.name.toLowerCase().includes('female')) {
      utterance.voice = voice;
    }
  });

  speechSynthesis.speak(utterance);
}

    
    
    $(document).on('dblclick', '#cayDaAn .deskcard', function() {
        const $img = $(this);
        const card = $img.data('code');
        const currentThuTuChoi = $('#ThuTuChoi').text().trim(); 
        $.ajax({
            url: 'update_desk.php',
            type: 'POST',
            data: { player: currentPlayer, card: card, from: 'an',ThuTuNguoiChoi: currentThuTuChoi,Ban:tableId  },
            success: function(response) {
              //  loadDesk();
                playMp3("voice/lat.mp3");
            },
            error: function() {
                console.error('Error updating desk');
            }
        });
    });
    
 // Lắng nghe sự kiện double-click vào nút có ID BatDauBamGio
    $('#BatDauBamGio').dblclick(function() {                 
           timecount=60;
           countdownEl.textContent = `${String(timecount).padStart(2, "0")}`;
           $("#fixed-box").show(); 
           playMp3("voice/batdau.mp3");                             
    });
    
    // Xử lý double click nút bốc nọc
    $(document).on('dblclick', '.nutbocnoc', function() {
        
        // BƯỚC 1: HỎI XÁC NHẬN TRƯỚC
        if (!confirm(`Bạn có muốn bốc bài trong nọc không?`)) {
            return; // Nếu KHÔNG xác nhận (chọn Cancel), DỪNG việc xử lý.
        }
        
        // Nếu đã xác nhận (chọn OK), TIẾN HÀNH các bước còn lại:
        
        const card = $(this).data('code');
        if (!card || !currentPlayer) {
            console.error('Missing player or card data');
            return;
        }

        // BƯỚC 2: Gửi yêu cầu AJAX bốc nọc (Phải thực hiện trước hiệu ứng để đảm bảo dữ liệu được ghi nhận)
        const currentThuTuChoi = $('#ThuTuChoi').text().trim(); 
        $.ajax({
            url: 'update_desk.php',
            type: 'POST',
            data: { player: currentPlayer, card: card, from: 'noc',ThuTuNguoiChoi: currentThuTuChoi,Ban:tableId  },
            success: function(response) {
                console.log('Bốc nọc thành công:', response);                        
                                  
                playMp3("voice/B"+getCardValue(card)+".mp3");
                
                // BƯỚC 3: HIỂN THỊ HIỆU ỨNG LÁ BÀI BỐC ĐƯỢC
                const $overlay = $('#cardDisplayOverlay');
                $overlay.html(`<img src="desk/${card}.svg" alt="Lá bài được bốc" />`); // Chèn ảnh
                $overlay.css('display', 'flex'); // Bật display để căn giữa
                
                // Dùng setTimeout để đảm bảo trình duyệt đã render display:flex trước khi thay đổi opacity
                setTimeout(() => {
                    $overlay.css('opacity', 1); // Bắt đầu fade-in
                }, 10); // 10ms là đủ

                // Tự động ẩn lá bài sau 1.5 giây
                setTimeout(() => {
                    $overlay.css('opacity', 0); // Bắt đầu fade-out
                    
                    // Ẩn hẳn sau khi transition (0.5s) kết thúc
                    setTimeout(() => {
                        $overlay.css('display', 'none');
                        $overlay.empty(); // Dọn dẹp nội dung
                    }, 500); // Thời gian 500ms (0.5s) khớp với transition: opacity 0.5s
                    
                }, 1500); // 1500ms = 1.5 giây

            },
            error: function() {
                console.error('Lỗi khi bốc nọc');
            }
        });
    });
    
   function Get_BiMucTieu(bi) {
   
   
   
   if (bi==null || bi=='')	   bi=':';
   
   	   
  // 1. Xóa từ đầu cho đến hết dấu ":"
  const viTriHaiCham = bi.indexOf(":");
  if (viTriHaiCham === -1) {
    return ""; 
  }
  let phanBai = bi.substring(viTriHaiCham + 1); 

  // Nếu phần chuỗi mã bài rỗng, trả về rỗng
  if (!phanBai.trim()) {
      return "";
  }

  // 2. Tách chuỗi thành mảng các mã lá bài
  const mangMaBai = phanBai.split(","); 

  // 3. Xóa các hậu tố (R, C, B, T) VÀ LỌC CÁC MÃ RỖNG
  const mangGiaTriBai = mangMaBai.map(ma => {
    // Xóa ký tự cuối cùng nếu nó là R, C, B, hoặc T
    return ma.replace(/[RCBT]$/, "");
  }).filter(ma => ma.trim() !== ""); // <-- BƯỚC SỬA MỚI: Loại bỏ các phần tử rỗng sau khi lọc hậu tố

  // 4. Kiểm tra nếu mảng rỗng (không có mã lá bài hợp lệ nào)
  if (mangGiaTriBai.length === 0) {
      return "";
  }

  // 5. Xóa các phần tử trùng lặp và lấy các mã duy nhất
  const mangDuyNhat = [...new Set(mangGiaTriBai)]; 

  // 6. Chuyển mảng các mã thành chuỗi HTML
  const chuoiHtml = mangDuyNhat.map(ma => {
    return `<img class="poolball" src="ball/${ma}.png" />`;
  }).join(""); 
   
  return chuoiHtml;
}



   function playMp3(filePath) {
  const audio = document.getElementById('dynamicAudioPlayer');

  // 1. Dừng nhạc cũ nếu đang phát
  audio.pause();
  audio.currentTime = 0; // Đưa về đầu

  // 2. Cập nhật đường dẫn tệp mới
  audio.src = filePath;

  // 3. Tải và phát
  audio.load(); // Tải tệp mới
  audio.play()
    .catch(error => {
      console.error(`Không thể phát tệp ${filePath}:`, error);
    });
}



/**
 * Hàm kiểm tra xem một bộ bài có đủ điều kiện để "Báo Ù" theo luật:
 * 1. Chỉ có 1 quân bài.
 * 2. Có 2, 3, hoặc 4 quân bài và TẤT CẢ các quân bài đó đều cùng giá trị.
 *
 * @param {string} hand Chuỗi mã quân bài kèm tên người chơi, ví dụ: "HAND_Hoàng:AC,2T,4T,5B,5T,6C,9B,QB,KB"
 * @returns {string} "Báo Ù" nếu thỏa mãn điều kiện, hoặc chuỗi rỗng "" nếu không.
 */
function BaoU(hand) {
    // 1. Tách lấy chuỗi mã quân bài (phần sau dấu hai chấm ':')
    const cardString = hand.split(':')[1];

    

    // Tách thành mảng các quân bài
    const cards = cardString.split(',').filter(card => card.trim() !== '');

    // Nếu không có quân bài nào hợp lệ
    if (cards.length === 0) {
        return "";
    }

    // --- LOGIC MỚI DỰA TRÊN PHẢN HỒI CỦA NGƯỜI DÙNG ---

    // 2. Kiểm tra điều kiện 1: "chỉ có 1 phần tử bất kỳ"
    if (cards.length === 1) {
    	
        return "<br><span class='baou'>Báo Ù<span>";
    }

    // 3. Kiểm tra điều kiện 2: "2, 3, hoặc 4 quân bài CÙNG GIÁ TRỊ"
    if (cards.length >= 2 && cards.length <= 4) {
        // Lấy giá trị của quân bài đầu tiên làm chuẩn
        // Giá trị là phần đầu của chuỗi (trước ký tự cuối cùng là chất R/C/B/T).
        const firstCardValue = cards[0].substring(0, cards[0].length - 1);
        let allSameValue = true;

        // So sánh giá trị của tất cả các quân bài còn lại với quân bài đầu tiên
        for (let i = 1; i < cards.length; i++) {
            const currentValue = cards[i].substring(0, cards[i].length - 1);
            if (currentValue !== firstCardValue) {
                allSameValue = false;
                break;
            }
        }

        if (allSameValue) {  
        	
            return "<br><span class='baou'>Báo Ù<span>";
        }
    }


   
    return "";
}



let paused = false;

const countdownEl = document.getElementById("countdown");


let interval;
function startCountdown() {
    interval = setInterval(() => {
        
            timecount--;
            
            if (timecount == 0) {                                                
                playMp3("voice/hetgio.mp3");  
            }                                               
            if (timecount < 0) {                                
                $("#fixed-box").hide();            
            }
            
            countdownEl.textContent = `${String(timecount).padStart(2, "0")}`;
        
    }, 1000);
}

startCountdown();



</script>

<script src="https://code.responsivevoice.org/responsivevoice.js?key=huMVBb4I"></script>

</body>
</html>