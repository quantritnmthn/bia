
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theo dõi điểm số Billiards</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        html,body { 
            font-family: Arial, sans-serif; 
            padding: 10px; 
            background-color: #fff; 
            margin: 0;
            height: 100%;
            display: flex;
    flex-direction: column; /* Xếp các phần tử theo chiều dọc */
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
            font-size:14px;
        }
        #resultTable th, #resultTable td { 
            border: 1px solid #ddd; 
            padding: 6px 4px; 
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
        .result-col { font-weight: bold; }
        
        .game-score-col { background-color: #fff; color: #cc0000; }
        .score-m { background-color: #cc0000 !important; color: white !important; }
        .score-u { background-color: #a5eba7 !important; color: #1b620e !important; } 
        .score-s { background-color: #ff4500 !important; color: yellow !important; } 
        .score-0u {background-color: #f4fb6b !important; color: #7c761e !important;}       
        .total-moms {background-color: #cc0000 !important;  color: #ffffff !important;}
        .total-us{background-color: #4dd150 !important;color: #1b620e !important;}
        .total-scars {background-color: #ff4500 !important;     color: #ffff00 !important;}
        
        
            .baou { padding:3px; margin-top:2px;
	-webkit-animation: pulse 400ms infinite alternate;
	        animation: pulse 400ms infinite alternate;
}
@-webkit-keyframes pulse {
	0% { background-color: red; }
	100% { background-color: yellow; }
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
        
        .total-cays {font-size:18px; background-color:#000; color:#f4fb6b}
        
        .diff-row { color: red; font-weight: bold;  }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            body { padding: 5px; }
            
            #resultTable { 
                min-width: 100%;
            }
            
            #resultTable th:not(.player-name-col), 
            #resultTable td:not(.player-name-col) {
                width: calc(70% / var(--num-players, 3)); /* Dynamic width */
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
.view-btn { background-color: #4CAF50; font-weight:bold }
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
            width:100%;
            white-space: nowrap; /* Tránh ngắt dòng trong nút */
        }
       #biMucTieuTable { border-collapse: collapse; width: 100%; margin-bottom: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        #biMucTieuTable th, #biMucTieuTable td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        #biMucTieuTable th { background-color: #add8e6; font-weight: bold; }
        #baiCuaBan, #cayDaAn { width: 50%; background-color: #f9f9f9; }
        
        #biMucTieuTable td { vertical-align: top; }
        #eatenTable { border-collapse: collapse; width: 100%; border-radius: 8px;  box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 100%;   table-layout: fixed;  }
        #eatenTable th, #eatenTable td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        #eatenTable th { background-color: #f0ffdd; font-weight: bold; }
        #eatenTable td { vertical-align: top; }
        .deskcard { cursor: pointer; width: 46%; margin: 2px; transition: opacity 0.3s ease, transform 0.3s ease; border-radius: 3px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        
        .nutbocnoc { cursor: pointer; width: 80%; margin: 2px; transition: opacity 0.3s ease, transform 0.3s ease;  }
        .deskcard:hover, .nutbocnoc:hover { transform: scale(1.20); }
        .deskcard.disabled { pointer-events: none; opacity:0.25; }
        
        #eatenTable .deskcard { pointer-events: none; width: 100%;  
        display: block; 
    /* Các thuộc tính này cần thiết cho hiệu ứng xếp chồng */
  position: relative; 
  /* Z-index sẽ được điều chỉnh cho từng lá bài */
  z-index: 1; 
  /* Khoảng dịch chuyển: -80% chiều cao sẽ chồng 20% (100% - 80% = 20%) */
  margin-top: -99%;  
        }
        
        .poolball {width: 17%;margin:1%;}
        
        
        .image-stack {
  position: relative; /* Quan trọng: đặt khung tham chiếu cho ảnh con */
  display: inline-block; /* Giúp container ôm vừa nội dung */
}
      #eatenTable  .deskcard:first-child {
  margin-top: 0;
}
        
    </style>
</head>
<body>
		
		<audio id="dynamicAudioPlayer"></audio>
<audio id="playlistAudioPlayer"></audio>

		<div class="controls">
            <button class="action-button view-btn" id="ViewScore">Xem thống kê kết quả</button>
        </div>

<div id="ScoreDiv" style="display:none">
    <select id="playerSelect">
        <option value="">-- Chọn người chơi --</option>
    </select>
    
    <div style="width:100%; text-align:center; background: #0e8dbc; padding-bottom:8px"><span id="largeScore"></span>
    	<span id="ThuTuChoi" style="font-weight:bold; color:#fff;"></span>
    </div>    
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
  			
<?php
$simple_string = "Hoàng";

// Store the cipher method
$ciphering = "aes-256-cbc";
$options = 0;
$encryption_iv = '1234567891011121';
$encryption_key = "The Ministry of Public Security";
$encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
$decryption_iv = '1234567891011121';
$decryption_key = "The Ministry of Public Security";

if (!isset($_GET["u"])) $encryption=""; else $encryption=$_GET["u"];
$decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

echo($decryption);
?>

<div id="DeskDiv">
    <table id="biMucTieuTable" border="1" style="width:100%; margin-bottom:20px;">
        <tr><th style="width:50%">Bi mục tiêu</th><th style="width:50%">Bốc sẹo</th></tr>
        <tr><td id="BiMucTieu"></td><td id="BocNoc"></td></tr>
        <tr><th style="width:50%">Bài của bạn</th><th style="width:50%">Cây bạn đã ăn</th></tr>
        <tr><td id="baiCuaBan"></td><td id="cayDaAn"></td></tr>
    </table>
    
    <table id="eatenTable" border="1" style="width:100%;">
        <thead id="eatenHeader"></thead>
        <tbody id="eatenBody"></tbody>
    </table>
</div>

<script>
    let currentPlayer = '<?php echo($decryption);?>'.trim();
    const storageKey = 'selectedPlayerID'; 

    $(document).ready(function(){
        $("#ViewScore").click(function(){
            $("#ScoreDiv").toggle(); 
        });
    });
    
    function loadData() {
        $.ajax({
            url: 'load.php',
            type: 'GET',
            success: function(response) {
                if (typeof window._prevLoadResponse !== 'undefined' && response === window._prevLoadResponse) {
                    return;
                }
                window._prevLoadResponse = response;

                let data;
                try {
                    data = JSON.parse(response);
                } catch (e) {
                    data = {};
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
                }
                
                const playersData = players.map(p => {
                    let cays = 0, moms = 0, us = 0, scars = 0;
                    p.scores.slice(0, maxGame).forEach(score => {
                        const lower = score.trim().toLowerCase();
                        if (!lower) return;
                        cays += extractNumericScore(lower);
                        if (lower.endsWith('m')) moms++;
                        else if (lower.endsWith('u')) us++;
                        else if (lower.endsWith('s')) scars++;
                    });
                    return { name: p.name, cays, moms, us, scars };
                });
                
                playersData.sort((a, b) => {
                    if (a.cays !== b.cays) return a.cays - b.cays;
                    if (a.us !== b.us) return b.us - a.us;
                    if (a.moms !== b.moms) return a.moms - b.moms;
                    return a.scars - b.scars;
                });
                
                const leader = playersData[0];
                
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
                
                if (currentPlayer) {
                    const selected = playersData.find(pd => pd.name === currentPlayer);
                    if (selected) {
                        $('#largeScore').text(selected.cays).show();
                    }
                } else {
                    $('#largeScore').hide();
                }
            }
        });
        
        $.ajax({
            url: 'get_thutuchoi.php',
            type: 'GET',
            dataType: 'text',
            success: function(thuTuChoi) {
                $('#ThuTuChoi').text(thuTuChoi);
            },
            error: function(xhr, status, error) {
                $('#ThuTuChoi').text('Lỗi tải thứ tự chơi.');
                console.error("Lỗi AJAX khi tải thứ tự chơi:", status, error);
            }
        });
    }
    
    function extractNumericScore(value) {
        const match = value.match(/^\s*(\d+)/);
        return match ? parseInt(match[1]) : 0;
    }
    
    $(document).ready(function() {
        const savedID = localStorage.getItem(storageKey);
        if (savedID) {
            currentPlayer = savedID; 
        }
        
        loadData();
        setInterval(loadData, 2300);
        
        $('#playerSelect').change(function() {        	
            currentPlayer = $(this).val();
            localStorage.setItem(storageKey, currentPlayer);             
            location.reload();
        });
        
        loadDesk();
        setInterval(loadDesk, 2300);
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
    
    function loadDesk() {
        $.ajax({
            url: 'load_desk.php',
            type: 'GET',
            success: function(response) {
                if (typeof window._prevDeskResponse !== 'undefined' && response === window._prevDeskResponse) {
                    return;
                }
                window._prevDeskResponse = response;
                
                let data;
                try {
                    data = JSON.parse(response);
                } catch (e) {
                    return;
                }
                
                const hand = data.hands.find(h => h.startsWith('HAND_' + currentPlayer + ':'));
                const an = data.ans.find(a => a.startsWith('AN_' + currentPlayer + ':'));
                const thoi = data.thoi.find(t => t.startsWith('THOI_' + currentPlayer + ':'));
                const disabledCards = thoi ? thoi.split(':')[1].split(',').map(c => c.trim().toUpperCase()) : [];
                
                
                
                
$('#BiMucTieu').html(Get_BiMucTieu(hand));
                
                
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
                
                let header = '<tr>';
                let row = '<tr>';
                data.ans.forEach(a => {
                	
                	
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
                    
                    
                         let uhaymom="";
                         if (anCount==0) uhaymom="Móm ";
                         if ((handCount==0) && (anCount>0)) uhaymom="Ù ";
                    
                    header += `<th>${name}<br><b style="color:#ff0000; font-size:15px">(${uhaymom}${socay} cây)</b>
                    <br><span style="color:#1d661c; font-size:13px; font-weight:normal">(Ăn <b style="color:#0b6bfb;">${anCount}</b> cây, thối <b style="color:#0b6bfb;">${thoiCount}</b> cây, bốc sẹo <b style="color:#0b6bfb;">${seoCount}</b> cây, còn <b style="color:#0b6bfb;">${handCount}</b> cây để ăn)</span>
                    </th>`;
                    row += `<td><div class="image-stack">${generateCardImages(a)}</div></td>`;
                });
                header += '</tr>';
                row += '</tr>';
                
                
                /////////// Hiển thị cây đã bốc sẹo
                
                header += '<tr>';
                row += '<tr style="background:#ffbbbb">';
                data.bocnoc.forEach(a => {                	
                    const name = a.split(':')[0].substring(3);                    
                    row += `<td>${generateCardImages(a)}</td>`;
                });
                
                row += '</tr>';
                
                //console.log(data.baiTrenNoc);
                let socaytrennoc = countStringElements(data.baiTrenNoc);
                if (socaytrennoc>0)
                {
                $("#BocNoc").html(`<img src="desk/back.svg" class="nutbocnoc" data-code="${getRandomElement(data.baiTrenNoc)}" style="width:48%"><br><span>Nọc còn <b style="color:#0b6bfb;">${socaytrennoc}</b> cây</span>`);
                }
                else
                {
                	$("#BocNoc").html(`<b style="color:#ff0000;">Nọc không còn cây nào phù hợp để bốc!</span>`);
                }
                
                $('#eatenHeader').html(header);
                $('#eatenBody').html(row);
            }
        });
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
    
    $(document).on('dblclick', '#baiCuaBan .deskcard', function() {
        if ($(this).hasClass('disabled')) return;
        const $img = $(this);
        const card = $img.data('code');
       
        $.ajax({
            url: 'update_desk.php',
            type: 'POST',
            data: { player: currentPlayer, card: card, from: 'hand' },
            success: function(response) {
                loadDesk();
                playMp3("voice/"+getCardValue(card)+".mp3");
                
            },
            error: function() {
                console.error('Error updating desk');
            }
        });
    });
    
    $(document).on('dblclick', '#cayDaAn .deskcard', function() {
        const $img = $(this);
        const card = $img.data('code');
      
        $.ajax({
            url: 'update_desk.php',
            type: 'POST',
            data: { player: currentPlayer, card: card, from: 'an' },
            success: function(response) {
                loadDesk();
            },
            error: function() {
                console.error('Error updating desk');
            }
        });
    });
    
    ////// Bốc nọc
    
    // Xử lý double click nút bốc nọc
            $(document).on('dblclick', '.nutbocnoc', function() {
            	
            	// Hỏi xác nhận trước khi bốc nọc
    if (!confirm(`Bạn có muốn bốc bài trong nọc không?`)) {
        return;
    }
            	
            	
            	
                const card = $(this).data('code');
                if (!card || !currentPlayer) {
                    console.error('Missing player or card data');
                    return;
                }
                
                $.ajax({
                    url: 'update_desk.php',
                    type: 'POST',
                    data: { player: currentPlayer, card: card, from: 'noc' },
                    success: function(response) {
                        console.log('Bốc nọc thành công:', response);
                        loadDesk(); // Load lại desk sau khi bốc
                        playMp3("voice/B"+getCardValue(card)+".mp3");
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


</script>

</body>
</html>




	
	
	
	
	
	
	
	
	
	
	
