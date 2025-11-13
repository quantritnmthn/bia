<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tính Điểm Billiards</title>
<script src="js/jquery-3.7.1.min.js" ></script>
<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<link rel="manifest" href="webmanifest.json">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/ui-lightness/jquery-ui.css">
<?php 
$ban=1;
if ( isset( $_GET["b"] ) ) $ban=$_GET["b"];
	
?>		
<script src="js/jquery-ui.min.js"></script>
<style>
/* CSS */
body {
    font-family: Arial, sans-serif;
    padding: 10px; /* Giảm padding tổng thể */
    background-color: #fff;
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
.reset-btn {
    background-color: #ff4500;
}
.chiabai-btn {
    background-color: #870e63;
}
.get-result-btn {
    background-color: #2196F3;
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
    border: 1px solid #ddd;
    padding: 6px 4px;
    text-align: center;
    white-space: nowrap;
    min-width: 50px;
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
    right: 40px;
    z-index: 9;
    background-color: #ffecc6;
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
    
      
        
        /* Responsive: Dưới 768px (Thiết bị di động) */
        @media (max-width: 768px) {
body {
    padding: 5px;
}
.app-container {
    padding: 10px;
}
/* Điều khiển: Chuyển sang bố cục 2 cột cho các nút */
.controls {
    /* Giữ nguyên flex, nhưng cho phép xuống dòng */
    flex-direction: row; /* Thay đổi từ 'column' sang 'row' */
    flex-wrap: wrap; /* Cho phép các mục xuống dòng */
    gap: 10px;
    align-items: flex-start; /* Không kéo dài toàn bộ chiều rộng */
}
.action-button {
    /* Tính toán để có 2 nút trên 1 dòng */
                /* width: calc(50% - 5px); */ /* 50% trừ đi 1 nửa gap (10px/2) cho 2 nút liền kề */
    width: 48%; /* Hoặc dùng giá trị nhỏ hơn 50% để đảm bảo đủ chỗ cho gap */
    padding: 10px; /* Giảm nhẹ padding để tối ưu không gian */
    font-size: 14px; /* Giảm nhẹ font size */
}
.full-width-btn {
    width: 98%;
}
.control-group {
    width: 100%;
    justify-content: space-between; /* Đẩy input sang phải */    
    font-size: 16px;
}
.control-group input {
    width: 120px; /* Tăng kích thước input */
    padding: 4px;
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
.deskcard {
    width: 10%;
    margin: 3px
}
/* Style mới cho viền đỏ khi không có ù */
.no-u-border {
    border: 1px solid red !important;
}
.deskcard {
    width: 10%;
    margin: 3px
}

/* Tùy chỉnh mới cho control group chứa checkboxes */
.full-width-group {
    width: 100%; /* Đảm bảo nhóm này chiếm đủ chiều rộng */
    
}
#playerCheckboxes label {
    font-weight: normal; /* Tên người chơi không cần in đậm */
    white-space: nowrap;
}
/* Căn chỉnh label nếu không muốn nó chiếm hết 1 dòng */
.full-width-group label:first-child {
    margin-bottom: 5px;
    font-weight: bold;
}

</style>
</head>
<body>
<audio id="dynamicAudioPlayer"></audio>
<audio id="playlistAudioPlayer"></audio>
<div class="app-container" id="appContainer">
  <div class="controls">
    <button class="action-button " id="TongKetTranDau" style="background-color: #df08e5;"  >Tổng kết trận đấu</button>
    <button class="action-button " id="BocLuotChoi" style="background-color: #14639b;"  >Chia bài bốc lượt chơi</button>
    <button class="action-button add-player-btn" id="addPlayerButton">Thêm Người Chơi</button>
    <button class="action-button add-game-btn" id="addGameButton">Thêm Ván</button>
    <button class="action-button reset-btn" id="resetButton">Reset Dữ liệu</button>
    <button class="action-button" id="loadFromServerButton" style="background-color: #d1011e;">Lấy dữ liệu từ Server</button>
    <button class="action-button get-result-btn" id="getResultButton">Lấy kết quả ván đấu</button>
    <button class="action-button chiabai-btn " id="ChiaBaibtn">Chia bài</button>
    
    <div class="control-group">
      <label for="banInput">Chọn bàn chơi:</label>
      <select id="banInput" style="padding: 5px; border: 1px solid #ccc; width: 80px; text-align: right;">
        <option value="1">Bàn 1</option>
        <option value="2">Bàn 2</option>
        <option value="3">Bàn 3</option>
        <option value="4">Bàn 4</option>
        <option value="5">Bàn 5</option>
      </select>
    </div>
    <div class="control-group">
      <label for="moneyInput">Tiền bàn (đ):</label>
      <input type="number" id="moneyInput" style="width: 70px; text-align: right;" value="0" min="0">
    </div>
<div class="control-group">
      <label for="splitCountInput">Số người chia tiền:</label>
      <select id="splitCountInput" style="padding: 5px; border: 1px solid #ccc; width: 80px; text-align: right;">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </div>
    <div class="control-group">
      <label for="SoCayMoiNguoi">Số cây chia mỗi người:</label>
      <select id="SoCayMoiNguoi" style="padding: 5px; border: 1px solid #ccc; width: 80px; text-align: right;">
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10" >10</option> <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
      </select>
    </div>
 <div class="control-group full-width-group" style="flex-grow: 1;">
      <label>Chia bài cho:</label>
      <div id="playerCheckboxes" style="gap: 10px; margin-left: 10px;">
        </div>
      <input type="hidden" id="ChiaBaiCho" value="">
    </div>
  </div>
  <div class="table-container" id="tableContainer">
    <table id="scoreTable">
      <thead>
        <tr>
          <th class="player-name-col" rowspan="2">Người chơi</th>
          <th id="gameHeaderSpan" colspan="30">Kết quả từng ván đấu</th>
          <th class="result-col total-cays" rowspan="2">Tổng số cây</th>
          <th class="result-col total-moms" rowspan="2">Số ván móm</th>
          <th class="result-col total-us" rowspan="2">Số ván ù</th>
          <th class="result-col total-scars" rowspan="2">Số ván sẹo</th>
          <th class="delete-player-col" rowspan="2">Xóa</th>
        </tr>
        <tr id="gameHeaders"> </tr>
      </thead>
      <tbody id="scoreBody">
      </tbody>
    </table>
    	
  </div>
  	  <b style="color:red; text-align:center;">- Lấy kết quả ván đấu trước khi Chia bài cho ván mới.<br>- Bốc lượt chơi > Reset dữ liệu > Thêm người chơi > Chia bài trước khi chơi ván đầu tiên.</b>
</div>

<div id="addPlayerDialog" title="Chọn Người Chơi">
  <p>Chọn người chơi để thêm:</p>
  <select id="playerSelect" style="width: 100%; padding: 5px;">
    </select>
</div>

<div id="resetDialog" title="Xác nhận Reset">
  <p>Bạn có chắc chắn muốn XÓA TẤT CẢ dữ liệu đã nhập và bắt đầu lại từ đầu không? Hành động này không thể hoàn tác.</p>
</div>

<div id="deleteDialog" title="Xác nhận Xóa">
  <p>Xóa người chơi này?</p>
</div>

<div id="chiaBaiDialog" title="Xác nhận Chia Bài">
  <p>Bạn muốn chia bài cho ván mới hay không?</p>
</div>

<div id="getResultDialog" title="Xác nhận Lấy Kết Quả">
  <p>Bạn có muốn lấy kết quả ván đấu vừa diễn ra không? Lưu ý trường hợp bị SẸO cần nhập lại kết quả bằng tay, vd: 12s</p>
</div>
<div id="loadFromServerDialog" title="Xác nhận Tải Dữ Liệu">
  <p>Bạn có chắc chắn muốn tải và ghi đè dữ liệu hiện tại bằng dữ liệu mới nhất từ Server không?</p>
</div>
<script>
        // JavaScript
        const MAX_PLAYERS = 10;
        let gameCount = 30;
        let defaultPlayerNames = ["Dương","Hoàng","Ninh"];
        
        if (getBanValue()!='1') {defaultPlayerNames = [];  }

        // Key cố định cho LocalStorage
        const localStorageKey = 'billiards_score_data_'+getBanValue();

        // Biến lưu trữ thời gian bắt đầu/kết thúc ván (UTC string)
        let gameTimestamps = {}; 
        
        // Biến toàn cục lưu trữ Rank Counts
        let rankCountsByPlayer = {}; 

        // Biến toàn cục cho danh sách users từ DB
        let allUsers = [];

        // Biến để lưu row cần xóa
        let currentDeleteBtn = null;
        
        // --- HÀM LẤY GIÁ TRỊ BÀN CHƠI HIỆN TẠI ---
        function getBanValue() {
        	$('#banInput').val(getParam('b') || '1');
            return getParam('b') || '1';
        }
        
        function getParam(param){
            return new URLSearchParams(window.location.search).get(param);
		}
     
        // Hàm lấy class CSS dựa trên giá trị score
        function getScoreClass(val) {
            if (!val) return '';
            const lowerVal = val.toLowerCase();
            if (lowerVal.endsWith('u') || lowerVal.includes('u')) {
                return lowerVal.includes('0u') ? 'score-0u' : 'score-u';
            }
            if (lowerVal.endsWith('m')) return 'score-m';
            if (lowerVal.endsWith('s')) return 'score-s';
            return '';
        }

        // Hàm kiểm tra cột ván có hoàn thành không (tất cả cells không rỗng)
        function isColumnComplete(col) {
            const rows = Array.from(document.getElementById('scoreBody').children);
            return rows.every(row => {
                const cell = row.cells[col];
                return cell && cell.textContent.trim() !== '';
            });
        }


        // Gắn sự kiện cho nút bấm Bốc Lượt Chơi
        const bocLuotChoiButton = document.getElementById('BocLuotChoi'); 
        bocLuotChoiButton.addEventListener('click', () => {
            // Mở file thutu.php trong một tab mới (_blank)
            window.open('thutu.php', '_blank');
        });
        
          // Gắn sự kiện cho nút bấm Bốc Lượt Chơi
        const TongKetTranDauButton = document.getElementById('TongKetTranDau'); 
        TongKetTranDauButton.addEventListener('click', () => {
            postDataToServer(); 
            window.open('tongket.php?b='+getBanValue(), '_blank');
        });
        
        
        // Hàm kiểm tra cột ván có input không rỗng
        function hasInputInColumn(col) {
            const rows = Array.from(document.getElementById('scoreBody').children);
            return rows.some(row => {
                const cell = row.cells[col];
                return cell && cell.textContent.trim() !== '';
            });
        }

        // Hàm tìm cột ván gần nhất chưa có dữ liệu (cột đầu tiên mà không có input nào)
        function findNextEmptyColumn() {
            for (let col = 1; col <= gameCount; col++) {
                if (!hasInputInColumn(col)) {
                    return col;
                }
            }
            return null; // Không tìm thấy cột trống
        }

        // Hàm cập nhật timestamps cho tất cả cột nếu cần
        function updateTimestamps() {
            let needsSave = false;
            for (let col = 1; col <= gameCount; col++) {
                const gameKey = `game_${col}`;
                if (hasInputInColumn(col)) {
                    if (!gameTimestamps[gameKey]) {
                        let startTime = new Date().toISOString();
                        if (col > 1) {
                            const prevKey = `game_${col - 1}`;
                            if (gameTimestamps[prevKey] && gameTimestamps[prevKey].end) {
                                startTime = gameTimestamps[prevKey].end;
                            }
                        }
                        gameTimestamps[gameKey] = {start: startTime, end: null};
                        needsSave = true;
                    }
                    if (gameTimestamps[gameKey].end === null && isColumnComplete(col)) {
                        gameTimestamps[gameKey].end = new Date().toISOString();
                        needsSave = true;
                    }
                }
            }
            // Chỉ cần gọi saveData() (LocalStorage) vì updateTimestamps được gọi khi có input
            if (needsSave) {
                saveData(); 
            }
        }

        // Hàm copy scores từ max của các ván hiện có
        function getCopiedScores() {
            const copied = [];
            const rows = Array.from(document.getElementById('scoreBody').children);
            let stop = false;
            for (let col = 1; col <= gameCount && !stop; col++) {
                let maxNum = -1;
                let maxVal = '';
                rows.forEach(row => {
                    const cell = row.cells[col];
                    if (cell) {
                        let val = cell.textContent.trim();
                        if (val) {
                            let numStr = val.replace(/[mus]/g, '');
                            let num = parseInt(numStr) || 0;
                            let suffix = '';
                            if (val.toLowerCase().endsWith('m')) suffix = 'm';
                            else if (val.toLowerCase().endsWith('s')) suffix = 's';
                            // Không copy 'u', chỉ số
                            if (num > maxNum) {
                                maxNum = num;
                                maxVal = num + (suffix ? suffix : '');
                            }
                        }
                    }
                });
                if (maxNum === -1) {
                    stop = true;
                } else {
                    copied.push(maxVal);
                }
            }
            // Pad với empty strings đến gameCount
            while (copied.length < gameCount) {
                copied.push('');
            }
            return copied;
        }

        // Function to delete a row
        function deleteRow(btn) {
            currentDeleteBtn = btn;
            $('#deleteDialog').dialog('open');
        }

        // Hàm thêm người chơi mới vào bảng
        function addPlayerRow(name, scores) {
            const scoreBody = document.getElementById('scoreBody');
            const row = scoreBody.insertRow(-1);

            // Tên người chơi
            const nameCell = row.insertCell(0);
            nameCell.textContent = name;
            nameCell.classList.add('player-name-col');

            // Các ô ván đấu
            // Đảm bảo scores có đủ độ dài
            const finalScores = scores.length > gameCount ? scores.slice(0, gameCount) : scores.concat(Array(gameCount - scores.length).fill(''));

            for (let i = 0; i < gameCount; i++) {
                const cell = row.insertCell(-1);
                cell.classList.add('game-score-col');
                cell.contentEditable = true;
                
                if (finalScores[i]) {
                    cell.textContent = finalScores[i];
                    const initialClass = getScoreClass(finalScores[i]);
                    if (initialClass) {
                        cell.classList.add(initialClass);
                    }
                }
                
                // Thêm event listener cho input
                cell.addEventListener('input', function() {
                    // Xóa class cũ
                    this.className = this.className.replace(/score-[a-z0-9]+/g, '');
                    // Thêm class mới
                    const newClass = getScoreClass(this.textContent);
                    if (newClass) {
                        this.classList.add(newClass);
                    }
                    fullRecalculate();
                    saveData(); 
                    checkColumnsForU();
                    updateTimestamps();
                });
            }

            // Các ô tổng kết
            const totalCay = row.insertCell(-1);
            totalCay.classList.add('total-cays', 'result-col');

            const totalMoms = row.insertCell(-1);
            totalMoms.classList.add('total-moms', 'result-col');

            const totalUs = row.insertCell(-1);
            totalUs.classList.add('total-us', 'result-col');

            const totalScars = row.insertCell(-1);
            totalScars.classList.add('total-scars', 'result-col');

            // Nút xóa
            const deleteCell = row.insertCell(-1);
            deleteCell.innerHTML = '<button class="action-button" style="background-color: #ff0000; padding: 2px 5px; font-size: 12px;" onclick="deleteRow(this)">Xóa</button>';
            deleteCell.classList.add('delete-player-col');
        }

        // Hàm tính điểm cho một hàng
        function calculateRowScores(row) {
            let totalCay = 0;
            let momCount = 0;
            let uCount = 0;
            let scarCount = 0;

            for (let i = 1; i <= gameCount; i++) {
                const cell = row.cells[i];
                if (cell) {
                    let val = cell.textContent.trim();
                    if (val) {
                        let num = parseInt(val.replace(/[mus]/g, '')) || 0;
                        totalCay += num;

                        const lowerVal = val.toLowerCase();
                        if (lowerVal.endsWith('m')) momCount++;
                        if (lowerVal.endsWith('u')) uCount++;
                        if (lowerVal.endsWith('s')) scarCount++;
                    }
                }
            }

            // Kiểm tra chỉ số trước khi gán
            if (row.cells[gameCount + 1]) row.cells[gameCount + 1].textContent = totalCay;
            if (row.cells[gameCount + 2]) row.cells[gameCount + 2].textContent = momCount;
            if (row.cells[gameCount + 3]) row.cells[gameCount + 3].textContent = uCount;
            if (row.cells[gameCount + 4]) row.cells[gameCount + 4].textContent = scarCount;
        }

        // =========================================================
        // *** HÀM LƯU VÀO LOCALSTORAGE ***
        // =========================================================
        function saveData() {
            console.log("-> saveData() called: Preparing to save to LocalStorage..."); 
            var players = [];
            var maxGames = 0;

            const scoreBody = document.getElementById('scoreBody');
            
            Array.from(scoreBody.children).forEach(function(row) {
                var $row = $(row);
                var name = $row.find('td').eq(0).text().trim(); 
                
                if (!name) return; 
                
                var scores = [];
                
                for (let i = 1; i <= gameCount; i++) {
                     const cell = $row.find('td').eq(i);
                     scores.push(cell ? cell.text().trim() : '');
                }
                
                players.push({ name: name, scores: scores });
                
                maxGames = gameCount; 
            });

            // Lấy các settings khác
            const money = document.getElementById('moneyInput').value;
            const splitCount = document.getElementById('splitCountInput').value;
            const gameName = document.getElementById('ChiaBaiCho').value; 
            const soCayMoiNguoi = document.getElementById('SoCayMoiNguoi').value; 
            // THÊM: Lấy giá trị bàn chơi
            const ban = getBanValue();


            var data = { 
                players: players, 
                maxGames: maxGames,
                gameName: gameName,
                settings: {
                    money: money,
                    splitCount: splitCount,
                    gameCount: gameCount,
                    gameTimestamps: gameTimestamps,
                    rankCountsByPlayer: rankCountsByPlayer,
                    soCayMoiNguoi: soCayMoiNguoi,
                    // THÊM: Lưu giá trị bàn chơi
                    ban: ban 
                },
                timestamp: new Date().toISOString() 
            };

            var dataJson = JSON.stringify(data);
            
            try {
                // 1. LƯU VÀO LOCALSTORAGE
                localStorage.setItem(localStorageKey, dataJson);
            
                // 2. KÍỂM TRA NGAY SAU KHI LƯU
                const savedCheck = localStorage.getItem(localStorageKey);
                if (savedCheck && savedCheck.length > 50) { 
                    $('#saveStatus').text('Dữ liệu đã được lưu tạm thời trên máy tính (Local).'); 
                    console.log("-> LocalStorage saved successfully. Length:", savedCheck.length);
                } else {
                    $('#saveStatus').text('❌ Lỗi: Không thể lưu LocalStorage. (Kiểm tra Browser Console)'); 
                    console.error("-> LocalStorage FAILED to save or saved empty content. Check browser settings (e.g., Incognito mode).");
                }
            } catch (e) {
                 $('#saveStatus').text('❌ Lỗi: Không thể lưu LocalStorage. (Kiểm tra Browser Console)'); 
                 console.error("-> LocalStorage failed to set item:", e);
            }
        }

        // =========================================================
        // *** HÀM POST DỮ LIỆU LÊN SERVER (Đã sửa để trả về Promise) ***
        // =========================================================
        function postDataToServer() {
            // Đảm bảo dữ liệu mới nhất đã được lưu vào LocalStorage trước khi POST
            saveData();
            
            const dataJson = localStorage.getItem(localStorageKey);
            
            if (!dataJson) {
                 $('#saveStatus').text('Không có dữ liệu để lưu lên Server.');
                 // Trả về một Promise đã bị fail nếu không có dữ liệu để POST
                 return $.Deferred().reject().promise(); 
            }

            $('#saveStatus').text('Đang lưu lên Server...');

            return $.ajax({ // <<< SỬA: Thêm 'return' để trả về Promise
                type: 'POST',
                url: 'save.php',
                // CẬP NHẬT: Thêm tham số b
                data: { 
                    data: dataJson,
                    b: getBanValue()
                },
                dataType: 'json', 
                timeout: 30000, 
                success: function(response) {
                    if (response.status === 'success') {
                        $('#saveStatus').text('✅ Đã lưu dữ liệu thành công lên Server.');
                    } else {
                        $('#saveStatus').text('❌ Lỗi Server: ' + response.message);
                        alert('Lỗi khi lưu dữ liệu lên server:\n' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $('#saveStatus').text('❌ Lỗi Kết nối/Mạng khi lưu Server: ' + status + ' (' + error + ')');
                    alert('Lỗi kết nối hoặc timeout khi lưu dữ liệu lên server. Vui lòng kiểm tra cấu hình FastCGI/IIS.');
                }
            });
        }        
        // =========================================================
        // *** HÀM TẢI DỮ LIỆU (Đã thêm tham số b) ***
        // =========================================================
        function loadData(callback) {
            console.log("-> loadData() called: Checking LocalStorage...");
            const savedDataJson = localStorage.getItem(localStorageKey);
            let savedData = null;
            let loadedFromLocalStorage = false;

            if (savedDataJson) {
                try {
                    savedData = JSON.parse(savedDataJson);
                    // KIỂM TRA: Đảm bảo data là hợp lệ (có players hoặc settings)
                    if (savedData && (savedData.players || savedData.settings)) { 
                        loadedFromLocalStorage = true;
                        $('#saveStatus').text('Dữ liệu được tải từ bộ nhớ tạm (Local).');
                        console.log("-> LocalStorage FOUND and loaded successfully.");
                        callback(savedData);
                        return; // Dừng nếu tải thành công từ LocalStorage
                    }
                } catch (e) {
                    console.error("-> Lỗi khi parse dữ liệu từ LocalStorage:", e);
                    localStorage.removeItem(localStorageKey); // Xóa dữ liệu lỗi
                }
            }
            
            // CHỈ KHI LocalStorage THẬT SỰ TRỐNG/LỖI MỚI THỬ TẢI TỪ SERVER
            console.log("-> LocalStorage empty/failed. Trying to load from server...");
            // CẬP NHẬT: Thêm tham số b
            $.getJSON('load.php?b=<?php echo($ban);?>', { b: getBanValue() }, function(data) {
                
                // KIỂM TRA: Dữ liệu từ server có hợp lệ không
                if (data && data.players && data.players.length > 0) {
                     // Dữ liệu Server hợp lệ
                     const settings = data.settings || {money: 0, splitCount: 2, gameCount: gameCount, gameTimestamps: gameTimestamps, rankCountsByPlayer: rankCountsByPlayer, soCayMoiNguoi: 10, ban: 1};
                     const maxGames = settings.gameCount || gameCount;
                     const gameName = data.gameName || '';

                     const localData = {
                         players: data.players,
                         maxGames: maxGames, 
                         gameName: gameName,
                         settings: settings,
                         timestamp: new Date().toISOString()
                     };
                     
                     // Ghi dữ liệu từ Server vào LocalStorage để dùng cho lần sau
                     localStorage.setItem(localStorageKey, JSON.stringify(localData));
                     
                     $('#saveStatus').text('Dữ liệu được tải từ Server.');
                     console.log("-> Server data loaded successfully. Saved to LocalStorage.");
                     callback(localData);
                } else {
                     // Server trả về rỗng hoặc không hợp lệ -> Dùng mặc định
                     $('#saveStatus').text('Bảng điểm trống. Khởi tạo mặc định.');
                     console.log("-> Server data empty/invalid. Using default data.");
                     callback(null); 
                }
            }).fail(function() {
                // Lỗi kết nối Server -> Dùng mặc định
                $('#saveStatus').text('❌ Lỗi: Không thể tải dữ liệu từ Server (load.php). Dùng mặc định.');
                console.error("-> Failed to connect/load from load.php. Using default data.");
                callback(null);
            });
        }
        
        // =========================================================
        // *** HÀM RENDER TABLE (Đã thêm banInput) ***
        // =========================================================
        function renderTable(data) {
             const scoreBody = document.getElementById('scoreBody');
             scoreBody.innerHTML = ''; 

             if (data && data.settings) {
                 gameCount = data.settings.gameCount || 30;
                 document.getElementById('moneyInput').value = data.settings.money || 0;
                 document.getElementById('splitCountInput').value = data.settings.splitCount || 2;
                 // CẬP NHẬT: Tải giá trị bàn chơi (mặc định là 1)
                 document.getElementById('banInput').value = getBanValue(); 
                 gameTimestamps = data.settings.gameTimestamps || {};
                 rankCountsByPlayer = data.settings.rankCountsByPlayer || {};
                 document.getElementById('SoCayMoiNguoi').value = data.settings.soCayMoiNguoi || 10;
             } else {
                 gameCount = 30;
                 document.getElementById('SoCayMoiNguoi').value = 10; 
                 // CẬP NHẬT: Đặt mặc định bàn chơi
                 document.getElementById('banInput').value = getBanValue();
             }
             // Tải giá trị đã lưu vào ChiaBaiCho
             document.getElementById('ChiaBaiCho').value = data.gameName || '';


             initializeTable(); 

             if (data && data.players && data.players.length > 0) {
                 data.players.forEach(p => {
                     addPlayerRow(p.name, Array.isArray(p.scores) ? p.scores : []);
                 });
             }
        }


        // Hàm khởi tạo bảng (Giữ nguyên)
        function initializeTable() {
            const gameHeaders = document.getElementById('gameHeaders');
            const gameHeaderSpan = document.getElementById('gameHeaderSpan');

            gameHeaders.innerHTML = '';
            for (let i = 1; i <= gameCount; i++) {
                const th = document.createElement('th');
                th.textContent = `Ván ${i}`;
                th.classList.add('game-score-col');
                gameHeaders.appendChild(th);
            }
            gameHeaderSpan.setAttribute('colspan', gameCount);

            const scoreBody = document.getElementById('scoreBody');
            Array.from(scoreBody.children).forEach(row => {
                while (row.cells.length < gameCount + 6) {
                    const cell = row.insertCell(-1);
                    const colIndex = row.cells.length - 1;
                    if (colIndex <= gameCount) {
                        cell.classList.add('game-score-col');
                        cell.contentEditable = true;
                        const cellClass = getScoreClass(cell.textContent);
                        if (cellClass) {
                            cell.classList.add(cellClass);
                        }
                        cell.addEventListener('input', function() {
                            this.className = this.className.replace(/score-[a-z0-9]+/g, '');
                            const newClass = getScoreClass(this.textContent);
                            if (newClass) {
                                this.classList.add(newClass);
                            }
                            fullRecalculate();
                            saveData(); 
                            checkColumnsForU();
                            updateTimestamps();
                        });
                    } else if (colIndex === gameCount + 1) {
                        cell.classList.add('total-cays', 'result-col');
                    } else if (colIndex === gameCount + 2) {
                        cell.classList.add('total-moms', 'result-col');
                    } else if (colIndex === gameCount + 3) {
                        cell.classList.add('total-us', 'result-col');
                    } else if (colIndex === gameCount + 4) {
                        cell.classList.add('total-scars', 'result-col');
                    } else if (colIndex === gameCount + 5) {
                        cell.classList.add('delete-player-col');
                        if (!cell.innerHTML) {
                            cell.innerHTML = '<button class="action-button" style="background-color: #ff0000; padding: 2px 5px; font-size: 12px;" onclick="deleteRow(this)">Xóa</button>';
                        }
                    }
                }
            });
        }

        // Hàm init timestamps cho game 1 nếu thiếu (Giữ nguyên)
        function initializeTimestamps() {
            if (Object.keys(gameTimestamps).length === 0) {
                gameTimestamps['game_1'] = {
                    start: new Date().toISOString(),
                    end: null
                };
            }
        }

        // 9. Hàm tính toán và vẽ lại toàn bộ (Giữ nguyên)
        function fullRecalculate() {
            const scoreBody = document.getElementById('scoreBody');
            Array.from(scoreBody.children).forEach(calculateRowScores);
            checkColumnsForU();
        }
            
        
        document.addEventListener('DOMContentLoaded', () => {
            const scoreBody = document.getElementById('scoreBody');
            

            const moneyInput = document.getElementById('moneyInput');
            const splitCountInput = document.getElementById('splitCountInput');
            const addGameButton = document.getElementById('addGameButton'); 
            const addPlayerButton = document.getElementById('addPlayerButton');
            const resetButton = document.getElementById('resetButton'); 
            const chiabaiBtn = document.getElementById('ChiaBaibtn');
            const getResultButton = document.getElementById('getResultButton');
            const chiaBaiChoInput = document.getElementById('ChiaBaiCho');
            const soCayMoiNguoiInput = document.getElementById('SoCayMoiNguoi');
            // THÊM BIẾN CHO BÀN CHƠI
            const banInput = getBanValue();
            // THÊM BIẾN NÚT MỚI
            const loadFromServerButton = document.getElementById('loadFromServerButton');
            // =========================================================
            // *** Event Listeners cho các trường cài đặt ***
            // =========================================================
            moneyInput.addEventListener('input', () => {
                saveData();
            });

            splitCountInput.addEventListener('input', () => {
                saveData();
            });
            
            // THÊM: Lưu khi có thay đổi bàn chơi
           // banInput.addEventListener('input', () => {
           //     saveData();
           // });

            // LƯU KHI CÓ THAY ĐỔI
            chiaBaiChoInput.addEventListener('input', () => {
                saveData();
            });

            // LƯU KHI CÓ THAY ĐỔI
            soCayMoiNguoiInput.addEventListener('input', () => {
                saveData();
            });

             // Khởi tạo jQuery UI Dialogs (Giữ nguyên)
             $(function() {
                // Add Player Dialog (Giữ nguyên)
                $('#addPlayerDialog').dialog({
                    autoOpen: false, modal: true, width: 400,
                    buttons: {
                        "Cancel": function() { $(this).dialog('close'); },                    	
                        "OK": function() {
                            const selectedName = $('#playerSelect').val();
                            if (selectedName) {
                                const copiedScores = getCopiedScores();
                                addPlayerRow(selectedName, copiedScores);
                                
                                // BƯỚC MỚI: Tự động thêm tên người chơi mới vào input ẩn "ChiaBaiCho"
                                const chiaBaiChoInput = document.getElementById('ChiaBaiCho');
                                let currentSelected = chiaBaiChoInput.value.split(',').map(p => p.trim()).filter(p => p);
                                if (!currentSelected.includes(selectedName)) {
                                    currentSelected.push(selectedName);
                                    chiaBaiChoInput.value = currentSelected.join(',');
                                }
                                
                                fullRecalculate(); saveData(); updateChiaBaiCho(); updateTimestamps();
                            }
                            $(this).dialog('close');
                        }
                    }
                });

                // Reset Dialog (Đã thêm tham số b)
                $('#resetDialog').dialog({
                    autoOpen: false, modal: true, width: 400,
                    buttons: {
                        "Hủy": function() { $(this).dialog('close'); },	
                        "Xóa": function() {
                            $(this).dialog('close');
                            
                            $.ajax({
                                url: 'reset.php', 
                                type: 'POST',
                                // CẬP NHẬT: Thêm tham số b
                                data: { b: getBanValue() },
                                success: function() {
                                    scoreBody.innerHTML = ''; moneyInput.value = 0; splitCountInput.value = 2; gameCount = 30; 
                                    localStorage.removeItem(localStorageKey);                                    
                                    gameTimestamps = { 'game_1': { start: new Date().toISOString(), end: null } };
                                    rankCountsByPlayer = {};
                                    // Đặt lại mặc định
                                    document.getElementById('SoCayMoiNguoi').value = 10;
                                    document.getElementById('banInput').value = getBanValue(); // THÊM: Đặt lại mặc định bàn chơi
                                    initializeTable(); initializeTimestamps(); fullRecalculate();
                                    
                                    // Thêm người chơi mặc định
                                    if (getBanValue()=='1') {
                                    defaultPlayerNames.forEach(name => {
                                         addPlayerRow(name, []);
                                    });
                                    }
                                    updateChiaBaiCho(); // Cập nhật tên mặc định sau khi Reset
                                    saveData();
                                }
                            });
                            
                            postDataToServer(); 
                        }
                    }
                });

                // Delete Dialog (Giữ nguyên)
                $('#deleteDialog').dialog({
                    autoOpen: false, modal: true, width: 300,
                    buttons: {
                        "Hủy": function() { $(this).dialog('close'); },                    	
                        "Xóa": function() {
                            $(this).dialog('close');
                            if (currentDeleteBtn) {
                                currentDeleteBtn.closest('tr').remove();
                                fullRecalculate(); saveData(); updateChiaBaiCho(); updateTimestamps();
                            }
                        }
                    }
                });
                
                
                
                
// ... (phần trên không đổi)
                // Chia Bai Dialog (Đã thêm tham số b)
                $('#chiaBaiDialog').dialog({
                    autoOpen: false, modal: true, width: 300,
                    buttons: {
                    	 "Không": function() { $(this).dialog('close'); },
                        "Có": function() {
                            $(this).dialog('close');
                            
                            // Lấy dữ liệu cần thiết trước khi gọi AJAX
                            const playersInput = document.getElementById('ChiaBaiCho').value.trim();
                            if (!playersInput) { alert("Chưa có người chơi nào trong ô Chia bài cho!"); return; }
                            const players = playersInput.split(',').map(p => p.trim()).filter(p => p);
                            if (players.length === 0) { alert("Chưa có người chơi nào!"); return; }
                            const soCay = parseInt(document.getElementById('SoCayMoiNguoi').value) || 10;
                            
                            // GỌI postDataToServer VÀ CHỜ NÓ HOÀN TẤT
                            postDataToServer()
                                .done(function(response, textStatus, jqXHR) {
                                    // Kiểm tra thêm một lần nữa phản hồi logic của save.php (nếu cần)
                                    if (response && response.status !== 'success') {
                                        console.error("Lưu điểm thành công về mặt kết nối nhưng server báo lỗi logic.");
                                        return;
                                    }
                                    
                                    // CHỈ GỌI chiabai.php SAU KHI postDataToServer() THÀNH CÔNG
                                    $.ajax({
                                        url: 'chiabai.php', 
                                        type: 'POST',
                                        // CẬP NHẬT: Thêm tham số b
                                        data: { 
                                            players: JSON.stringify(players), 
                                            soCay: soCay,
                                            b: getBanValue() 
                                        },
                                        success: function(response) {
                                            let data;
                                            try { 
                                                data = JSON.parse(response); 
                                                playMp3('voice/chiaxong.mp3'); 
                                            } catch (e) { 
                                                alert("Lỗi xử lý dữ liệu từ chiabai.php: " + response); 
                                                return; 
                                            }
                                            if (data.error) { alert(data.error); return; }
                                            console.log("✅ chiabai1.php đã chạy thành công.");
                                        },
                                        error: function() { 
                                            alert("Lỗi kết nối khi chia bài"); 
                                        }
                                    });
                                })
                                .fail(function(xhr, status, error) {
                                    // Xử lý lỗi nếu postDataToServer thất bại hoàn toàn (timeout/mạng/không có data)
                                    console.error("Lưu điểm thất bại, không gọi chiabai1.php.");
                                    alert("Lỗi khi lưu điểm! Không thể tạo ván mới.");
                                });
                        }
                    }
                });

// ... (phần còn lại không đổi)
                // Get Result Dialog (Đã thêm tham số b)
                $('#getResultDialog').dialog({
                    autoOpen: false, modal: true, width: 400,
                    buttons: {
                    	"Hủy": function() { $(this).dialog('close'); },
                        "Lấy": function() {
                            $(this).dialog('close');
                            const targetCol = findNextEmptyColumn();
                            if (!targetCol) { alert("Tất cả các ván đã có dữ liệu!"); return; }
                            // CẬP NHẬT: Thêm tham số b
                            $.getJSON('get_results.php?b=<?php echo($ban);?>', { b: getBanValue() }, function(results) { 
                                if (results.error) { alert("Lỗi lấy kết quả: " + results.error); return; }
                                const rows = Array.from(scoreBody.children);
                                let filledCount = 0;
                                rows.forEach(row => {
                                    const name = row.cells[0].textContent.trim();
                                    if (name && results[name] && row.cells[targetCol].textContent.trim() === '') {
                                        const cell = row.cells[targetCol];
                                        cell.textContent = results[name];
                                        const scoreClass = getScoreClass(results[name]);
                                        if (scoreClass) { cell.classList.add(scoreClass); }
                                        filledCount++;
                                    }
                                });
                                if (filledCount > 0) {
                                    fullRecalculate(); saveData(); checkColumnsForU(); updateTimestamps();
                                } else {
                                    alert("Không có dữ liệu kết quả ván đấu.");
                                }
                            }).fail(function() {
                                alert("Lỗi kết nối khi lấy kết quả. Vui lòng kiểm tra get_results.php.");
                            });
                        }
                    }
                });
            });



// THÊM: Load From Server Dialog
                $('#loadFromServerDialog').dialog({
                    autoOpen: false, modal: true, width: 400,
                    buttons: {
                    	"Hủy": function() { $(this).dialog('close'); },
                        "Tải về": function() {
                            $(this).dialog('close');
                            // Gọi hàm tải dữ liệu chính
                            loadDataFromServerOnly();
                        }
                    }
                });
            

$(document).ready(function() {
  $('#banInput').change(function() {
    var selectedValue = $(this).val(); // Get the value of the selected option
    window.location='nhap.php?b='+selectedValue;
    
  });
});


            // 1. Hàm thêm cột Ván (Giữ nguyên)
            function addGameColumn(gameIndex) {
                const gameHeaders = document.getElementById('gameHeaders');
                const gameHeaderSpan = document.getElementById('gameHeaderSpan');
                
                const th = document.createElement('th');
                th.textContent = `Ván ${gameIndex}`;
                th.classList.add('game-score-col');
                gameHeaders.appendChild(th);
                
                gameHeaderSpan.setAttribute('colspan', gameIndex);
                
                Array.from(scoreBody.children).forEach(row => {
                    const gameCell = row.insertCell(gameIndex); 
                    gameCell.classList.add('game-score-col');
                    gameCell.contentEditable = true;
                    gameCell.textContent = ''; 
                    
                    const cells = Array.from(row.cells);
                    if (cells[gameIndex + 1]) cells[gameIndex + 1].classList.add('total-cays');
                    if (cells[gameIndex + 2]) cells[gameIndex + 2].classList.add('total-moms');
                    if (cells[gameIndex + 3]) cells[gameIndex + 3].classList.add('total-us');
                    if (cells[gameIndex + 4]) cells[gameIndex + 4].classList.add('total-scars');
                    if (cells[gameIndex + 5]) cells[gameIndex + 5].classList.add('delete-player-col');

                    gameCell.addEventListener('input', function() {
                        this.className = this.className.replace(/score-[a-z0-9]+/g, '');
                        const newClass = getScoreClass(this.textContent);
                        if (newClass) { this.classList.add(newClass); }
                        fullRecalculate(); saveData(); checkColumnsForU(); updateTimestamps();
                    });
                });
                saveData(); 
            }

            // 12. CHỨC NĂNG RESET DỮ LIỆU (Giữ nguyên)
            resetButton.addEventListener('click', () => {
                $('#resetDialog').dialog('open');
            });
            
           // GẮN SỰ KIỆN CHO NÚT LẤY DỮ LIỆU TỪ SERVER (MỞ DIALOG)
            loadFromServerButton.addEventListener('click', () => {
                $('#loadFromServerDialog').dialog('open'); // Mở hộp xác nhận
            });

            // Get Result Button (Giữ nguyên)
            getResultButton.addEventListener('click', () => {
                $('#getResultDialog').dialog('open');
            });

            // Add Player Button (Đã thêm tham số b)
            addPlayerButton.addEventListener('click', () => {
                if (allUsers.length === 0) {
                    loadUsers(() => { openAddPlayerDialog(); });
                    return;
                }
                openAddPlayerDialog();
            });

            function openAddPlayerDialog() {
                const currentPlayers = Array.from(scoreBody.children).map(row => row.cells[0].textContent.trim()).filter(name => name);
                const available = allUsers.filter(u => !currentPlayers.includes(u));
                if (available.length === 0) {
                    alert('Không còn người chơi nào để thêm.');
                    return;
                }
                $('#playerSelect').empty();
                available.forEach(u => {
                    $('#playerSelect').append(`<option value="${u}">${u}</option>`);
                });
                $('#addPlayerDialog').dialog('open');
            }

            // Load Users (Đã thêm tham số b)
            function loadUsers(callback) {
                // CẬP NHẬT: Thêm tham số b
                $.getJSON('get_users.php', { b: getBanValue() }, function(data) {
                    allUsers = data;
                    if (callback) callback();
                }).fail(function() {
                    alert('Lỗi tải danh sách người chơi. Vui lòng kiểm tra get_users.php.');
                });
            }

            addGameButton.addEventListener('click', () => {
                gameCount++;
                addGameColumn(gameCount);
                fullRecalculate();
                saveData(); 
            });

            // Chia Bai Button (Giữ nguyên)
            chiabaiBtn.addEventListener('click', () => {
                $('#chiaBaiDialog').dialog('open');
            });

            // =========================================================
            // *** KHỐI KHỞI TẠO (ĐÃ SỬA LỖI GHI ĐÈ) ***
            // =========================================================
            loadData((savedData) => {
                if (savedData && savedData.players && savedData.players.length > 0) {
                    // 1. Tải dữ liệu thành công (từ LocalStorage hoặc Server)
                    renderTable(savedData);
                } else {
                    // 2. Không có dữ liệu hợp lệ (Local/Server rỗng) -> Dùng mặc định
                    console.log("-> Initializing with default players.");
                    gameCount = 30;
                    initializeTable();
                    // Lưu ý: renderTable() đã đặt SoCayMoiNguoi = 10 (nếu không có data)
                    document.getElementById('SoCayMoiNguoi').value = 10;
                    document.getElementById('splitCountInput').value = 2;
                    if (getBanValue()=='1') {
                    defaultPlayerNames.forEach(name => {
                         addPlayerRow(name, []);
                    });
                    }
                    // QUAN TRỌNG: Cập nhật ChiaBaiCho với tên mặc định chỉ khi KHÔNG có dữ liệu đã lưu
                    updateChiaBaiCho(); 
                }

                // Luôn chạy các bước hoàn tất
                initializeTimestamps();
                fullRecalculate();
                updateTimestamps();
                
                updateChiaBaiCho(); 
                
                // Lưu lại trạng thái lần đầu tiên 
                saveData(); 
            });
        });

        // Hàm kiểm tra cột ván để thêm/ẩn viền đỏ (Giữ nguyên)
        function checkColumnsForU() {
            const rows = Array.from(document.getElementById('scoreBody').children);
            const gameHeaders = document.getElementById('gameHeaders').children; 

            for (let col = 1; col <= gameCount; col++) {
                let hasU = false;
                rows.forEach(row => {
                    const cell = row.cells[col];
                    if (cell) {
                        const value = cell.textContent.trim().toLowerCase();
                        if (value.endsWith('u')) {
                            hasU = true;
                        }
                    }
                });

                const headerTh = gameHeaders[col - 1];
                if (headerTh) {
                    if (!hasU) {
                        headerTh.classList.add('no-u-border');
                    } else {
                        headerTh.classList.remove('no-u-border');
                    }
                }

                rows.forEach(row => {
                    const cell = row.cells[col];
                    if (cell) {
                        if (!hasU) {
                            cell.classList.add('no-u-border');
                        } else {
                            cell.classList.remove('no-u-border');
                        }
                    }
                });
            }
        }
        
        // Hàm cập nhật Checkboxes và Input ẩn 'ChiaBaiCho' (Giữ nguyên)
        function updateChiaBaiCho() {
            const scoreBody = document.getElementById('scoreBody');
            const playerCheckboxesDiv = document.getElementById('playerCheckboxes');
            const players = [];
            
            // 1. Lấy danh sách người chơi hiện tại từ bảng điểm
            Array.from(scoreBody.children).forEach(row => {
                const name = row.cells[0].textContent.trim();
                if (name) {
                    players.push(name);
                }
            });

            // 2. Lấy danh sách người chơi ĐÃ CHỌN trước đó (từ input ẩn)
            // Hoặc dùng danh sách hiện tại nếu input ẩn rỗng (cho lần chạy đầu tiên)
            const chiaBaiChoInput = document.getElementById('ChiaBaiCho');
            let selectedPlayers = (chiaBaiChoInput.value || players.join(',')).split(',').map(p => p.trim()).filter(p => p);
            
            // 3. Tạo/Cập nhật Checkbox
            let newCheckboxesHtml = '';
            players.forEach(name => {
                const isChecked = selectedPlayers.includes(name) ? 'checked' : '';
                newCheckboxesHtml += `
                    <label>
                        <input type="checkbox" style="width:15px" data-player-name="${name}" ${isChecked} onchange="handleCheckboxChange()">
                        ${name}
                    </label>
                `;
            });
            playerCheckboxesDiv.innerHTML = newCheckboxesHtml;
            
            // 4. Cập nhật giá trị input ẩn 'ChiaBaiCho' sau khi tạo xong (để đảm bảo đồng bộ)
            handleCheckboxChange(); 
            
            saveData(); // LƯU KHI CẬP NHẬT DANH SÁCH NGƯỜI CHƠI (khi thêm/xóa)
        }
        
        // Hàm xử lý sự kiện khi checkbox thay đổi (cần là global function) (Giữ nguyên)
        function handleCheckboxChange() {
            const checkedNames = [];
            const checkboxes = document.querySelectorAll('#playerCheckboxes input[type="checkbox"]');
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    checkedNames.push(cb.getAttribute('data-player-name'));
                }
            });
            document.getElementById('ChiaBaiCho').value = checkedNames.join(',');
            saveData(); // LƯU KHI CHECKBOX THAY ĐỔI
        }
        
        // Các hàm phụ trợ về âm thanh (Giữ nguyên)
        function playMp3(filePath) { 
            const audio = document.getElementById('dynamicAudioPlayer');
            audio.pause();
            audio.currentTime = 0; 
            audio.src = filePath;
            audio.load(); 
            audio.play()
                .catch(error => {
                console.error(`Không thể phát tệp ${filePath}:`, error);
                });
        }
        let currentCsvPlaylist = [];
        let currentCsvTrackIndex = 0;
        const audioPlayer = document.getElementById('playlistAudioPlayer');
        function startPlaylistFromCsv(fileNamesCsv) { 
            const filesArray = fileNamesCsv.split(',').map(s => s.trim()).filter(s => s.length > 0);
            if (filesArray.length === 0) { console.warn("Danh sách tệp rỗng."); return; }
            currentCsvPlaylist = filesArray;
            currentCsvTrackIndex = 0;
            audioPlayer.removeEventListener('ended', handleCsvTrackEnd);
            audioPlayer.addEventListener('ended', handleCsvTrackEnd);
            playNextCsvTrack();
        }
        function handleCsvTrackEnd() { 
            currentCsvTrackIndex++; 
            playNextCsvTrack();
        }
        function playNextCsvTrack() { 
            if (currentCsvTrackIndex >= currentCsvPlaylist.length) {
                console.log("✅ Đã phát hết danh sách nhạc.");
                return;
            }
            const filePath = currentCsvPlaylist[currentCsvTrackIndex];
            console.log(`🔊 Đang phát: ${filePath} (Bài ${currentCsvTrackIndex + 1} / ${currentCsvPlaylist.length})`);
            audioPlayer.src = filePath;
            audioPlayer.load(); 
            audioPlayer.play()
                .catch(error => {
                console.error(`Lỗi khi phát tệp ${filePath}:`, error);
                currentCsvTrackIndex++;
                setTimeout(playNextCsvTrack, 2);
                });
        }
        function generateCardImages(handStr) {
            return handStr;
        }
        
        
        
        
        // Hàm TẢI DỮ LIỆU CHỈ TỪ SERVER (bỏ qua LocalStorage) (Đã thêm tham số b)
        function loadDataFromServerOnly() {
            console.log("-> loadDataFromServerOnly() called: Loading directly from server...");
            $('#saveStatus').text('Đang tải dữ liệu từ Server...');
            
            // Xóa nội dung bảng hiện tại để chuẩn bị cho dữ liệu mới
            document.getElementById('scoreBody').innerHTML = ''; 

            // CẬP NHẬT: Thêm tham số b
            $.getJSON('load.php?b=<?php echo($ban);?>', { b: getBanValue() }, function(data) {
                
                // KIỂM TRA: Dữ liệu từ server có hợp lệ không
                if (data && data.players && data.players.length > 0) {
                     
                     // 1. Chuẩn bị dữ liệu để lưu vào LocalStorage và render
                     const settings = data.settings || {money: 0, splitCount: 2, gameCount: 30, gameTimestamps: {}, rankCountsByPlayer: {}, soCayMoiNguoi: 10, ban: getBanValue()};
                     const maxGames = settings.gameCount || 30;
                     const gameName = data.gameName || '';

                     const localData = {
                         players: data.players,
                         maxGames: maxGames, 
                         gameName: gameName,
                         settings: settings,
                         timestamp: new Date().toISOString()
                     };
                     
                     // 2. Ghi dữ liệu từ Server vào LocalStorage (để đồng bộ)
                     localStorage.setItem(localStorageKey, JSON.stringify(localData));
                     
                     // 3. Render lại bảng với dữ liệu mới
                     renderTable(localData);
                     
                     // 4. Hoàn tất các bước tính toán
                     initializeTimestamps();
                     fullRecalculate();
                     updateTimestamps();
                     
                     // 5. Thông báo
                     $('#saveStatus').text('✅ Đã tải dữ liệu thành công từ Server.');
                     console.log("-> Server data loaded successfully, table rendered, and saved to LocalStorage.");
                } else {
                     // Server trả về rỗng hoặc không hợp lệ
                     // Có thể chọn giữ lại dữ liệu cũ hoặc reset về mặc định
                     // Ở đây, ta sẽ reset về mặc định nếu server không có gì
                     $('#saveStatus').text('⚠️ Server không có dữ liệu. Khởi tạo mặc định.');
                     console.log("-> Server data empty/invalid. Initializing with default data.");
                     
                     // Logic reset về mặc định (tương tự phần khởi tạo)
                     document.getElementById('scoreBody').innerHTML = ''; 
                     gameCount = 30;
                     initializeTable();
                     document.getElementById('banInput').value = getBanValue(); // Đặt lại mặc định bàn chơi
                     if (getBanValue()=='1') {
                     defaultPlayerNames.forEach(name => {
                         addPlayerRow(name, []);
                     });
                     }
                     updateChiaBaiCho(); // Cập nhật tên mặc định
                     saveData();
                }
            }).fail(function() {
                // Lỗi kết nối Server
                $('#saveStatus').text('❌ Lỗi: Không thể tải dữ liệu từ Server (load.php).');
                alert("Lỗi kết nối hoặc timeout khi tải dữ liệu từ server (load.php).");
                console.error("-> Failed to connect/load from load.php.");
            });
        }
        
        
        
        
        
    </script>
</body>
</html>