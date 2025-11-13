<?php
// index.php - Main file containing the HTML, CSS, JS, with PHP for initial setup

include 'config.php';

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

$ban=1;
if ( isset( $_GET["b"] ) ) $ban=$_GET["b"];

$domain = get_base_url();
$seed = floor( time() );
srand( $seed );

try {
    $pdo = new PDO( "mysql:host=$host;dbname=$dbname", $username, $password );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    // SỬA LỖI FONT: Thiết lập charset cho phiên kết nối MySQL
    $pdo->exec( "SET NAMES 'utf8'" );
} catch ( PDOException $e ) {
    die( "Database connection failed: " . $e->getMessage() );
}

// Create table if not exists
$pdo->exec( "CREATE TABLE IF NOT EXISTS billiards_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_json TEXT NOT NULL
)" );

// For simplicity, assume single record with id=1
$stmt = $pdo->prepare( "SELECT COUNT(*) FROM billiards_data WHERE id=1" );
$stmt->execute();
if ( $stmt->fetchColumn() == 0 ) {
    $pdo->exec( "INSERT INTO billiards_data (id, data_json) VALUES (1, '{}')" );
        $pdo->exec( "INSERT INTO billiards_data (id, data_json) VALUES (2, '{}')" );
            $pdo->exec( "INSERT INTO billiards_data (id, data_json) VALUES (3, '{}')" );
                $pdo->exec( "INSERT INTO billiards_data (id, data_json) VALUES (4, '{}')" );
                    $pdo->exec( "INSERT INTO billiards_data (id, data_json) VALUES (5, '{}')" );
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=1920, initial-scale=1.0">
<title>Tổng kết thi đấu Billiards</title>
<script src="js/chart.js"></script> 
<script src="js/label.js"></script> 
<script src="js/html2canvas.min.js"></script> 
<script src="<?php echo($domain);?>js/jquery-3.7.1.min.js" ></script> 
<script src="js/jquery-ui.min.js" ></script>
<style>
/* CSS */
body {
    font-family: Arial, sans-serif;
    padding: 10px; /* Giảm padding tổng thể */
    background-color: #fff;
}
.hidden-col {
    display: none !important;
}
.shape-outer {
    display: flex;
    flex-shrink: 0;
    height: calc(100px + 4vw);
    width: calc(100px + 4vw);
    margin: 25px;
    background-image: linear-gradient(to bottom right, #ff3cac, #562b7c, #2b86c5);
}
.shape-inner-DUONG {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/duong.png");
}
.shape-inner-NINH {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/ninh.png");
}
.shape-inner-HOANG {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/hoang.png");
}
.shape-inner-HOANGANH {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/hoanganh.png");
}
.shape-inner-MINH {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/minh.png");
}
.shape-inner-KHANH {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/khanh.png");
}
.shape-inner-LONG {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/long.png");
}
.shape-inner-GIANG {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/giang.png");
}
.shape-inner-GIAP {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/giap.png");
}
.shape-inner-BAN {
    height: calc(80px + 4vw);
    width: calc(80px + 4vw);
    background-size: cover;
    margin: auto;
    background-image: url("<?php echo($domain);?>img/ban.png");
}
.circle {
    border-radius: 50%; /* Thêm để đảm bảo hình tròn */
    overflow: hidden; /* Đảm bảo nội dung không tràn ra ngoài */
}
.avatar-container {
    display: flex; /* Bật Flexbox */
    gap: 0px;     /* (Tùy chọn) Thêm khoảng cách giữa các avatar */
    justify-content: center;
}
.banner-nen {
    background-image: url("<?php echo($domain);?>img/<?php echo(rand(1,50));?>.jpg");
    width: 100%;
    height: 1209px;
    background-size: cover;     /* Đảm bảo ảnh nền lấp đầy khung */
    background-position: center;     /* Căn giữa ảnh nền */
    background-repeat: no-repeat;    /* Không lặp lại ảnh nền */
}
.banner-content {
    width: 100%;
    display: flex; /* Bật Flexbox */
    justify-content: center; /* Căn giữa theo chiều ngang (trái-phải) */
    align-items: normal;
    padding-top: 24%;
}
.banner-content-l {
    width: 100%;
    height: 0%;
    display: flex; /* Bật Flexbox */
    justify-content: center; /* Căn giữa theo chiều ngang (trái-phải) */
    align-items: center; /* Căn giữa theo chiều dọc (trên-dưới) */
    padding-top: 17%;
}
.app-container {
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}
/* Bố cục điều khiển mặc định (Desktop) */
.controls {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    padding: 10px 0;
    border-bottom: 1px solid #ccc;
    margin-bottom: 20px;
}
.control-group {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: bold;
}
.control-group input {
    padding: 5px;
    border: 1px solid #ccc;
    width: 80px;
    text-align: right;
}
/* Các nút điều khiển */
.action-button {
    padding: 8px 15px;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    white-space: nowrap; /* Tránh ngắt dòng trong nút */
}
.add-player-btn {
    background-color: #4CAF50;
}
.add-game-btn {
    background-color: #f7b731;
}
.export-btn {
    background-color: #007bff;
}
.reset-btn {
    background-color: #ff4500;
}
/* Bảng điểm */
.table-container {
    overflow-x: auto;
    margin-bottom: 20px;
    position: relative;
}
#scoreTable {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px; /* Giảm min-width cho bảng */
    font-weight: bold;
}
#scoreTable th, #scoreTable td {
    border: 1px solid #cacaca;
    padding: 4px 2px;
    text-align: center;
}
#scoreTable thead th {
    background-color: #e0e0e0;
}
/* Cố định cột */
.player-name-col {
    background-color: #f9f9f9;
    min-width: 120px;
    text-align: left !important;
    position: sticky;
    left: 0;
    z-index: 10;
}
.result-col {
    min-width: 60px;
    font-weight: bold;
}
.total-cays {
    position: sticky;
    right: 40px;
    z-index: 9;
    background-color: #ffecc6;
}
.total-money {
    background-color: #e8e8e8;
}
#scoreTable thead th.player-name-col {
    z-index: 11;
}
/* Styles cho ô nhập điểm */
.game-score-col {
    background-color: #fff;
    cursor: text;
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
    background-color: #a5eba7 !important;
    color: #1b620e !important;
}
.total-scars {
    background-color: #ff4500 !important;
    color: #ffff00 !important;
}
/* Khu vực biểu đồ */
.chart-row {
    display: flex;
    flex-direction: row; /* Mặc định là hàng */
    gap: 20px;
    margin-top: 20px;
    overflow: hidden;
    width: 100%;
}
.chart-row > .chart-box {
    flex: 1 1 100%;
    max-width: 100%;
}
.chart-box {
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    overflow: hidden;
}
/* Responsive Chart */
.chart-box canvas {
    width: 100% !important;
    aspect-ratio: 2 / 1;
    max-height: 500px;
}
/* Khu vực Tóm Tắt Trận Đấu MỚI */
.summary-box {
    margin-top: 30px;
    padding: 20px;
    border: 2px solid #007bff; /* Viền xanh nổi bật */
    border-radius: 8px;
    background-color: #e9f5ff; /* Nền xanh nhạt */
    font-size: 14px !important; /* cố định cỡ chữ */
    transform: none !important;
    zoom: 1 !important;
}

/* Ngăn phóng to chữ trên mobile */
@media screen and (max-width: 100vw) {
.summary-box {
    font-size: 14px !important; /* giữ nguyên cỡ chữ như desktop */
    width: auto;
    max-width: none;
    white-space: normal;
    word-wrap: break-word;
}
/* Ngăn Safari phóng to chữ khi xoay ngang */
body, .summary-box {
    -webkit-text-size-adjust: 100% !important;
    text-size-adjust: 100% !important;
}
}
.summary-box h2 {
    color: #007bff;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
    margin-top: 0;
    font-size: 18px;
    text-transform: uppercase;
}
.summary-box h3 {
    color: #444;
    margin-top: 15px;
    margin-bottom: 5px;
    font-size: 16px;
    border-bottom: 1px dotted #ccc;
    padding-bottom: 5px;
    font-weight: bold; /* In đậm tiêu đề h3 */
}
#matchSummaryDetails p {
    line-height: 1.8;
    margin-bottom: 8px;
    font-size: 14px;
}
/* Định dạng các thẻ SPAN chứa số liệu thống kê */
.summary-data-cays {
    font-weight: bold;
    color: #cc0000; /* Màu đỏ cho số cây (tương tự màu điểm) */
}
.summary-data-moms {
    font-weight: bold;
    background-color: #cc0000;
    color: white;
    padding: 2px 4px;
    border-radius: 3px;
}
.summary-data-us {
    font-weight: bold;
    background-color: #a5eba7;
    color: #1b620e;
    padding: 2px 4px;
    border-radius: 3px;
}
.summary-data-uo {
    font-weight: bold;
    background-color: #f4fb6b;
    color: #7c761e;
    padding: 2px 4px;
    border-radius: 3px;
}
.summary-data-scars {
    font-weight: bold;
    background-color: #ff4500;
    color: yellow;
    padding: 2px 4px;
    border-radius: 3px;
}
.summary-data-money {
    font-weight: bold;
    color: red; /* Tiền luôn màu đỏ, in đậm */
}
.summary-data-normal {
    font-weight: bold;
    color: #000;
}
/* In đậm tên người chơi trong tóm tắt */
.summary-player-name {
    font-weight: bold;
    color: #007bff; /* Màu xanh nổi bật cho tên */
}

/* Responsive: Dưới 768px (Thiết bị di động) */
@media (max-width: 768px) {
body {
    padding: 5px;
}
.app-container {
    padding: 10px;
}
/* Điều khiển: Chuyển sang bố cục cột đơn */
.controls {
    flex-direction: column;
    gap: 10px;
    align-items: stretch; /* Kéo dài các item ra */
}
.action-button {
    width: 100%; /* Các nút chiếm toàn bộ chiều rộng */
    padding: 12px;
    font-size: 16px;
}
.control-group {
    width: 100%;
    justify-content: space-between; /* Đẩy input sang phải */
    padding: 5px 0;
    font-size: 16px;
}
.control-group input {
    width: 120px; /* Tăng kích thước input */
    padding: 8px;
    font-size: 16px;
}
/* Bảng điểm: Chỉ thay đổi min-width để dễ cuộn hơn */
#scoreTable {
    min-width: 700px; /* Giảm tối thiểu để dễ xem */
}
#scoreTable th, #scoreTable td {
    padding: 8px 3px;
    font-size: 12px;
}
.player-name-col {
    min-width: 90px;
}
/* Biểu đồ: Hiển thị từng biểu đồ theo dạng cột đơn */
.chart-row {
    flex-direction: column;
    gap: 15px;
}
.chart-box {
    padding: 10px;
}
.chart-box h2 {
    font-size: 16px;
    text-align: center;
}
/* Tóm tắt */
.summary-box {
    padding: 15px;
}
}
/* Style mới cho viền đỏ khi không có ù */
.no-u-border {
    border: 1px solid #c5c5c5 !important;
}
.dongbong {}
.ball {
    width: 30px;
    margin-right: 3px
}
</style>
</head>
<body>
<div class="app-container" id="appContainer">
  <div class="controls">
    <button class="action-button export-btn" id="exportButton">Kết xuất ra ảnh PNG</button>
    <button class="action-button" id="exportHtmlButton" style="background-color: #182db6;">Kết xuất ra HTML</button>
    <div class="control-group" style="display:none">
      <label for="moneyInput">Tiền bàn (đ):</label>
      <input type="number" id="moneyInput" value="0" min="0">
    </div>
    <div class="control-group"  style="display:none">
      <label for="splitCountInput">Số người chia tiền:</label>
      <input type="number" id="splitCountInput" value="2" min="1" max="10">
    </div>
  </div>
  <div class="table-container" id="tableContainer">
    <table id="scoreTable">
      <thead>
        <tr>
          <th class="player-name-col" rowspan="2">Người chơi</th>
          <th id="gameHeaderSpan" colspan="20">Kết quả từng ván đấu</th>
          <th class="result-col total-cays" rowspan="2">Tổng số cây</th>
          <th class="result-col total-moms" rowspan="2">Số ván móm</th>
          <th class="result-col total-us" rowspan="2">Số ván ù</th>
          <th class="result-col total-scars" rowspan="2">Số ván sẹo</th>
          <th class="result-col total-money" rowspan="2">Chia tiền</th>
        </tr>
        <tr id="gameHeaders"> </tr>
      </thead>
      <tbody id="scoreBody">
      </tbody>
    </table>
  </div>
  <div class="chart-row">
    <div class="chart-box">
      <h2>BIỂU ĐỒ DIỄN BIẾN SỐ CÂY</h2>
      <div id="lineChartContainer">
        <canvas id="lineChart"></canvas>
      </div>
    </div>
    <div class="chart-box">
      <h2>BIỂU ĐỒ SỐ CÂY TỪNG VÁN</h2>
      <div id="gameScoreChartContainer">
        <canvas id="gameScoreChart"></canvas>
      </div>
    </div>
  </div>
  <div class="chart-row">
    <div class="chart-box">
      <h2>XẾP HẠNG CHUNG CUỘC</h2>
      <div id="rankChartContainer">
        <canvas id="rankChart"></canvas>
      </div>
    </div>
    <div class="chart-box">
      <h2>CHIA TIỀN</h2>
      <div id="moneyChartContainer">
        <canvas id="moneyChart"></canvas>
      </div>
    </div>
  </div>
  <div class="chart-row">
    <div class="chart-box">
      <h2>DIỄN BIẾN THỨ TỰ XẾP HẠNG THEO TỪNG VÁN</h2>
      <div id="rankTimelineChartContainer">
        <canvas id="rankTimelineChart"></canvas>
      </div>
    </div>
  </div>
  <div class="chart-row">
    <div class="chart-box">
      <h2>DIỄN BIẾN THỜI GIAN CÁC VÁN ĐẤU</h2>
      <div id="gameTimeChartContainer">
        <canvas id="gameTimeChart"></canvas>
      </div>
    </div>
  </div>
  <div class="summary-box">
    <h2 id="summaryTitle">ĐANG TẢI TỔNG KẾT TRẬN ĐẤU...</h2>
    <div id="matchSummaryDetails"></div>
  </div>
</div>
<script>
        // JavaScript
        const MAX_PLAYERS = 10;
        let gameCount = 20;
        const defaultPlayerNames = ["Hoàng", "Dương", "Ninh"];

        let rankChartInstance = null;
        let moneyChartInstance = null;
        let lineChartInstance = null; 
        let gameScoreChartInstance = null; 
        let rankTimelineChartInstance = null; 
        let gameTimeChartInstance = null; 

        // Biến lưu trữ thời gian bắt đầu/kết thúc ván (UTC string)
        let gameTimestamps = {}; 
        
        // Biến toàn cục lưu trữ Rank Counts
        let rankCountsByPlayer = {}; 

        Chart.register(ChartDataLabels);
        
        // Mảng màu sắc cho biểu đồ
        const chartColors = [
            'rgb(255, 99, 132)',  
            'rgb(54, 162, 235)',  
            'rgb(75, 192, 192)',  
            'rgb(255, 205, 86)',  
            'rgb(153, 102, 255)', 
            'rgb(255, 159, 64)',  
            'rgb(0, 200, 50)',    
            'rgb(200, 0, 100)',   
            'rgb(100, 100, 100)', 
            'rgb(50, 200, 200)'   
        ];
        

        document.addEventListener('DOMContentLoaded', () => {
            const scoreBody = document.getElementById('scoreBody');
            const gameHeaders = document.getElementById('gameHeaders');
            const gameHeaderSpan = document.getElementById('gameHeaderSpan');
        
        
            const exportButton = document.getElementById('exportButton'); 
            const exportHtmlButton = document.getElementById('exportHtmlButton');
         
            const moneyInput = document.getElementById('moneyInput');
            const splitCountInput = document.getElementById('splitCountInput');
            const tableContainer = document.getElementById('tableContainer');
            const scoreTable = document.getElementById('scoreTable');
            const appContainer = document.getElementById('appContainer');


 

          

            // 1b. Khởi tạo cột Ván 
            function initializeGameColumns(count) {
                gameHeaders.innerHTML = '';
                gameHeaderSpan.setAttribute('colspan', count);
                for (let i = 1; i <= count; i++) {
                    const th = document.createElement('th');
                    th.textContent = `Ván ${i}`;
                    th.classList.add('game-score-col');
                    gameHeaders.appendChild(th);
                }
            }

         
$("#scoreTable").click(function() {
  $(".dongbong").toggle();
});
         
          
            // 2. Hàm Tải Dữ liệu từ Database via AJAX
            function loadDataFromDatabase(callback) {
                $.ajax({
                    url: 'load.php?b=<?php echo($ban);?>',
                    type: 'GET',
                    success: function(response) {
                        let data;
                        try {
                            data = JSON.parse(response);
                        } catch (e) {
                            data = {};
                        }
                        // Tải timestamps nếu có, nếu không khởi tạo mặc định
                        gameTimestamps = data.settings ? data.settings.gameTimestamps || {} : {};
                        if (Object.keys(gameTimestamps).length === 0) {
                            gameTimestamps = { 
                                'game_1': { 
                                    start: new Date().toISOString(), 
                                    end: null 
                                } 
                            };
                        }
                        callback(data);
                    },
                    error: function() {
                        console.error("Error loading data");
                        callback(null);
                    }
                });
            }

           
            // 4. Khởi tạo bảng 
            function initializeTable() {
                loadDataFromDatabase((data) => {
                    if (data && data.players && data.players.length > 0) {
                        gameCount = data.settings.gameCount || 20;
                        initializeGameColumns(gameCount);
                   
                        data.players.forEach(p => addPlayerRow(p.name, p.scores, p.bi));
                        
                        moneyInput.value = data.settings.money || 0; 
                        splitCountInput.value = data.settings.splitCount || 2;
                    } 

                 
                    fullRecalculate();
                
                });
            }

            // 5. Thêm một dòng người chơi 
            function addPlayerRow(name, initialScores = [],initialBi = []) {
                if (scoreBody.children.length >= MAX_PLAYERS) {
                    alert('Đã đạt giới hạn tối đa 10 người chơi!');
                    return;
                }
                let socot=0;
                let row = scoreBody.insertRow();
                
                // Vị trí chèn ban đầu cho các cột tổng kết
                // Cột Tên (0), Ván 1..Ván 20, Cây (21), Móm (22), U (23), Sẹo (24), Tiền (25), Xóa (26)
                const resultStartCol = gameCount + 1;

                // Cột Tên Người Chơi (Index 0)
                const nameCell = row.insertCell(0);
                nameCell.classList.add('player-name-col');
                nameCell.contentEditable = false;
                nameCell.textContent = name;
             
                
                // Cột Điểm Ván (Index 1 đến gameCount)
                for (let i = 0; i < gameCount; i++) {
                    const gameCell = row.insertCell(i + 1); // Index 1
                    gameCell.classList.add('game-score-col');
                    gameCell.contentEditable = false;
                    
                    const score = initialScores[i] || '';
                    if (score!='') socot++;
                    gameCell.textContent = score;
                    

                    if (score) {
                        applyStyle(gameCell);
                    }
                }
                
                // Cột Tổng Kết Quả (Index gameCount + 1 trở đi)
                const cayCell = row.insertCell(resultStartCol); cayCell.classList.add('total-cays', 'result-col');
                const momCell = row.insertCell(resultStartCol + 1); momCell.classList.add('total-moms', 'result-col');
                const uCell = row.insertCell(resultStartCol + 2); uCell.classList.add('total-us', 'result-col');
                const scarCell = row.insertCell(resultStartCol + 3); scarCell.classList.add('total-scars', 'result-col'); 
                const moneyCell = row.insertCell(resultStartCol + 4); moneyCell.classList.add('total-money', 'result-col');
                
                cayCell.dataset.value = '0';
                momCell.dataset.value = '0';
                uCell.dataset.value = '0';
                scarCell.dataset.value = '0'; 
                moneyCell.dataset.value = '0';
                
                 ////////// Hiển thị dòng bi trong dòng kết quả
                 
                 row = scoreBody.insertRow();
                 row.classList.add('dongbong'); 
                row.insertCell(0);
                let i=0;
                for (i = 0; i < gameCount; i++) {
                    const gameCell = row.insertCell(i+1); // Index 1                    
                    gameCell.contentEditable = false;
                    gameCell.style.width = (80/socot)+'%';
                    const bi = initialBi[i] || '';
                    gameCell.innerHTML  =  generateBallImages(bi);
                }
                 row.insertCell(i+1);
                 row.insertCell(i+2);
                 row.insertCell(i+3);
                 row.insertCell(i+4);
                 
                 const gameCell = row.insertCell(i+5);
                 gameCell.style.width = '6%';
                 
                 ////////////////////////////////////////////// 
               
                hideEmptyGameColumns("scoreTable");
                calculateRowScores(row);
            }
            
            
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
        htmlOutput += `<img src="<?php echo($domain);?>ball/${fileName}.png" class="ball" alt="${card}">`;
    });

    return htmlOutput;
}
            
            
            // 6. Hàm áp dụng CSS Class 
            function applyStyle(cell) {
                const value = cell.textContent.trim().toLowerCase();
                
                cell.classList.remove('score-m', 'score-u', 'score-normal', 'score-0u', 'score-s');
                
                if (!value) return;

                if (value === '0u') {
                    cell.classList.add('score-0u');
                } else if (value.endsWith('m')) {
                    cell.classList.add('score-m');
                } else if (value.endsWith('u')) {
                    cell.classList.add('score-u');
                } else if (value.endsWith('s')) { 
                    cell.classList.add('score-s');
                } else if (!isNaN(parseInt(value))) {
                     cell.classList.add('score-normal');
                }
            }
            
            // Hàm lấy giá trị số từ ô điểm 
            function extractNumericScore(value) {
                const match = value.match(/^\s*(\d+)/);
                return match ? parseInt(match[1]) : 0;
            }

            // 7. Hàm tính toán kết quả 
            function calculateRowScores(row) {
                let totalCays = 0;
                let totalMoms = 0;
                let totalUs = 0;
                let totalScars = 0; 
                let totalUo = 0; 
                let hasScore = false; 
                
                // Lấy chỉ số bắt đầu của cột tổng kết
                const resultStartColIndex = gameCount + 1;

                // Lấy các ô điểm ván (Index 1 đến gameCount)
                const gameCells = Array.from(row.cells).slice(1, gameCount + 1);

                gameCells.forEach(cell => {
                    const value = cell.textContent.trim().toLowerCase();
                    if (!value) return;

                    hasScore = true;
                    const score = extractNumericScore(value);
                    totalCays += score; 

        if (value === '0u') {
            totalUo++;
        }

                    if (value.endsWith('m')) {
                        totalMoms++;
                    } else if (value.endsWith('u')) {
                        totalUs++;
                    } else if (value.endsWith('s')) { 
                        totalScars++;
                    }
                });

                const shouldDisplay = hasScore || totalCays > 0 || totalMoms > 0 || totalUs > 0 || totalScars > 0;
                
                // Lấy các ô tổng kết quả (Index gameCount + 1 trở đi)
                // Cây (Index gameCount + 1)
                const totalCaysCell = row.cells[resultStartColIndex]; 
                // Móm (Index gameCount + 2)
                const totalMomsCell = row.cells[resultStartColIndex + 1]; 
                // U (Index gameCount + 3)
                const totalUsCell = row.cells[resultStartColIndex + 2];
                // Sẹo (Index gameCount + 4)
                const totalScarsCell = row.cells[resultStartColIndex + 3]; 
                // Tiền (Index gameCount + 5)
                const moneyCell = row.cells[resultStartColIndex + 4];

                totalCaysCell.textContent = shouldDisplay ? totalCays : '';
                totalCaysCell.dataset.value = totalCays;
                
                totalMomsCell.textContent = shouldDisplay ? totalMoms : '';
                totalMomsCell.dataset.value = totalMoms;
                
                totalUsCell.textContent = shouldDisplay ? totalUs : '';
                totalUsCell.dataset.value = totalUs;
                
                totalScarsCell.textContent = shouldDisplay ? totalScars : ''; 
                totalScarsCell.dataset.value = totalScars; 
                

  // <--- THÊM: Lưu tổng số ván ù 0 cây vào thuộc tính dữ liệu của hàng
    row.dataset.totalUo = totalUo; 
    
    moneyCell.textContent = '';
    moneyCell.dataset.value = '0';


                moneyCell.textContent = '';
                moneyCell.dataset.value = '0';
            }

            // 8. Xếp hạng và chia tiền 
            function calculateMoneySplit() {
                // Chỉ số bắt đầu của các cột tổng kết
                const resultStartColIndex = gameCount + 1;
                
                const validRows = Array.from(scoreBody.children).filter(row => 
                    row.cells[0].textContent.trim() && (
                        parseInt(row.cells[resultStartColIndex].dataset.value) > 0 || // Cây
                        parseInt(row.cells[resultStartColIndex + 1].dataset.value) > 0 || // Móm
                        parseInt(row.cells[resultStartColIndex + 2].dataset.value) > 0 || // U
                        parseInt(row.cells[resultStartColIndex + 3].dataset.value) > 0 // Sẹo
                    )
                );
                
                const playersData = validRows.map(row => ({
                    row: row,
                    name: row.cells[0].textContent.trim(),
                    cays: parseInt(row.cells[resultStartColIndex].dataset.value),
                    moms: parseInt(row.cells[resultStartColIndex + 1].dataset.value),
                    us: parseInt(row.cells[resultStartColIndex + 2].dataset.value),
                    scars: parseInt(row.cells[resultStartColIndex + 3].dataset.value), 
                    uo: parseInt(row.dataset.totalUo) || 0, // <--- THÊM: Thêm biến uo (ù 0 cây)
                    money: 0
                }));

                // SỬA LỖI XẾP HẠNG: Dùng logic thống nhất
                // 1. Cây thấp nhất 
                // 2. U cao nhất 
                // 3. Móm thấp nhất
                // 4. Sẹo thấp nhất 
                playersData.sort((a, b) => {
                    if (a.cays !== b.cays) return a.cays - b.cays; 
                    if (a.us !== b.us) return b.us - a.us; 
                    if (a.moms !== b.moms) return a.moms - b.moms;
                    return a.scars - b.scars; 
                });
                
                const totalTableMoney = parseInt(moneyInput.value) || 0;
                const splitCount = parseInt(splitCountInput.value) || 0;
                
                // Cập nhật hiển thị tiền cho tất cả người chơi
                Array.from(scoreBody.children).forEach(row => {
                    const resultStartColIndex = gameCount + 1;
                    const moneyCell = row.cells[resultStartColIndex + 4];
                    const caysCell = row.cells[resultStartColIndex];
                    
                    moneyCell.textContent = caysCell.textContent ? '0 đ' : ''; 
                    moneyCell.dataset.value = '0';
                    moneyCell.style.color = '#000080';
                });
                
                if (totalTableMoney <= 0 || splitCount <= 0 || playersData.length < splitCount) {
                    return playersData; // Trả về data đã sort
                }

                const losers = playersData.slice(-splitCount);
                const totalLoserCays = losers.reduce((sum, player) => sum + player.cays, 0);

                if (totalLoserCays > 0) {
                    const avgMoneyPerCay = totalTableMoney / totalLoserCays;
                    
                    losers.forEach(loser => {
                        const calculatedMoney = Math.round(loser.cays * avgMoneyPerCay);
                        loser.money = calculatedMoney;
                    });
                }
                
                playersData.forEach(player => {
                    const moneyCell = player.row.cells[gameCount + 1 + 4]; // Vị trí Cột Tiền
                    const finalMoney = player.money;
                    
                    // In đậm tiền và màu đỏ
                    if (player.money > 0) {
                        moneyCell.innerHTML = `<span style="font-weight: bold; color: red;">(${finalMoney.toLocaleString('vi-VN')} đ)</span>`;
                        moneyCell.style.color = 'red'; // CSS cho cell
                    } else if (player.cays > 0) {
                        moneyCell.innerHTML = '0 đ';
                        moneyCell.style.color = '#000080';
                    } else {
                        moneyCell.textContent = '';
                    }
                    moneyCell.dataset.value = finalMoney;
                });
                
                return playersData; // Trả về data đã sort và cập nhật tiền
            }

            // 9. Hàm tính toán và vẽ lại toàn bộ 
            function fullRecalculate() {
                Array.from(scoreBody.children).forEach(calculateRowScores);
                const sortedPlayersData = calculateMoneySplit();
                
                updateCharts();
                // Đảm bảo rankCountsByPlayer đã được tính trong updateCharts
                updateSummary(sortedPlayersData); // Cập nhật tóm tắt
            }
            
            // Hàm lấy điểm số từng ván 
            function getGameScore(value) {
                return extractNumericScore(value);
            }
            
            // Hàm tính toán thứ hạng lũy kế sau mỗi ván
            function calculateCumulativeRankings(allPlayerData, maxIndex) {
                const maxGames = maxIndex;
                const playerNames = allPlayerData.map(p => p.name);
                const rankingsByPlayer = {}; 
                const rankCountsByPlayerLocal = {}; // Local data: Đếm số ván xếp hạng
                
                playerNames.forEach(name => {
                    rankingsByPlayer[name] = [];
                    rankCountsByPlayerLocal[name] = {};
                });

                for (let v = 1; v <= maxGames; v++) {
                    const cumulativeScores = allPlayerData.map(player => {
                        let cays = 0;
                        let moms = 0;
                        let us = 0;
                        let scars = 0; 
                        let uo = 0; // <--- THÊM: Khởi tạo biến đếm ù 0 cây
                        let hasPlayed = false;

                        // Tính điểm cộng dồn đến ván hiện tại (v)
                        for (let i = 0; i < v; i++) {
                            const value = player.scores[i] ? player.scores[i].trim().toLowerCase() : '';
                            if (!value) continue;
                            hasPlayed = true;

                            cays += extractNumericScore(value);

  // --- THÊM: Logic đếm ù 0 cây ---
                if (value === '0u') {
                    uo++;
                }
                // -------------------------------
                            
                            if (value.endsWith('m')) {
                                moms++;
                            } else if (value.endsWith('u')) {
                                us++;
                            } else if (value.endsWith('s')) { 
                                scars++;
                            }
                        }

     return { name: player.name, cays: cays, moms: moms, us: us, scars: scars, uo: uo, hasPlayed: hasPlayed, gameIndex: v }; // <--- THÊM uo VÀO OBJECT
                        }).filter(p => p.hasPlayed); 

                    if (cumulativeScores.length === 0) {
                        playerNames.forEach(name => rankingsByPlayer[name].push(null)); 
                        continue;
                    }

                    // Sắp xếp để xác định thứ hạng
                    // 1. Cây thấp nhất 
                    // 2. U cao nhất 
                    // 3. Móm thấp nhất
                    // 4. Sẹo thấp nhất 
                    cumulativeScores.sort((a, b) => {
                        if (a.cays !== b.cays) return a.cays - b.cays; 
                        if (a.us !== b.us) return b.us - a.us; 
                        if (a.moms !== b.moms) return a.moms - b.moms;
                        return a.scars - b.scars; 
                    });
                    
                    // Gán thứ hạng
                    let currentRank = 1;
                    for (let i = 0; i < cumulativeScores.length; i++) {
                        if (i > 0) {
                            const prev = cumulativeScores[i-1];
                            const current = cumulativeScores[i];
                            // Xử lý đồng hạng
                            if (current.cays === prev.cays && current.us === prev.us && current.moms === prev.moms && current.scars === prev.scars) {
                                // Đồng hạng, giữ nguyên rank trước đó
                            } else {
                                currentRank = i + 1; // Khác hạng, rank mới
                            }
                        }
                        // Rank được lưu trữ từ 1 đến N
                        rankingsByPlayer[cumulativeScores[i].name].push(currentRank);
                        
                        // Cập nhật Rank Counts
                        const rankKey = `Hạng ${currentRank}`;
                        rankCountsByPlayerLocal[cumulativeScores[i].name][rankKey] = (rankCountsByPlayerLocal[cumulativeScores[i].name][rankKey] || 0) + 1;
                    }
                    
                    // Xử lý người chưa chơi: Gán null
                    playerNames.forEach(name => {
                        if (!cumulativeScores.some(p => p.name === name)) {
                            rankingsByPlayer[name].push(null);
                        }
                    });
                }
                return { 
                    rankings: rankingsByPlayer, 
                    rankCounts: rankCountsByPlayerLocal 
                };
            }

            // HÀM MỚI: Tính toán dữ liệu thời gian ván đấu
            function updateGameTimeChartData(maxIndex) {
                const gameTimes = [];
                const gameLabels = [];
                let maxDurationSeconds = 0; 
                
                for (let i = 1; i <= maxIndex; i++) {
                    const gameKey = `game_${i}`;
                    gameLabels.push(`Ván ${i}`);
                    
                    const timeData = gameTimestamps[gameKey];
                    
                    if (timeData && timeData.start && timeData.end) {
                        const startTime = new Date(timeData.start).getTime();
                        const endTime = new Date(timeData.end).getTime();
                        
                        // Thời gian tính bằng giây
                        const durationSeconds = Math.round((endTime - startTime) / 1000); 
                        
                        if (durationSeconds < 0) { // Xử lý lỗi thời gian
                            gameTimes.push(null); 
                        } else {
                            gameTimes.push(durationSeconds); 
                            maxDurationSeconds = Math.max(maxDurationSeconds, durationSeconds);
                        }
                    } else {
                        gameTimes.push(null);
                    }
                }
                
                return {
                    gameLabels,
                    gameTimes, // Đơn vị là giây (seconds)
                    maxDurationSeconds // Tổng thời gian tối đa theo giây
                };
            }
            
            // 10. Hàm vẽ/cập nhật biểu đồ 
            function updateCharts() {
                const allPlayers = Array.from(scoreBody.children).map(row => ({
                    name: row.cells[0].textContent.trim(),
                    // Lấy điểm từ cột 1 đến cột gameCount
                    scores: Array.from(row.cells).slice(1, gameCount + 1).map(cell => cell.textContent),
                    row: row 
                })).filter(p => p.name); 
                
                // Chỉ số bắt đầu của cột tổng kết
                const resultStartColIndex = gameCount + 1;


                const validPlayers = allPlayers.filter(p => {
                    const row = p.row;
                    return (
                        parseInt(row.cells[resultStartColIndex].dataset.value) > 0 || // Cây
                        parseInt(row.cells[resultStartColIndex + 1].dataset.value) > 0 || // Móm
                        parseInt(row.cells[resultStartColIndex + 2].dataset.value) > 0 || // U
                        parseInt(row.cells[resultStartColIndex + 3].dataset.value) > 0 // Sẹo
                    );
                });
                
                // =========================================================================
                // 1. TÌM VÁN CUỐI CÙNG CÓ DỮ LIỆU
                // =========================================================================
                let maxGameIndex = 0;
                allPlayers.forEach(player => {
                    // Duyệt qua scores từ cuối về để tìm ván có điểm đầu tiên
                    for (let i = player.scores.length - 1; i >= 0; i--) {
                        if (player.scores[i].trim() !== '') {
                            // Ván i ứng với game index i+1
                            maxGameIndex = Math.max(maxGameIndex, i + 1);
                            break;
                        }
                    }
                });
                
                // Nếu không có điểm nào được nhập, dùng gameCount (mặc định 20)
                if (maxGameIndex === 0) {
                    maxGameIndex = gameCount; 
                }
                
                // Nếu không có người chơi nào, không vẽ biểu đồ
                if (allPlayers.length === 0) {
                    if (rankChartInstance) rankChartInstance.destroy();
                    if (moneyChartInstance) moneyChartInstance.destroy();
                    if (lineChartInstance) lineChartInstance.destroy();
                    if (gameScoreChartInstance) gameScoreChartInstance.destroy(); 
                    if (rankTimelineChartInstance) rankTimelineChartInstance.destroy(); 
                    if (gameTimeChartInstance) gameTimeChartInstance.destroy(); 
                    return;
                }
                
                // =========================================================================
                // 2. CHUẨN BỊ DỮ LIỆU CHO CÁC BIỂU ĐỒ DIỄN BIẾN THEO VÁN
                // =========================================================================
                
                const lineChartDatasets = []; 
                const gameScoreLineDatasets = []; 
                
                let maxCumulativeCay = 0;
                let maxSingleGameCay = 0;
                
                validPlayers.forEach((player, index) => {
                    const row = player.row;
                    const name = player.name;
                    
                    const gameCells = Array.from(row.cells).slice(1, maxGameIndex + 1); // Cắt đến ván cuối cùng có điểm
                    let cumulativeCays = 0;
                    const lineData = [0]; // Ván 0 luôn là 0 điểm
                    const gameScoreData = []; 
                    
                    gameCells.forEach(cell => {
                        const value = cell.textContent.trim().toLowerCase();
                        let score = getGameScore(value);
                        
                        cumulativeCays += score;
                        lineData.push(cumulativeCays);
                        gameScoreData.push(score); 
                        
                        maxCumulativeCay = Math.max(maxCumulativeCay, cumulativeCays);
                        maxSingleGameCay = Math.max(maxSingleGameCay, score);
                    });
                    
                    // --- ĐIỀU CHỈNH CHO LINE CHART (Cộng dồn) ---
                    lineChartDatasets.push({
                        label: name,
                        data: lineData,
                        borderColor: chartColors[index % chartColors.length],
                        backgroundColor: chartColors[index % chartColors.length], // SỬA: Dùng màu viền cho nền để fill box chú thích
                        borderWidth: 2,
                        pointRadius: 4,
                        // fill: false, // Bỏ thuộc tính này đi, Chart.js tự quyết định
                        tension: 0.1,
                        datalabels: {
                            display: (context) => context.dataIndex > 0 && context.dataset.data[context.dataIndex] > 0, 
                            align: 'top', 
                            anchor: 'end',
                            offset: 6,
                            color: chartColors[index % chartColors.length],
                            font: { size: 12, weight: 'bold' }
                        }
                    });
                    
                    // --- ĐIỀU CHỈNH CHO GAME SCORE CHART (Điểm từng ván) ---
                    gameScoreLineDatasets.push({
                        label: name,
                        data: gameScoreData,
                        borderColor: chartColors[index % chartColors.length],
                        backgroundColor: chartColors[index % chartColors.length],
                        borderWidth: 2,
                        pointRadius: 4,
                        tension: 0.1,
                        datalabels: {
                            display: (context) => context.dataset.data[context.dataIndex] > 0, 
                            align: 'top', 
                            anchor: 'end',
                            offset: 6,
                            color: chartColors[index % chartColors.length],
                            font: { size: 12, weight: 'bold' }
                        }
                    });
                });
                
                // --- CẮT NHÃN VÁN ĐẾN VÁN CUỐI CÓ ĐIỂM ---
                const gameLabels = [];
                for (let i = 0; i <= maxGameIndex; i++) {
                    gameLabels.push(i === 0 ? 'Bắt đầu' : `Ván ${i}`); 
                }
                
                // =========================================================================
                // 3. BIỂU ĐỒ DIỄN BIẾN SỐ CÂY (LINE CHART)
                // =========================================================================
                if (lineChartInstance) lineChartInstance.destroy();
                
                const lineCtx = document.getElementById('lineChart').getContext('2d');
                
                lineChartInstance = new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: gameLabels, 
                        datasets: lineChartDatasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: maxCumulativeCay > 0 ? maxCumulativeCay + Math.ceil(maxCumulativeCay * 0.1) : 10, // Thêm khoảng trống 10%
                                title: { 
                                    display: true, 
                                    text: 'Số cây cộng dồn', 
                                    font: { size: 12, weight: 'bold' } 
                                },
                                ticks: { font: { size: 12 } }
                            },
                            x: {
                                ticks: { font: { size: 12, weight: 'bold' } }
                            }
                        },
                        plugins: { 
                            legend: { 
                                display: true,
                                labels: { font: { size: 12 } }
                            },
                            datalabels: { display: true }
                        }
                    }
                });
                
                // =========================================================================
                // 4. BIỂU ĐỒ SỐ CÂY TỪNG VÁN (LINE CHART ĐIỂM TỪNG VÁN)
                // =========================================================================
                if (gameScoreChartInstance) gameScoreChartInstance.destroy();
                
                const gameScoreCtx = document.getElementById('gameScoreChart').getContext('2d');
                
                gameScoreChartInstance = new Chart(gameScoreCtx, {
                    type: 'line',
                    data: {
                        labels: gameLabels.slice(1), // Bỏ "Bắt đầu" vì không có điểm ván 0
                        datasets: gameScoreLineDatasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: maxSingleGameCay > 0 ? maxSingleGameCay + Math.ceil(maxSingleGameCay * 0.1) : 10, // Thêm khoảng trống 10%
                                title: { 
                                    display: true, 
                                    text: 'Số cây mỗi ván', 
                                    font: { size: 12, weight: 'bold' } 
                                },
                                ticks: { font: { size: 12 } }
                            },
                            x: {
                                ticks: { font: { size: 12, weight: 'bold' } }
                            }
                        },
                        plugins: { 
                            legend: { 
                                display: true,
                                labels: { font: { size: 12 } }
                            },
                            datalabels: { display: true }
                        }
                    }
                });
                
                // =========================================================================
                // 5. BIỂU ĐỒ XẾP HẠNG CHUNG CUỘC (BAR CHART)
                // =========================================================================
                const sortedPlayersData = calculateMoneySplit(); // Đã sort theo rank
                
                const labels = sortedPlayersData.map(p => p.name);
                const cays = sortedPlayersData.map(p => p.cays);
                const us = sortedPlayersData.map(p => p.us);
                const moms = sortedPlayersData.map(p => p.moms);
                const scars = sortedPlayersData.map(p => p.scars);
                
                // --- BIỂU ĐỒ XẾP HẠNG (Bar Chart) ---
                if (rankChartInstance) rankChartInstance.destroy();
                
                const rankCtx = document.getElementById('rankChart').getContext('2d');
                
                // --- Tính max hiện tại của dữ liệu 'cays' và tăng 10% để tạo khoảng trống phía trên ---
                const maxCays = (Array.isArray(cays) && cays.length) ? Math.max(...cays) : 0;
                const adjustedRankMax = Math.ceil(maxCays * 1.1) || 1; // đảm bảo ít nhất là 1
                
                rankChartInstance = new Chart(rankCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            { 
                                label: 'Tổng số cây',
                                data: cays, 
                                backgroundColor: 'rgba(54, 162, 235, 0.8)', 
                                categoryPercentage: 0.6, 
                                barPercentage: 0.9, 
                                datalabels: { 
                                    align: 'end', 
                                    anchor: 'end', 
                                    offset: 4,
                                    formatter: (value) => value > 0 ? value + ' cây' : '',
                                    color: '#000',
                                    font: { weight: 'bold', size: 12 }
                                } 
                            },
                            { 
                                label: 'Số ván ù',
                                data: us, 
                                backgroundColor: 'rgba(165, 235, 167, 0.8)', 
                                categoryPercentage: 0.6, 
                                barPercentage: 0.9,
                                datalabels: { 
                                    align: 'end', 
                                    anchor: 'end', 
                                    offset: 4, 
                                    color: '#1b620e', 
                                    formatter: (value) => value > -1 ? value + 'u' : '',
                                    font: { weight: 'bold', size: 12 } 
                                } 
                            },
                            { 
                                label: 'Số ván móm',
                                data: moms, 
                                backgroundColor: 'rgba(204, 0, 0, 0.8)', 
                                categoryPercentage: 0.6, 
                                barPercentage: 0.9, 
                                datalabels: { 
                                    align: 'end', 
                                    anchor: 'end', 
                                    offset: 4, 
                                    color: '#cc0000', 
                                    formatter: (value) => value > -1 ? value + 'm' : '',
                                    font: { weight: 'bold', size: 12 } 
                                } 
                            },
                            { 
                                label: 'Số ván sẹo',
                                data: scars, 
                                backgroundColor: 'rgba(255, 69, 0, 0.8)', 
                                categoryPercentage: 0.6, 
                                barPercentage: 0.9, 
                                datalabels: { 
                                    align: 'end', 
                                    anchor: 'end', 
                                    offset: 4, 
                                    color: '#ff6a33', 
                                    formatter: (value) => value > -1 ? value + 's' : '',
                                    font: { weight: 'bold', size: 12 } 
                                } 
                            }
                        ]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false, 
                        // thêm padding trên để đảm bảo legend không chồng phần ghi chú
                        layout: {
                            padding: {
                                top: 10
                            }
                        },
                        scales: { 
                            y: { 
                                beginAtZero: true,
                                // đặt max "ảo" cao hơn 10% để tạo khoảng trống phía trên
                                suggestedMax: adjustedRankMax,
                                ticks: { font: { size: 12 } }
                            }, 
                            x: { stacked: false, ticks: { font: { size: 12, weight: 'bold' } } }
                        },
                        plugins: {
                            datalabels: { 
                                color: '#000',
                                font: { weight: 'bold', size: 12 }
                            },
                            legend: { 
                                position: 'top', 
                                labels: { 
                                    font: { size: 12 },
                                    usePointStyle: false,
                                    boxWidth: 20
                                } 
                            },
                            tooltip: {
                                callbacks: {
                                    label: (context) => {
                                        let label = context.dataset.label || '';
                                        const value = context.parsed.y;
                                        let unit = '';

                                        if (label.includes('cây')) {
                                            unit = ' cây';
                                            label = 'Tổng số cây';
                                        } else if (label.includes('ù')) {
                                            unit = ' ù';
                                            label = 'Số ván ù';
                                        } else if (label.includes('móm')) {
                                            unit = ' móm';
                                            label = 'Số ván móm';
                                        } else if (label.includes('sẹo')) {
                                            unit = ' sẹo';
                                            label = 'Số ván sẹo';
                                        }

                                        return `${label}: ${value}${unit}`;
                                    }
                                }
                            }
                        }
                    }
                });
                
                // =========================================================================
                // 6. BIỂU ĐỒ CHIA TIỀN (DOUGHNUT CHART)
                // =========================================================================
                const money = sortedPlayersData.map(p => p.money);
                
                // --- BIỂU ĐỒ CHIA TIỀN (Doughnut, dùng moneyChartInstance, labels, money) ---
                if (moneyChartInstance) moneyChartInstance.destroy();
                
                const moneyCtx = document.getElementById('moneyChart').getContext('2d');
                
                // Tạo màu dựa trên chartColors (fallback nếu ít hơn label)
                const moneyBackgrounds = labels.map((_, i) => chartColors[i % chartColors.length]);
                
                moneyChartInstance = new Chart(moneyCtx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,    // mảng tên người chơi (gốc)
                        datasets: [{
                            label: 'Tiền phải chia (đ)',
                            data: money,    // mảng tiền tương ứng (gốc)
                            backgroundColor: moneyBackgrounds,
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '40%', // lỗ giữa
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    color: '#000',
                                    font: { size: 12 },
                                    boxWidth: 14
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const name = context.label || '';
                                        const val = context.parsed || 0;
                                        return `${name}: ${val.toLocaleString('vi-VN')} đ`;
                                    }
                                }
                            },
                            // ChartDataLabels đã được register ở trên file; ta dùng để show name + tiền trên từng miếng
                            datalabels: {
                                color: '#fff',
                                font: { weight: 'bold', size: 16 },
                                formatter: (value, ctx) => {
                                    const label = ctx.chart.data.labels[ctx.dataIndex] || '';
                                    // Nếu giá trị 0 thì không hiển thị
                                    if (!value || value === 0) return '';
                                    return `${label}\n${value.toLocaleString('vi-VN')} đ`;
                                },
                                // Đặt vị trí label nằm ở giữa miếng bánh
                                anchor: 'center',
                                align: 'center'
                            }
                        }
                    },
                    plugins: [
                        {
                            id: 'centerTextMoney',
                            afterDraw: (chart) => {
                                const { ctx, chartArea } = chart;
                                const { left, right, top, bottom, width, height } = chartArea;
                                ctx.save();
                
                                // Tính tổng tiền từ dữ liệu hiện tại (mảng money)
                                const total = (Array.isArray(money) ? money.reduce((s, v) => s + (Number(v) || 0), 0) : 0);
                
                                // Vẽ 2 dòng: tiêu đề nhỏ và tổng tiền lớn
                                const centerX = (left + right) / 2;
                                const centerY = (top + bottom) / 2;
                
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                
                                // Dòng tiêu đề nhỏ
                                ctx.font = '600 15px Arial';
                                ctx.fillStyle = '#333';
                                ctx.fillText('Tổng tiền bàn', centerX, centerY - 10);
                
                                // Dòng tổng tiền lớn
                                ctx.font = '700 20px Arial';
                                ctx.fillStyle = '#ff0000';
                                ctx.fillText(total.toLocaleString('vi-VN') + ' đ', centerX, centerY + 12);
                
                                ctx.restore();
                            }
                        }
                    ]
                });
                
                // =========================================================================
                // 7. BIỂU ĐỒ DIỄN BIẾN THỨ TỰ XẾP HẠNG THEO TỪNG VÁN (LINE CHART RANK TIMELINE)
                // =========================================================================
                const cumulativeData = calculateCumulativeRankings(allPlayers, maxGameIndex);
                rankCountsByPlayer = cumulativeData.rankCounts; // Gán biến toàn cục
                
                const rankTimelineDatasets = [];
                Object.keys(cumulativeData.rankings).forEach((name, index) => {
                    rankTimelineDatasets.push({
                        label: name,
                        data: cumulativeData.rankings[name],
                        borderColor: chartColors[index % chartColors.length],
                        backgroundColor: chartColors[index % chartColors.length],
                        borderWidth: 2,
                        pointRadius: 4,
                        tension: 0.1,
                        datalabels: {
                            display: (context) => context.dataset.data[context.dataIndex] !== null,
                            align: 'top', 
                            anchor: 'end',
                            offset: 6,
                            color: chartColors[index % chartColors.length],
                            font: { size: 12, weight: 'bold' },
                            formatter: (value, context) => {
                                // Hiển thị: Tên người chơi (Hạng X)
                                return value !== null ? `${context.dataset.label}` : '';
                            }
                        }
                    });
                });
                
                if (rankTimelineChartInstance) rankTimelineChartInstance.destroy();
                
                const rankTimelineCtx = document.getElementById('rankTimelineChart').getContext('2d');
                
                rankTimelineChartInstance = new Chart(rankTimelineCtx, {
                    type: 'line',
                    data: {
                        labels: gameLabels.slice(1), // Bắt đầu từ Ván 1
                        datasets: rankTimelineDatasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                reverse: true, // Rank 1 ở trên cùng
                                min: 0,
                                max: allPlayers.length,
                                ticks: {
                                    stepSize: 1,
                                    font: { size: 12 },
                                    callback: (value) => `Hạng ${value}`
                                },
                                title: { display: true, text: 'Xếp hạng', font: { size: 12, weight: 'bold' } }
                            },
                            x: {
                                ticks: { font: { size: 12, weight: 'bold' } }
                            }
                        },
                        plugins: { 
                            legend: { display: true, labels: { font: { size: 12 } } },
                            tooltip: { 
                                callbacks: {
                                    label: (context) => `${context.dataset.label}: Hạng ${context.parsed.y}`
                                }
                            },
                            datalabels: { display: true }
                        }
                    }
                });
                
                // =========================================================================
                // 8. BIỂU ĐỒ DIỄN BIẾN THỜI GIAN CÁC VÁN ĐẤU (BAR CHART)
                // =========================================================================
                const gameTimeData = updateGameTimeChartData(maxGameIndex); // Truyền maxGameIndex để cắt data
                
                if (gameTimeChartInstance) gameTimeChartInstance.destroy();
                
                const gameTimeCtx = document.getElementById('gameTimeChart').getContext('2d');
                
                // Tính toán max Y cho trục thời gian
                let maxYDurationSeconds = gameTimeData.maxDurationSeconds;
                // Nếu có data, tăng thêm 60 giây (1 phút) cho khoảng trống legend
                if (maxYDurationSeconds > 0) {
                    // Tăng 10% và làm tròn đến phút gần nhất (hoặc 60 giây)
                    const minSpace = 60; // Thêm ít nhất 1 phút khoảng trống
                    maxYDurationSeconds = Math.ceil((maxYDurationSeconds + minSpace) / 60) * 60; 
                } else {
                    maxYDurationSeconds = 60; // Mặc định ít nhất là 1 phút để thấy trục Y
                }
                
                gameTimeChartInstance = new Chart(gameTimeCtx, {
                    type: 'bar',
                    data: {
                        labels: gameTimeData.gameLabels, // Dùng nhãn đã cắt
                        datasets: [
                            {
                                label: 'Thời gian hoàn thành (phút:giây)',
                                data: gameTimeData.gameTimes, 
                                backgroundColor: 'rgba(255, 159, 64, 0.8)',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { 
                                    display: true, 
                                    text: 'Thời gian (Phút)', 
                                    font: { size: 12, weight: 'bold' } 
                                },
                                ticks: {
                                    // Hiển thị nhãn trục Y là phút
                                    callback: (value) => `${(value / 60).toFixed(0)} phút`
                                },
                                max: maxYDurationSeconds + (maxYDurationSeconds / 10),
                            },
                            x: {
                                ticks: { font: { size: 12, weight: 'bold' } }
                            }
                        },
                        plugins: { 
                            legend: { 
                                display: true,
                                labels: {
                                    font: { size: 12 },
                                    usePointStyle: false, // Dùng box fill màu (Mặc định cho Bar)
                                    boxWidth: 20
                                }
                            },
                            datalabels: {
                                display: (context) => context.dataset.data[context.dataIndex] !== null,
                                align: 'end', 
                                anchor: 'end',
                                offset: 8, 
                                color: '#CC5500', 
                                font: { weight: 'bold', size: 12 },
                                // Định dạng giá trị thành mm:ss
                                formatter: (value) => {
                                    if (value === null) return '';
                                    const minutes = Math.floor(value / 60);
                                    const seconds = value % 60;
                                    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                                }
                            }
                        }
                    }
                });
            }
            
            // =========================================================================
            // CHỨC NĂNG MỚI: TỔNG KẾT VÀ PHÂN TÍCH TRẬN ĐẤU
            // =========================================================================
            
            function formatDuration(seconds) {
                if (seconds < 0 || isNaN(seconds)) return 'N/A';
                const h = Math.floor(seconds / 3600);
                const m = Math.floor((seconds % 3600) / 60);
                const s = Math.floor(seconds % 60);
                return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            }

            function formatTime(dateString) {
                if (!dateString) return 'N/A';
                const date = new Date(dateString);
                // Lấy múi giờ địa phương (đã tính GMT/UTC từ ISO string của gameTimestamps)
                const h = date.getHours().toString().padStart(2, '0');
                const m = date.getMinutes().toString().padStart(2, '0');
                const s = date.getSeconds().toString().padStart(2, '0');
                return `${h}:${m}:${s}`;
            }
            
            
          function locdau(str) {
  var AccentsMap = [
    "aàảãáạăằẳẵắặâầẩẫấậ",
    "AÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬ",
    "dđ", "DĐ",
    "eèẻẽéẹêềểễếệ",
    "EÈẺẼÉẸÊỀỂỄẾỆ",
    "iìỉĩíị",
    "IÌỈĨÍỊ",
    "oòỏõóọôồổỗốộơờởỡớợ",
    "OÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢ",
    "uùủũúụưừửữứự",
    "UÙỦŨÚỤƯỪỬỮỨỰ",
    "yỳỷỹýỵ",
    "YỲỶỸÝỴ"    
  ];
  for (var i=0; i<AccentsMap.length; i++) {
    var re = new RegExp('[' + AccentsMap[i].substr(1) + ']', 'g');
    var char = AccentsMap[i][0];
    str = str.replace(re, char);
  }
  str= str.replace(" ","");
  return str;
}
            
            
function taoKhungAvatar(danhSachTen) {
    // 1. Chuyển chuỗi đầu vào thành mảng các tên đã được chuẩn hóa (tên class)
    const tenClassArray = danhSachTen.split(',')
                                     .map(ten => ten.trim().toUpperCase()) // Loại bỏ khoảng trắng và chuyển thành IN HOA
                                     .filter(ten => ten.length > 0);       // Loại bỏ các phần tử rỗng

    // 2. Dùng map để tạo mảng các chuỗi HTML avatar
    const htmlAvatarArray = tenClassArray.map(tenClass => {
        // tenClass lúc này là tên chuẩn hóa (ví dụ: "DUONG", "HOANG")
        return `
            <div class="shape-outer circle">
                <div class="shape-inner-${locdau(tenClass)} circle"></div>
            </div>`;
    });

    // 3. Nối (join) các phần tử HTML lại thành một chuỗi duy nhất và trả về
    return htmlAvatarArray.join('');
}      
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            // Hàm tính toán và hiển thị tóm tắt trận đấu
            function updateSummary(playersData) {
                const allPlayers = Array.from(scoreBody.children).map(row => ({
                    name: row.cells[0].textContent.trim(),
                    scores: Array.from(row.cells).slice(1, gameCount + 1).map(cell => cell.textContent)
                })).filter(p => p.name);
                
                let maxGameIndex = 0;
                let totalScorePerGame = {}; // Để lưu tổng điểm mỗi ván
                let momsGamesCount = 0; // Số ván có người móm
                let scarsGamesCount = 0; // Số ván có người sẹo
                
                allPlayers.forEach(player => {
                    player.scores.forEach((scoreStr, i) => {
                        const score = extractNumericScore(scoreStr);
                        const gameIndex = i + 1;
                        if (scoreStr.trim() !== '') {
                            maxGameIndex = Math.max(maxGameIndex, gameIndex);
                            totalScorePerGame[gameIndex] = (totalScorePerGame[gameIndex] || 0) + score;
                        }
                    });
                });
                
                // 1. Dữ liệu Cơ Bản
                const totalPlayers = allPlayers.length;
                const playersNames = allPlayers.map(p => p.name);
                const moneyPerGame = parseInt(document.getElementById('moneyInput').value) || 0;
                const splitCount = parseInt(document.getElementById('splitCountInput').value) || 2;
                
                let totalCays = 0;
                let totalMoms = 0;
                let totalUs = 0;
                let totalScars = 0;
                let completedGames = 0; 
                let totalEffectiveDurationSeconds = 0; 
                let gameDurations = [];
                
                let matchStartTime = null;
                let matchEndTime = null;
                
                // 2. Tính Toán Thời Gian & Thống Kê Chung
                let gamesWithMom = new Set();
                let gamesWithScar = new Set();
                
                for (let i = 1; i <= maxGameIndex; i++) {
                    const gameKey = `game_${i}`;
                    const timeData = gameTimestamps[gameKey];
                    let isGameCompleted = false;

                    // Cập nhật Thời gian Bắt đầu (Earliest Start)
                    if (timeData && timeData.start && (!matchStartTime || new Date(timeData.start) < new Date(matchStartTime))) {
                        matchStartTime = timeData.start;
                    }
                    
                    // Cập nhật Thời gian Kết thúc (Latest End)
                    if (timeData && timeData.end) {
                        isGameCompleted = true;
                        completedGames++;
                        if (!matchEndTime || new Date(timeData.end) > new Date(matchEndTime)) {
                            matchEndTime = timeData.end;
                        }
                        
                        // Tính Tổng thời gian chơi hiệu quả
                        const startTime = new Date(timeData.start).getTime();
                        const endTime = new Date(timeData.end).getTime();
                        if (endTime > startTime) {
                            const durationSeconds = Math.round((endTime - startTime) / 1000);
                            totalEffectiveDurationSeconds += durationSeconds;
                            gameDurations.push({ index: i, duration: durationSeconds });
                        }
                    }
                    
                    // Kiểm tra móm/sẹo cho ván i
                    if (isGameCompleted) {
                        allPlayers.forEach(p => {
                            const scoreStr = p.scores[i - 1]; // scores là mảng 0-index
                            const score = scoreStr ? scoreStr.trim().toLowerCase() : '';
                            
                            if (score.endsWith('m')) {
                                gamesWithMom.add(i);
                            } else if (score.endsWith('s')) {
                                gamesWithScar.add(i);
                            }
                        });
                    }
                }
                
                momsGamesCount = gamesWithMom.size;
                scarsGamesCount = gamesWithScar.size;
                
                // 3. Tổng hợp thống kê của tất cả người chơi
                playersData.forEach(p => {
                    totalCays += p.cays;
                    totalMoms += p.moms;
                    totalUs += p.us;
                    totalScars += p.scars;
                });
                
                const avgCayPerGame = completedGames > 0 ? (totalCays / completedGames).toFixed(2) : 0;
                
                // 4. Tìm Ván có số cây cao nhất/thấp nhất (chỉ tính các ván đã hoàn thành)
                let maxGameCays = 0;
                let minGameCays = Infinity;
                let maxGameCaysIndex = [];
                let minGameCaysIndex = [];
                
                Object.keys(totalScorePerGame).forEach(gameIndexStr => {
                    const gameIndex = parseInt(gameIndexStr);
                    const totalScore = totalScorePerGame[gameIndex];
                    
                    // Chỉ xem xét ván đã hoàn thành (có thời gian kết thúc)
                    if (gameTimestamps[`game_${gameIndex}`] && gameTimestamps[`game_${gameIndex}`].end) {
                        if (totalScore > maxGameCays) {
                            maxGameCays = totalScore;
                            maxGameCaysIndex = [gameIndex];
                        } else if (totalScore === maxGameCays && totalScore > 0) {
                            maxGameCaysIndex.push(gameIndex);
                        }
                        
                        if (totalScore < minGameCays) {
                            minGameCays = totalScore;
                            minGameCaysIndex = [gameIndex];
                        } else if (totalScore === minGameCays) {
                            minGameCaysIndex.push(gameIndex);
                        }
                    }
                });
                
                if (minGameCays === Infinity) {
                    minGameCays = 0; // Nếu không có ván nào, đặt lại min về 0
                }

                // 5. Xác định Nhà Vô Địch và Á quân
                // playersData đã được sắp xếp theo rank chính xác
                const champion = playersData[0];
                const runnerUp = playersData.length > 1 ? playersData[1] : null;
                const losersList = playersData.slice(-splitCount); // Lấy danh sách những người thua cuộc cuối cùng
                
                // Lấy dữ liệu Rank Counts từ biến toàn cục
                // const rankCountsByPlayer đã được gán ở updateCharts()

                // 6. Tổng hợp dữ liệu thành HTML
                let summaryHTML = '';
                
                // a) Tiêu đề & Thời gian
                const matchDate = matchStartTime ? new Date(matchStartTime).toLocaleDateString('vi-VN') : new Date().toLocaleDateString('vi-VN');
                const title = `TỔNG KẾT TRẬN ĐẤU BILLIARDS NGÀY ${matchDate}`;
                
                updatePageTitle(title);
                
                document.getElementById('summaryTitle').textContent = title;

                let totalMatchDurationSeconds = 0;
                if (matchStartTime && matchEndTime) {
                    totalMatchDurationSeconds = Math.round((new Date(matchEndTime) - new Date(matchStartTime)) / 1000);
                }
                
                summaryHTML += `<h3>THÔNG TIN CHUNG VỀ TRẬN ĐẤU</h3>`;
                summaryHTML += `<p>• <b>Thời gian:</b> Bắt đầu lúc <span class="summary-data-normal">${formatTime(matchStartTime)}</span>, kết thúc lúc <span class="summary-data-normal">${formatTime(matchEndTime)}</span> (ngày <span class="summary-data-normal">${matchDate}</span>). Tổng thời gian trận đấu kéo dài <b class="summary-data-normal">${formatDuration(totalMatchDurationSeconds)}</b></p>`;

                summaryHTML += `<p>• <b>Số liệu chung:</b> Trận đấu diễn ra gồm tất cả <span class="summary-data-normal">${completedGames}</span> ván giữa <span class="summary-data-normal">${totalPlayers}</span> người chơi là: <b>${playersNames.join(', ')}</b>.</p>`;
                
                summaryHTML += `<p>• <b>Tổng số cây:</b> <span class="summary-data-cays">${totalCays}</span> cây. Số cây trung bình mỗi ván: <span class="summary-data-cays">${avgCayPerGame}</span> cây. Số ván có người móm: <span class="summary-data-moms">${momsGamesCount}</span> ván (chiếm <b>${(momsGamesCount / completedGames * 100).toFixed(1)}%</b>). Số ván có người sẹo: <span class="summary-data-scars">${scarsGamesCount}</span> ván (chiếm <b>${(scarsGamesCount / completedGames * 100).toFixed(1)}%</b>).</p>`;
                var  anhchiatien = "";
                if (moneyPerGame > 0) {
                    const loserNames = losersList.map(p => `<b>${p.name}</b>`).join(', ');
                    const loserNames1 = losersList.map(p => `${p.name}`).join(', ');
                    anhchiatien = taoKhungAvatar(loserNames1); 
                    summaryHTML += `<p>• <b>Chia tiền:</b> Tổng tiền bàn <span class="summary-data-money">${moneyPerGame.toLocaleString('vi-VN')} đồng</span>, chia cho <span class="summary-data-normal">${splitCount}</span> người chơi là: ${loserNames}.</p>`;
                }


                // b) Vô địch
                
                const anhnhavodich =  taoKhungAvatar(champion.name); 
                
                
                
                if (champion) {
                    summaryHTML += `<h3>KẾT QUẢ VÀ THÀNH TÍCH CHUNG CUỘC</h3>`;
                    
                    var ss=``; if (champion.uo>0) ss=`, trong đó có <span class="summary-data-uo">${champion.uo}</span> ván Ù trắng (0 cây)`;

                    summaryHTML += `
 
 <div class="banner-nen">
    <div class="banner-content">
      ${anhnhavodich}
    </div>
    
    
     <div class="banner-content-l">
       ${anhchiatien}
    </div>
</div>
   

                    <p>• <b>VÔ ĐỊCH:</b> Thuộc về người chơi <span class="summary-player-name">${champion.name.toUpperCase()}</span> (Hạng 1) với thành tích chỉ <span class="summary-data-cays">${champion.cays}</span> cây, <span class="summary-data-us">${champion.us}</span> ván ù${ss}, <span class="summary-data-moms">${champion.moms}</span> ván móm và <span class="summary-data-scars">${champion.scars}</span> ván sẹo. `;
                    
                    if (runnerUp && runnerUp !== champion) {
                        summaryHTML += `Người chơi <span class="summary-player-name">${runnerUp.name}</span> xếp thứ <span class="summary-data-normal">2</span> với <span class="summary-data-cays">${runnerUp.cays}</span> cây.`;
                    }
                    
                    summaryHTML += '</p>';
                }

                // c) Phân tích chi tiết người chơi
                
                // Sắp xếp lại playersData theo tên để hiển thị nhất quán
                
                

                summaryHTML += '<h3>PHÂN TÍCH HIỆU SUẤT CÁ NHÂN</h3>';
                
                // Cần tính lại thứ hạng cuối cùng (final rank) cho mỗi người chơi
                const finalRankedPlayers = calculateMoneySplit(); // Đã sort
                
                playersData.forEach((p) => {
                    if (completedGames === 0 && p.cays === 0) return; // Bỏ qua người chơi không có điểm
                    
                    // Lấy lại thứ hạng cuối cùng của người chơi này
                    const finalRank = finalRankedPlayers.findIndex(fp => fp.name === p.name) + 1;
                    
                    const averageCay = completedGames > 0 ? (p.cays / completedGames).toFixed(2) : 0;
                    const totalMoneyLost = p.money.toLocaleString('vi-VN');
                    
                    var ss=``; if (p.uo>0) ss=`, trong đó có <span class="summary-data-uo">${p.uo}</span> ván Ù trắng (0 cây)`;
                    
                    summaryHTML += `<p>• <span class="summary-player-name">${p.name}</span> (Hạng <span class="summary-data-normal">${finalRank}</span> chung cuộc): Tổng <span class="summary-data-cays">${p.cays}</span> cây (Trung bình: <span class="summary-data-cays">${averageCay}</span> cây/ván). Trong <b>${completedGames}</b> ván của trận đấu có <span class="summary-data-us">${p.us}</span> ván Ù (chiếm <b>${(p.us / completedGames * 100).toFixed(1)}%</b>)${ss}, <span class="summary-data-moms">${p.moms}</span> ván Móm (chiếm <b>${(p.moms / completedGames * 100).toFixed(1)}%</b>), <span class="summary-data-scars">${p.scars}</span> ván Sẹo (chiếm <b>${(p.scars / completedGames * 100).toFixed(1)}%</b>).`;
                    
                    // Thêm Rank Counts
                    const pRankCounts = rankCountsByPlayer[p.name];
                    if (pRankCounts && Object.keys(pRankCounts).length > 0) {
                        const rankDetails = Object.keys(pRankCounts).sort((a,b) => parseInt(a.match(/\d+/)[0]) - parseInt(b.match(/\d+/)[0])).map(rankKey => {
                            const rankNum = parseInt(rankKey.match(/\d+/)[0]);
                            const count = pRankCounts[rankKey];
                            let colorClass = 'summary-data-normal';
                            if (rankNum === 1) colorClass = 'summary-data-us';
                            if (rankNum === playersData.length) colorClass = 'summary-data-moms';

                            return `<span class="${colorClass}">${rankKey}</span> trong <b>${count}</b> ván`;
                        }).join(', ');
                        summaryHTML += ` (Đã giữ vị trí: ${rankDetails}).`;
                    }
                    
                    if (p.money > 0) {
                        summaryHTML += ` Phải chia tiền là <span class="summary-data-money">${totalMoneyLost} đồng</span>.`;
                    } else if (p.cays > 0) {
                        summaryHTML += ` <span class="summary-data-money">Không phải chia tiền</span>.`;
                    }
                    summaryHTML += '</p>';
                });

                
                // d) Thống kê ván đấu
                if (completedGames > 0) {
                    summaryHTML += '<h3>THỐNG KÊ CHI TIẾT VÁN ĐẤU</h3>';
                    
                    const totalDurationSeconds = gameDurations.reduce((a, b) => a + b.duration, 0);
                    const avgDurationSeconds = totalDurationSeconds / gameDurations.length;
                    
                    // Thống kê thời gian
                    const minDuration = Math.min(...gameDurations.map(d => d.duration));
                    const maxDuration = Math.max(...gameDurations.map(d => d.duration));
                    const fastestGameIndex = gameDurations.find(d => d.duration === minDuration).index;
                    const slowestGameIndex = gameDurations.find(d => d.duration === maxDuration).index;
                    
                    summaryHTML += `<p>• <b>Thời gian thi đấu:</b> Thời gian trung bình để hoàn thành một ván đấu là <span class="summary-data-normal">${formatDuration(avgDurationSeconds)}</span>. <span class="summary-data-normal">Ván ${fastestGameIndex}</span> là ván nhanh nhất với thời gian là (<span class="summary-data-normal">${formatDuration(minDuration)}</span>), <span class="summary-data-normal">Ván ${slowestGameIndex}</span> là ván chậm nhất với thời gian là (<span class="summary-data-normal">${formatDuration(maxDuration)}</span>).</p>`;
                    
                    // Thống kê điểm ván
                    const maxGameCaysStr = maxGameCaysIndex.length > 0 ? `Ván ${maxGameCaysIndex.join(', ')}` : 'N/A';
                    const minGameCaysStr = minGameCaysIndex.length > 0 ? `Ván ${minGameCaysIndex.join(', ')}` : 'N/A';

                    summaryHTML += `<p>• <b>Thống kê số cây trong trận:</b> Ván có số cây cao nhất là ván <span class="summary-data-normal">${maxGameCaysStr}</span> (với <span class="summary-data-cays">${maxGameCays}</span> cây). Ván có số cây thấp nhất là ván <span class="summary-data-normal">${minGameCaysStr}</span> (với <span class="summary-data-cays">${minGameCays}</span> cây).</p>`;

                }

                // Bổ sung các chỉ tiêu mới



                // Tìm người có tỷ lệ ù cao nhất để phân tích sâu
       let maxUPlayer = { name: '', percent: 0 };
playersData.forEach(p => {
    // Tính tỷ lệ ù như số (không phải chuỗi) để so sánh chính xác
    const uPercent = completedGames > 0 ? (p.us / completedGames * 100) : 0;
    if (uPercent > maxUPlayer.percent) {
        maxUPlayer = { name: p.name, percent: parseFloat(uPercent.toFixed(1)), sovanu: p.us };
    }
});

                
                
                if (maxUPlayer.percent > 0) {
                    summaryHTML += `<p>• <b>Người chơi có tỷ lệ ù cao nhất là:</b> <span class="summary-player-name">${maxUPlayer.name}</span> với <span class="summary-data-us">${maxUPlayer.sovanu}</span> ván ù, đạt tỷ lệ: <span class="summary-data-us">${maxUPlayer.percent}%</span>.</p>`;
                }

                // 2. Chuỗi thắng liên tiếp dài nhất
                let maxStreak = 0;
                let maxStreakPlayer = '';
                let maxStreakStart = 0;
                let maxStreakEnd = 0;
                allPlayers.forEach(p => {
                    let currentStreak = 0;
                    let bestStreak = 0;
                    let start = 0;
                    p.scores.forEach((score, idx) => {
                        if (score.trim().toLowerCase().endsWith('u')) {
                            currentStreak++;
                            if (currentStreak > bestStreak) {
                                bestStreak = currentStreak;
                                maxStreakStart = start + 1;
                                maxStreakEnd = idx + 1;
                            }
                        } else {
                            currentStreak = 0;
                            start = idx + 1;
                        }
                    });
                    if (bestStreak > maxStreak) {
                        maxStreak = bestStreak;
                        maxStreakPlayer = p.name;
                        // Lưu start và end cho người này
                    }
                });
                if (maxStreak > 1) {
                    summaryHTML += `<p>• <b>Chuỗi ù liên tiếp dài nhất:</b> Thuộc về <span class="summary-player-name">${maxStreakPlayer}</span> với <span class="summary-data-us">${maxStreak}</span> ván liên tiếp.</p>`;
                }

                // 3. Sự biến động xếp hạng trận đấu
                let leaderChanges = 0;
                const rankings = calculateCumulativeRankings(allPlayers, maxGameIndex).rankings;
                let prevLeader = null;
                for (let v = 1; v <= maxGameIndex; v++) {
                    let currentLeader = null;
                    let minRank = Infinity;
                    Object.keys(rankings).forEach(name => {
                        const rank = rankings[name][v-1];
                        if (rank !== null && rank < minRank) {
                            minRank = rank;
                            currentLeader = name;
                        }
                    });
                    if (currentLeader && currentLeader !== prevLeader) {
                        leaderChanges++;
                        prevLeader = currentLeader;
                    }
                }
                
                summaryHTML += `<p>• <b>Biến động xếp hạng:</b> Trận đấu có <span class="summary-data-normal">${(leaderChanges-1)}</span> lần thay đổi người dẫn đầu.</p>`;

                // 4. Khoảng cách điểm (cây) giữa các hạng
                if (playersData.length > 1) {
                    const gapLeaderLast = playersData[playersData.length - 1].cays - champion.cays;
                    const avgGap = playersData.reduce((sum, p, idx) => idx > 0 ? sum + (p.cays - playersData[idx-1].cays) : sum, 0) / (playersData.length - 1);
                    summaryHTML += `<p>• <b>Khoảng cách điểm giữa các hạng:</b> Chênh lệch giữa vô địch và hạng chót là <span class="summary-data-cays">${gapLeaderLast}</span> cây, với khoảng cách trung bình giữa các hạng là <span class="summary-data-cays">${avgGap.toFixed(1)}</span> cây. </p>`;
                }

             
                document.getElementById('matchSummaryDetails').innerHTML = summaryHTML;
            }

         // HÀM MỚI: Tìm chỉ số ván cuối cùng có dữ liệu
            function findLastGameIndexWithData() {
                let lastIndex = 0;
                const rows = Array.from(scoreBody.children);
                
                // Lặp qua các cột ván ngược từ gameCount đến 1
                for (let i = gameCount; i >= 1; i--) {
                    let hasData = false;
                    for (const row of rows) {
                        // row.cells[i] là cột ván thứ i (vì index 0 là tên)
                        if (row.cells.length > i && row.cells[i].textContent.trim() !== '') {
                            hasData = true;
                            break;
                        }
                    }
                    if (hasData) {
                        lastIndex = i;
                        break;
                    }
                }
                return lastIndex; // Trả về 0 nếu chưa có ván nào được chơi
            }

           // HÀM: Kết xuất ra ảnh PNG (ĐÃ SỬA)
exportButton.addEventListener('click', async () => {
    const appContainer = document.getElementById('appContainer');
 

    // 2️⃣ Clone toàn bộ giao diện để thao tác export
    const clone = appContainer.cloneNode(true);

    // Ẩn controls, input, nút, v.v.
    clone.querySelectorAll('.controls, button, input').forEach(el => el.style.display = 'none');

 
    // 8️⃣ Sao chép biểu đồ (canvas)
    const originalCanvases = Array.from(appContainer.querySelectorAll('canvas'));
    const cloneCanvases = Array.from(clone.querySelectorAll('canvas'));
    cloneCanvases.forEach((cCanvas, i) => {
        const src = originalCanvases[i];
        if (src && cCanvas) {
            cCanvas.width = src.width;
            cCanvas.height = src.height;
            const ctx = cCanvas.getContext('2d');
            ctx.drawImage(src, 0, 0);
        }
    });

    // 9️⃣ Xuất PNG (toàn trang, gồm bảng + biểu đồ + tổng kết)
    const tempDiv = document.createElement('div');
    tempDiv.style.position = 'absolute';
    tempDiv.style.top = '-9999px';
    tempDiv.style.left = '0';
    tempDiv.style.width = '100%';
    tempDiv.appendChild(clone);
    document.body.appendChild(tempDiv);

    const canvas = await html2canvas(clone, {
        backgroundColor: '#ffffff',
        scale: 1,
         windowWidth: 1920, // <--- CẦN ĐẢM BẢO GIÁ TRỊ NÀY LÀ 2000
            windowHeight: appContainer.scrollHeight, // Chụp toàn bộ nội dung
        useCORS: true,
        logging: false
    });


// Lấy đối tượng ngày hiện tại
const today = new Date();

// Lấy ngày, tháng, năm
const day = String(today.getDate()).padStart(2, '0'); // Định dạng dd (ví dụ: 05, 12)
const month = String(today.getMonth() + 1).padStart(2, '0'); // Lưu ý: getMonth() trả về 0-11, nên cần +1. Định dạng mm
const year = today.getFullYear();

// Tạo chuỗi ngày định dạng dd.mm.yyyy
const dateSuffix = `${day}.${month}.${year}`; // Ví dụ: 15.10.2025

// Tên file mới sẽ là 'tongket_billiards_15.10.2025.png'
const fileName = `tongket_billiards_${dateSuffix}.png`;

    const link = document.createElement('a');
    link.download = fileName;
    link.href = canvas.toDataURL('image/png');
    link.click();

    tempDiv.remove();
});

exportHtmlButton.addEventListener('click', () => {
    const appContainer = document.getElementById('appContainer');
    const originalTable = document.getElementById('scoreTable');
   
 
    // 2️⃣ Clone toàn bộ giao diện để thao tác export
    const clone = appContainer.cloneNode(true);

    // Ẩn controls, input, nút, v.v.
    clone.querySelectorAll('.controls, button, input').forEach(el => el.style.display = 'none');


  

    // 8️⃣ Thay canvas bằng img với dataURL nhúng
    const originalCanvases = Array.from(appContainer.querySelectorAll('canvas'));
    const cloneChartBoxes = Array.from(clone.querySelectorAll('.chart-box'));
    originalCanvases.forEach((src, i) => {
        if (src) {
            const img = document.createElement('img');
            img.src = src.toDataURL('image/png');
            img.style.width = '100%';
            img.style.height = 'auto';
            const chartContainer = cloneChartBoxes[i].querySelector('div');
            chartContainer.innerHTML = '';
            chartContainer.appendChild(img);
        }
    });
    // Lấy đối tượng ngày hiện tại
const today = new Date();

// Lấy ngày, tháng, năm
const day = String(today.getDate()).padStart(2, '0'); // Định dạng dd (ví dụ: 05, 12)
const month = String(today.getMonth() + 1).padStart(2, '0'); // Lưu ý: getMonth() trả về 0-11, nên cần +1. Định dạng mm
const year = today.getFullYear();

const dateSuffix = `${day}.${month}.${year}`; // Ví dụ: 15.10.2025
    // 9️⃣ Tạo nội dung HTML đầy đủ
    const styles = Array.from(document.querySelectorAll('style')).map(style => style.outerHTML).join('\n');
    const htmlContent = `
<!DOCTYPE html>
<html lang="vi">
<head>
		
	
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1920, initial-scale=1.0">
    <title>Tổng kết Billiards ${day}.${month}.${year}</title>
    ${styles}
</head>
<body>

	
	${clone.outerHTML}
</body>
</html>
    `;

   
    
    

// Tạo chuỗi ngày định dạng dd.mm.yyyy


// Tên file mới sẽ là 'tongket_billiards_15.10.2025.html'
const fileName = `tongket_billiards_${dateSuffix}.html`;

// Đoạn code gốc được sửa:
const blob = new Blob([htmlContent], { type: 'text/html' });
const url = URL.createObjectURL(blob);
const link = document.createElement('a');
link.download = fileName; // Sử dụng tên file đã có thêm ngày tháng
    
    
    
    
    
    
    link.href = url;
    link.click();
    URL.revokeObjectURL(url);
});


          


         

            // Bắt đầu ứng dụng: Tải dữ liệu và tính toán
            initializeTable();
            
            // Logic để đảm bảo chỉ có 3 người chơi mặc định khi khởi tạo lần đầu (Nếu chưa có data)
            loadDataFromDatabase((savedData) => {
                if (savedData && savedData.players.length === 0 && defaultPlayerNames.length > 0) {
                    
                     fullRecalculate();
              
                } else if (!savedData) {
                    // Lần đầu tiên chạy
              
                }
            });
        });

      
        
        
        
        
        
        
        /**
 * Hàm kiểm tra và ẩn các cột (ván đấu) không có dữ liệu trong bảng.
 * Logic: Tự động xác định phạm vi cột Ván đấu (dựa trên class 'game-score-col' trong hàng tiêu đề)
 * và ẩn các cột hoàn toàn trống (nội dung rỗng trên tất cả các dòng TD).
 * @param {string} tableId - ID của thẻ table (ví dụ: 'scoreTable').
 */
function hideEmptyGameColumns(tableId) {
    const table = document.getElementById(tableId);
    if (!table) {
        console.error(`Không tìm thấy bảng với ID: ${tableId}`);
        return;
    }

    const tbodyRows = table.querySelectorAll('tbody tr');
    const gameHeaderRow = table.querySelector('#gameHeaders');
    
    if (tbodyRows.length === 0 || !gameHeaderRow) {
        // Không có dữ liệu hoặc không có tiêu đề game để kiểm tra
        return;
    }

    // Lấy tất cả các thẻ TH đại diện cho từng ván đấu (Ván 1, Ván 2, ...)
    // Đây là các cột chúng ta cần kiểm tra xem có nên ẩn hay không.
    const gameHeaderCells = gameHeaderRow.querySelectorAll('th.game-score-col');
    
    // Chỉ số của cột TD trong TBODY. Cột đầu tiên (player-name-col) là chỉ số 0.
    // Cột game score đầu tiên (Ván 1) là chỉ số 1.
    let colIndexOffset = 1; 
    let visibleGameColumns = 0;

    // 1. Lặp qua từng tiêu đề cột Ván đấu
    gameHeaderCells.forEach((headerCell, i) => {
        // Chỉ số cột TD hiện tại đang được kiểm tra (tính từ 0)
        const currentColIndex = colIndexOffset + i; 
        let isColumnEmpty = true;

        // 2. Kiểm tra nội dung của cột đó trên TẤT CẢ các hàng dữ liệu (TD)
        for (let row of tbodyRows) {
            const cells = row.querySelectorAll('td');
            
            // Đảm bảo hàng có đủ ô (cell) để kiểm tra
            if (cells.length > currentColIndex) {
                const cellContent = cells[currentColIndex].textContent.trim();
                
                // Nếu tìm thấy bất kỳ nội dung nào, cột không còn trống
                // Chú ý: Cả '0u' hay '10m' đều là nội dung không trống.
                if (cellContent !== '') {
                    isColumnEmpty = false;
                    break; 
                }
            }
        }

        // 3. Nếu cột trống, thêm class để ẩn cột
        if (isColumnEmpty) {
            // Thêm class ẩn cột cho TH (tiêu đề)
            headerCell.classList.add('hidden-col');

            // Thêm class ẩn cột cho tất cả các TD tương ứng
            tbodyRows.forEach(row => {
                // Sử dụng :nth-child(currentColIndex + 1) vì CSS selector là 1-based, không phải 0-based
                const dataCell = row.querySelector(`td:nth-child(${currentColIndex + 1})`);
                if (dataCell) {
                    dataCell.classList.add('hidden-col');
                }
            });
            
            console.log(`Đã ẩn cột ván đấu: ${headerCell.textContent.trim()} vì không có dữ liệu.`);
        } else {
            // Cột có dữ liệu và sẽ được hiển thị
            visibleGameColumns++;
        }
    });
    
    // 4. Cập nhật thuộc tính colspan của TH 'Kết quả từng ván đấu'
    const gameHeaderSpan = document.getElementById('gameHeaderSpan');
    if (gameHeaderSpan) {
        // Số lượng cột hiển thị thực tế
        gameHeaderSpan.setAttribute('colspan', visibleGameColumns > 0 ? visibleGameColumns : 0);
        console.log(`Cập nhật colspan cho 'Kết quả từng ván đấu': ${visibleGameColumns} cột hiển thị.`);
    }
}

        
        
        
        
       function updatePageTitle(newTitle) {
            document.title = newTitle;           
        } 
        
        
        
        
        
        
        
    </script>
</body>
</html>