<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chia bài để bốc thứ tự chơi ván đầu</title>
    
    <style>
        /* CSS TỰ VIẾT */
        
        /* Cấu trúc cơ bản và Responsive */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f7f7f7; 
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto; 
            padding: 1.5rem; 
        }

        h1 {
            font-size: 1.875rem; 
            font-weight: 800; 
            text-align: center; 
            color: #374151; 
            margin-bottom: 1.5rem; 
        }

        /* Nút bấm */
        #generateButton {
            width: 100%; 
            background-color: #059669; 
            color: white; 
            font-weight: 700; 
            padding: 0.75rem 1rem; 
            border-radius: 0.5rem; 
            transition: background-color 0.2s ease, box-shadow 0.2s ease; 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); 
            
            border: none;
            cursor: pointer;
        }

        #generateButton:hover {
            background-color: #047857; 
        }
        
        #generateButton:disabled {
            background-color: #a7f3d0;
            cursor: not-allowed;
            color: #4b5563;
        }

        /* Khung chứa các quân bài (GRID) */
        .card-grid {
            /* Responsive Grid: 3 cột trên di động (mặc định) */
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 1rem; 
            max-width: 1000px;
            margin: 1rem auto;
            padding: 1rem;
        }
        
        /* Responsive cho màn hình sm trở lên (640px) */
        @media (min-width: 640px) {
            .card-grid { grid-template-columns: repeat(4, 1fr); }
        }
        
        /* Responsive cho màn hình lg trở lên (1024px) */
        @media (min-width: 1024px) {
            .card-grid { grid-template-columns: repeat(4, 1fr); }
        }

        /* --- Cấu trúc Flip Card (Quan trọng) --- */
        .flipcard {
            background-color: transparent;
            /* Thiết lập tỉ lệ 107:150 (Chiều cao / Chiều rộng = 150 / 107 ≈ 140.187%) */
            width: 100%; 
            /* Sử dụng calc(150 / 107 * 100%) để đảm bảo tỉ lệ chính xác và responsive */
            padding-top: calc(150 / 107 * 100%); 
            height: 0; 
            perspective: 1000px; 
            margin: 0 auto; 
            position: relative;
        }

        .flipcard-inner {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s ease-in-out; 
            transform-style: preserve-3d;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2); 
            border-radius: 5px; 
            background-color: white;
        }

        /* Thêm class 'flipped' khi người dùng click */
        .flipcard.flipped .flipcard-inner {
            transform: rotateY(180deg);
        }

        /* Mặt trước (Úp) và Mặt sau (Ngửa) */
        .front, .back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden; 
            backface-visibility: hidden;
            border-radius: 5px; 
            overflow: hidden;
        }

        /* Ảnh quân bài */
        .front img, .back img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            user-select: none;
        }

        /* Mặt sau (Quân bài ngửa) */
        .back {
            transform: rotateY(180deg);
        }

        /* --- CSS cho Hiệu ứng Chia bài --- */
        .card-start-position {
            opacity: 0;
            position: relative; 
            transition: transform 0.8s cubic-bezier(0.5, 0, 0.5, 1), opacity 0.4s ease-out;
        }
        
        /* Quân bài Placeholder ở giữa (visual cue) */
        #sourceCard {
           
        }
        #sourceCard img {
           
        }
    </style>
</head>
<body>
<audio id="dynamicAudioPlayer"></audio>

    <div class="container">
        
        <button id="generateButton">
            Chia bài để bốc thứ tự chơi ván đầu
        </button>
        
        <!-- Placeholder Card (Mặt sau) tại trung tâm phía dưới màn hình -->
        <div id="sourceCard">
         
        </div>

        <div id="cardsContainer" class="card-grid">
            <!-- 12 quân bài sẽ được chèn vào đây -->
        </div>
    </div>

    <script>
        // Cấu hình bài
        const VALUES = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        const SUITS = ['R', 'C', 'B', 'T']; 
        const FOLDER = 'desk/';
        const NUM_CARDS = 12; // Số lượng quân bài cần chia

        // Phần tử DOM
        const cardsContainer = document.getElementById('cardsContainer');
        const generateButton = document.getElementById('generateButton');
        const sourceCard = document.getElementById('sourceCard');

        // --- HÀM TẠO DỮ LIỆU ---

        function generateRandomCards() {
            const allCards = [];
            for (const suit of SUITS) {
                for (const value of VALUES) {
                    allCards.push(value + suit);
                }
            }

            // Xáo trộn (Fisher-Yates shuffle)
            for (let i = allCards.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [allCards[i], allCards[j]] = [allCards[j], allCards[i]];
            }
            return allCards.slice(0, NUM_CARDS);
        }

        /**
         * Hàm tạo mã HTML cho các quân bài.
         * @param {string[]} randomCards Mảng 12 mã quân bài ngẫu nhiên.
         * @returns {string} Chuỗi HTML cho 12 thẻ flip card.
         */
        function renderCardsHTML(randomCards) {
            let htmlContent = '';
            
            randomCards.forEach(cardCode => {
                const filePath = FOLDER + cardCode + '.svg';
                const backPath = FOLDER + 'back.svg'; 

                // Thêm class 'card-start-position' để chuẩn bị cho animation
                htmlContent += `
                    <div class="flipcard card-start-position">
                        <div class="flipcard-inner">
                            <!-- Mặt trước (Úp) -->
                            <div class="front"> 
                                <img src="${backPath}" alt="Mặt sau quân bài">
                            </div>
                            <!-- Mặt sau (Ngửa) -->
                            <div class="back">
                                <img src="${filePath}" alt="Quân bài ${cardCode}">    
                            </div>
                        </div>
                    </div>
                `;
            });

            return htmlContent;
        }

        // --- HÀM XỬ LÝ SỰ KIỆN VÀ ANIMATION ---

        /**
         * Xử lý click để lật/đóng quân bài
         */
        function handleCardClick(event) {
            const flipcard = event.currentTarget;
            flipcard.classList.toggle('flipped');
            playMp3("voice/lat.mp3");
        }

        
           function 
            playMp3(filePath) {;
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
         * Hàm chính để chạy và hiển thị bài với hiệu ứng chia bài
         */
        function displayCards() {
            // 1. Tắt nút và chuẩn bị
         
            cardsContainer.innerHTML = '';
            playMp3("voice/chiaxong.mp3");

            const twelveRandomCards = generateRandomCards();
            const html = renderCardsHTML(twelveRandomCards);
            
            // 2. Chèn thẻ, nhưng chúng vẫn ẩn và chưa được định vị
            cardsContainer.innerHTML = html;
            const cards = Array.from(cardsContainer.children);

            // Đọc tọa độ của quân bài nguồn (sau khi nó được hiện)
            const sourceRect = sourceCard.getBoundingClientRect();
            
            // Lấy tọa độ trung tâm của quân bài nguồn (điểm xuất phát mới: giữa, dưới đáy)
            const startX = sourceRect.left + sourceRect.width / 2;
            const startY = sourceRect.top + sourceRect.height / 2;
            
            // 3. Thiết lập vị trí ban đầu (tại vị trí nguồn)
            cards.forEach(card => {
                // Lấy vị trí cuối cùng của quân bài trong Grid
                const finalRect = card.getBoundingClientRect();
                
                // Tính toán khoảng cách cần translate để nó START tại vị trí nguồn
                const translateX = startX - finalRect.left - (finalRect.width / 2);
                const translateY = startY - finalRect.top - (finalRect.height / 2);

                // Đặt vị trí bắt đầu
                card.style.transform = `translate(${translateX}px, ${translateY}px)`;

                // Gắn sự kiện lật bài
                card.addEventListener('click', handleCardClick);
            });
            
            // 4. Bắt đầu animation chia bài (staggered)
            cards.forEach((card, index) => {
                const delay = index * 80; // Độ trễ giữa các lần chia bài (80ms)

                setTimeout(() => {
                    // Loại bỏ transform để quân bài trở về vị trí Grid (animation)
                    card.style.transform = 'translate(0, 0)';
                    card.style.opacity = 1;
                    
                    // Khi quân bài cuối cùng được chia xong, ẩn placeholder card
                    if (index === cards.length - 1) {
                        setTimeout(() => {
                            sourceCard.style.opacity = 0;                            
                         
                        }, 800); // 800ms sau khi quân cuối cùng bắt đầu di chuyển
                    }
                }, delay);
            });
        }

        // Gắn sự kiện cho nút bấm
        generateButton.addEventListener('click', displayCards);

        // Hiển thị lần đầu tiên khi tải trang
        window.onload = displayCards;
    </script>

</body>
</html>
