<?php
include 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// SỬA LỖI FONT: Thiết lập charset cho phiên kết nối MySQL
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die(json_encode(['error' => "Database connection failed: " . $e->getMessage()]));
}

$player = trim($_POST['player'] ?? '');
$thutuchoi = trim($_POST['ThuTuNguoiChoi'] ?? '');

$card = strtoupper(trim($_POST['card'] ?? ''));
$from = $_POST['from'] ?? '';

$ban=1;
if ( isset( $_POST["Ban"] ) ) $ban=$_POST["Ban"];


if (!$player || !$card || !$from || !preg_match('/^(A|[2-9]|10|J|Q|K)[RCBT]$/', $card)) {
    die(json_encode(['error' => 'Invalid parameters']));
}

$rank = substr($card, 0, -1);

$pdo->beginTransaction();

try {
    $rankMap = ['A' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, 'J' => 11, 'Q' => 12, 'K' => 13];
    $suitMap = ['R' => 3, 'C' => 2, 'B' => 1, 'T' => 0];

    function parseCards($str) {
        $cards = [];
        $parts = array_filter(array_map('trim', explode(',', $str)));
        foreach ($parts as $part) {
            $part = strtoupper($part);
            if (preg_match('/^(A|[2-9]|10|J|Q|K)[RCBT]$/', $part)) {
                $cards[] = $part;
            }
        }
        return array_unique($cards);
    }

    function getAllDeckCards() {
        $ranks = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        $suits = ['R', 'C', 'B', 'T'];
        $allCards = [];
        foreach ($ranks as $rank) {
            foreach ($suits as $suit) {
                $allCards[] = $rank . $suit;
            }
        }
        return $allCards;
    }

    $handName = 'HAND_' . $player;
    $anName = 'AN_' . $player;
    $thoiName = 'THOI_' . $player;
    $nocName = 'NOC_' . $player;
    $anbiName = 'ANBI_' . $player;

    $stmt = $pdo->prepare("SELECT cards FROM billiards_deals WHERE player_name = ? AND Ban=".$ban);
    $update = $pdo->prepare("UPDATE billiards_deals SET cards = ? WHERE player_name = ?  AND Ban=".$ban);
    $insert = $pdo->prepare("INSERT INTO billiards_deals (player_name, cards,ban) VALUES (?, ?, ".$ban.") ON DUPLICATE KEY UPDATE cards = VALUES(cards)");


       // Người vừa hạ bài
        $update->execute([$player, 'NguoiVuaHaBai']);
        // Thứ tự người chơi
        $update->execute([$thutuchoi, 'ThuTuChoi']);

    if ($from === 'noc') {
        // Xử lý bốc nọc: xóa card khỏi BaiTrenNoc, thêm vào HAND_ và NOC_ của player
        
        // Kiểm tra card có trong BaiTrenNoc không
        $stmt->execute(['BaiTrenNoc']);
        $baiTrenNoc = $stmt->fetchColumn() ?? '';
        $nocCards = parseCards($baiTrenNoc);
        
        if (!in_array($card, $nocCards)) {
            throw new Exception('Card not found in BaiTrenNoc');
        }
        
        // Xóa card khỏi BaiTrenNoc
        $nocCards = array_filter($nocCards, function($c) use ($card) {
            return $c !== $card;
        });
        usort($nocCards, function ($a, $b) use ($rankMap, $suitMap) {
            $rankStrA = substr($a, 0, -1);
            $rankStrB = substr($b, 0, -1);
            $rankA = $rankMap[$rankStrA] ?? 0;
            $rankB = $rankMap[$rankStrB] ?? 0;
            if ($rankA != $rankB) {
                return $rankA - $rankB;
            }
            $suitA = $suitMap[substr($a, -1)] ?? 0;
            $suitB = $suitMap[substr($b, -1)] ?? 0;
            return $suitB - $suitA;
        });
        $newBaiTrenNoc = implode(',', $nocCards);
        $update->execute([$newBaiTrenNoc, 'BaiTrenNoc']);
        
 
        
        
        
        // Thêm card vào HAND_
        $stmt->execute([$handName]);
        $hand = $stmt->fetchColumn() ?? '';
        $handCards = parseCards($hand);
        $handCards[] = $card;
        usort($handCards, function ($a, $b) use ($rankMap, $suitMap) {
            $rankStrA = substr($a, 0, -1);
            $rankStrB = substr($b, 0, -1);
            $rankA = $rankMap[$rankStrA] ?? 0;
            $rankB = $rankMap[$rankStrB] ?? 0;
            if ($rankA != $rankB) {
                return $rankA - $rankB;
            }
            $suitA = $suitMap[substr($a, -1)] ?? 0;
            $suitB = $suitMap[substr($b, -1)] ?? 0;
            return $suitB - $suitA;
        });
        $newHand = implode(',', $handCards);
        $update->execute([$newHand, $handName]);
        
        // Thêm card vào NOC_
        $stmt->execute([$nocName]);
        $nocPlayer = $stmt->fetchColumn() ?? '';
        $nocPlayerCards = parseCards($nocPlayer);
        $nocPlayerCards[] = $card;
        usort($nocPlayerCards, function ($a, $b) use ($rankMap, $suitMap) {
            $rankStrA = substr($a, 0, -1);
            $rankStrB = substr($b, 0, -1);
            $rankA = $rankMap[$rankStrA] ?? 0;
            $rankB = $rankMap[$rankStrB] ?? 0;
            if ($rankA != $rankB) {
                return $rankA - $rankB;
            }
            $suitA = $suitMap[substr($a, -1)] ?? 0;
            $suitB = $suitMap[substr($b, -1)] ?? 0;
            return $suitB - $suitA;
        });
        $newNocPlayer = implode(',', $nocPlayerCards);
        $update->execute([$newNocPlayer, $nocName]);
        
    } elseif ($from === 'hand') {
        // Check if any card of this rank is in thoi
        $stmt->execute([$thoiName]);
        $thoi = $stmt->fetchColumn() ?? '';
        $thoiCards = parseCards($thoi);
        $rankThoiCards = array_filter($thoiCards, function($c) use ($rank) { return substr($c, 0, -1) === $rank; });
        if (!empty($rankThoiCards)) {
            throw new Exception('Rank is thoi and cannot be eaten');
        }

        // Check if rank already eaten by others
        $hasRank = false;
        $stmtAnOther = $pdo->prepare("SELECT cards FROM billiards_deals WHERE player_name LIKE 'AN_%' AND player_name != ? AND ban=".$ban);
        $stmtAnOther->execute([$anName]);
        while ($row = $stmtAnOther->fetch(PDO::FETCH_ASSOC)) {
            $otherCards = parseCards($row['cards']);
            foreach ($otherCards as $c) {
                if (substr($c, 0, -1) === $rank) {
                    $hasRank = true;
                    break;
                }
            }
            if ($hasRank) break;
        }
        if ($hasRank) {
            throw new Exception('Rank already eaten by someone else');
        }

        // Move all cards of this rank from hand to an
        $stmt->execute([$handName]);
        $hand = $stmt->fetchColumn() ?? '';
        $cards = parseCards($hand);
        $rankCards = array_filter($cards, function($c) use ($rank) { return substr($c, 0, -1) === $rank; });
        $cards = array_filter($cards, function($c) use ($rank) { return substr($c, 0, -1) !== $rank; });
        usort($cards, function ($a, $b) use ($rankMap, $suitMap) {
            $rankStrA = substr($a, 0, -1);
            $rankStrB = substr($b, 0, -1);
            $rankA = $rankMap[$rankStrA] ?? 0;
            $rankB = $rankMap[$rankStrB] ?? 0;
            if ($rankA != $rankB) {
                return $rankA - $rankB;
            }
            $suitA = $suitMap[substr($a, -1)] ?? 0;
            $suitB = $suitMap[substr($b, -1)] ?? 0;
            return $suitB - $suitA;
        });
        $newHand = implode(',', $cards);
        $update->execute([$newHand, $handName]);
        
                
        $stmt->execute([$anName]);
        $an = $stmt->fetchColumn() ?? '';
        $anCards = parseCards($an);
        $anCards = array_merge($anCards, $rankCards);
        usort($anCards, function ($a, $b) use ($rankMap, $suitMap) {
            $rankStrA = substr($a, 0, -1);
            $rankStrB = substr($b, 0, -1);
            $rankA = $rankMap[$rankStrA] ?? 0;
            $rankB = $rankMap[$rankStrB] ?? 0;
            if ($rankA != $rankB) {
                return $rankA - $rankB;
            }
            $suitA = $suitMap[substr($a, -1)] ?? 0;
            $suitB = $suitMap[substr($b, -1)] ?? 0;
            return $suitB - $suitA;
        });
        $newAn = implode(',', $anCards);
        $update->execute([$newAn, $anName]);
        $update->execute([chuyenDoiMaBai($newAn), $anbiName]);
        
        // Update THOI_ for other players - move all same rank from their HAND_ to THOI_
        $stmtPlayers = $pdo->prepare("SELECT player_name FROM billiards_deals WHERE player_name LIKE 'HAND_%' AND player_name != ?  AND ban=".$ban);
        $stmtPlayers->execute([$handName]);
        while ($row = $stmtPlayers->fetch(PDO::FETCH_ASSOC)) {
            $otherHandName = $row['player_name'];
            $otherPlayer = substr($otherHandName, 5);
            $otherThoiName = 'THOI_' . $otherPlayer;
            
            $stmt->execute([$otherHandName]);
            $otherHand = $stmt->fetchColumn() ?? '';
            $otherCards = parseCards($otherHand);
            
            $stmt->execute([$otherThoiName]);
            $otherThoi = $stmt->fetchColumn() ?? '';
            $otherThoiCards = parseCards($otherThoi);
            
            $toAdd = [];
            foreach ($otherCards as $c) {
                if (substr($c, 0, -1) === $rank && !in_array($c, $otherThoiCards)) {
                    $toAdd[] = $c;
                }
            }
            
            if ($toAdd) {
                // Remove from otherHand
                $otherCards = array_filter($otherCards, function($c) use ($toAdd) {
                    return !in_array($c, $toAdd);
                });
                usort($otherCards, function ($a, $b) use ($rankMap, $suitMap) {
                    $rankStrA = substr($a, 0, -1);
                    $rankStrB = substr($b, 0, -1);
                    $rankA = $rankMap[$rankStrA] ?? 0;
                    $rankB = $rankMap[$rankStrB] ?? 0;
                    if ($rankA != $rankB) {
                        return $rankA - $rankB;
                    }
                    $suitA = $suitMap[substr($a, -1)] ?? 0;
                    $suitB = $suitMap[substr($b, -1)] ?? 0;
                    return $suitB - $suitA;
                });
                $newOtherHand = implode(',', $otherCards);
                $update->execute([$newOtherHand, $otherHandName]);

                // Add to otherThoi
                $otherThoiCards = array_merge($otherThoiCards, $toAdd);
                usort($otherThoiCards, function ($a, $b) use ($rankMap, $suitMap) {
                    $rankStrA = substr($a, 0, -1);
                    $rankStrB = substr($b, 0, -1);
                    $rankA = $rankMap[$rankStrA] ?? 0;
                    $rankB = $rankMap[$rankStrB] ?? 0;
                    if ($rankA != $rankB) {
                        return $rankA - $rankB;
                    }
                    $suitA = $suitMap[substr($a, -1)] ?? 0;
                    $suitB = $suitMap[substr($b, -1)] ?? 0;
                    return $suitB - $suitA;
                });
                $newOtherThoi = implode(',', $otherThoiCards);
                $update->execute([$newOtherThoi, $otherThoiName]);
            }
        }

        // Update BaiTrenNoc to remove all cards of the eaten rank
        $stmtAllAn = $pdo->prepare("SELECT cards FROM billiards_deals WHERE player_name LIKE 'AN_%'  AND ban=".$ban);
        $stmtAllAn->execute();
        $eatenRanks = [];
        while ($row = $stmtAllAn->fetch(PDO::FETCH_ASSOC)) {
            $cards = parseCards($row['cards']);
            foreach ($cards as $c) {
                $rankCheck = substr($c, 0, -1);
                if (!in_array($rankCheck, $eatenRanks)) {
                    $eatenRanks[] = $rankCheck;
                }
            }
        }

        $stmt->execute(['BaiTrenNoc']);
        $baiTrenNoc = $stmt->fetchColumn() ?? '';
        $nocCards = parseCards($baiTrenNoc);
        $nocCards = array_filter($nocCards, function($c) use ($eatenRanks) {
            $rankCheck = substr($c, 0, -1);
            return !in_array($rankCheck, $eatenRanks);
        });
        usort($nocCards, function ($a, $b) use ($rankMap, $suitMap) {
            $rankStrA = substr($a, 0, -1);
            $rankStrB = substr($b, 0, -1);
            $rankA = $rankMap[$rankStrA] ?? 0;
            $rankB = $rankMap[$rankStrB] ?? 0;
            if ($rankA != $rankB) {
                return $rankA - $rankB;
            }
            $suitA = $suitMap[substr($a, -1)] ?? 0;
            $suitB = $suitMap[substr($b, -1)] ?? 0;
            return $suitB - $suitA;
        });
        $newBaiTrenNoc = implode(',', $nocCards);
        $update->execute([$newBaiTrenNoc, 'BaiTrenNoc']);
        
    } elseif ($from === 'an') {
        // Move all cards of this rank from an to hand
        $stmt->execute([$anName]);
        $an = $stmt->fetchColumn() ?? '';
        $anCards = parseCards($an);
        $rankCards = array_filter($anCards, function($c) use ($rank) { return substr($c, 0, -1) === $rank; });
        $anCards = array_filter($anCards, function($c) use ($rank) { return substr($c, 0, -1) !== $rank; });
        usort($anCards, function ($a, $b) use ($rankMap, $suitMap) {
            $rankStrA = substr($a, 0, -1);
            $rankStrB = substr($b, 0, -1);
            $rankA = $rankMap[$rankStrA] ?? 0;
            $rankB = $rankMap[$rankStrB] ?? 0;
            if ($rankA != $rankB) {
                return $rankA - $rankB;
            }
            $suitA = $suitMap[substr($a, -1)] ?? 0;
            $suitB = $suitMap[substr($b, -1)] ?? 0;
            return $suitB - $suitA;
        });
        $newAn = implode(',', $anCards);
        $update->execute([$newAn, $anName]);
        $update->execute([chuyenDoiMaBai($newAn), $anbiName]);
        
        $stmt->execute([$handName]);
        $hand = $stmt->fetchColumn() ?? '';
        $cards = parseCards($hand);
        $cards = array_merge($cards, $rankCards);
        usort($cards, function ($a, $b) use ($rankMap, $suitMap) {
            $rankStrA = substr($a, 0, -1);
            $rankStrB = substr($b, 0, -1);
            $rankA = $rankMap[$rankStrA] ?? 0;
            $rankB = $rankMap[$rankStrB] ?? 0;
            if ($rankA != $rankB) {
                return $rankA - $rankB;
            }
            $suitA = $suitMap[substr($a, -1)] ?? 0;
            $suitB = $suitMap[substr($b, -1)] ?? 0;
            return $suitB - $suitA;
        });
        $newHand = implode(',', $cards);
        $update->execute([$newHand, $handName]);
        
        // Check if rank still eaten by anyone
        $stillHasRank = false;
        $stmtAllAn = $pdo->prepare("SELECT cards FROM billiards_deals WHERE player_name LIKE 'AN_%'  AND ban=".$ban);
        $stmtAllAn->execute();
        while ($row = $stmtAllAn->fetch(PDO::FETCH_ASSOC)) {
            $anCardsCheck = parseCards($row['cards']);
            foreach ($anCardsCheck as $c) {
                if (substr($c, 0, -1) === $rank) {
                    $stillHasRank = true;
                    break;
                }
            }
            if ($stillHasRank) break;
        }

        if (!$stillHasRank) {
            // Remove from all THOI_ and add back to HAND_
            $stmtThoiAll = $pdo->prepare("SELECT player_name FROM billiards_deals WHERE player_name LIKE 'THOI_%'  AND ban=".$ban);
            $stmtThoiAll->execute();
            while ($row = $stmtThoiAll->fetch(PDO::FETCH_ASSOC)) {
                $thoiNameCheck = $row['player_name'];
                $stmt->execute([$thoiNameCheck]);
                $thoi = $stmt->fetchColumn() ?? '';
                $thoiCards = parseCards($thoi);
                $toRemove = array_filter($thoiCards, function($c) use ($rank) {
                    return substr($c, 0, -1) === $rank;
                });
                $thoiCards = array_filter($thoiCards, function($c) use ($rank) {
                    return substr($c, 0, -1) !== $rank;
                });
                $newThoi = implode(',', $thoiCards);
                $update->execute([$newThoi, $thoiNameCheck]);

                if ($toRemove) {
                    $otherPlayer = substr($thoiNameCheck, 5);
                    $otherHandName = 'HAND_' . $otherPlayer;
                    $stmt->execute([$otherHandName]);
                    $otherHand = $stmt->fetchColumn() ?? '';
                    $otherCards = parseCards($otherHand);
                    $otherCards = array_merge($otherCards, $toRemove);
                    usort($otherCards, function ($a, $b) use ($rankMap, $suitMap) {
                        $rankStrA = substr($a, 0, -1);
                        $rankStrB = substr($b, 0, -1);
                        $rankA = $rankMap[$rankStrA] ?? 0;
                        $rankB = $rankMap[$rankStrB] ?? 0;
                        if ($rankA != $rankB) {
                            return $rankA - $rankB;
                        }
                        $suitA = $suitMap[substr($a, -1)] ?? 0;
                        $suitB = $suitMap[substr($b, -1)] ?? 0;
                        return $suitB - $suitA;
                    });
                    $newOtherHand = implode(',', $otherCards);
                    $update->execute([$newOtherHand, $otherHandName]);
                }
            }

            // Add back all cards of this rank to BaiTrenNoc that are not in any HAND_, AN_, THOI_, or NOC_
            $stmtAllCards = $pdo->prepare("SELECT cards FROM billiards_deals WHERE (player_name LIKE 'HAND_%' OR player_name LIKE 'AN_%' OR player_name LIKE 'THOI_%' OR player_name LIKE 'NOC_%')  AND ban=".$ban);
            $stmtAllCards->execute();
            $usedCards = [];
            while ($row = $stmtAllCards->fetch(PDO::FETCH_ASSOC)) {
                $usedCards = array_merge($usedCards, parseCards($row['cards']));
            }
            
            $rankCardsToAdd = [];
            $possibleSuits = ['R', 'C', 'B', 'T'];
            foreach ($possibleSuits as $suit) {
                $potentialCard = $rank . $suit;
                if (!in_array($potentialCard, $usedCards)) {
                    $rankCardsToAdd[] = $potentialCard;
                }
            }

            $stmt->execute(['BaiTrenNoc']);
            $noc = $stmt->fetchColumn() ?? '';
            $nocCards = parseCards($noc);
            $nocCards = array_merge($nocCards, $rankCardsToAdd);
            usort($nocCards, function ($a, $b) use ($rankMap, $suitMap) {
                $rankStrA = substr($a, 0, -1);
                $rankStrB = substr($b, 0, -1);
                $rankA = $rankMap[$rankStrA] ?? 0;
                $rankB = $rankMap[$rankStrB] ?? 0;
                if ($rankA != $rankB) {
                    return $rankA - $rankB;
                }
                $suitA = $suitMap[substr($a, -1)] ?? 0;
                $suitB = $suitMap[substr($b, -1)] ?? 0;
                return $suitB - $suitA;
            });
            $newNoc = implode(',', $nocCards);
            $update->execute([$newNoc, 'BaiTrenNoc']);
        }
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    die(json_encode(['error' => $e->getMessage()]));
}




function chuyenDoiMaBai(string $chuoiMa): string
{
    // 1. Tách chuỗi đầu vào thành mảng các mã bài
    $maBaiArray = explode(',', $chuoiMa);
    
    // Mảng để lưu trữ các Rank đã được trích xuất (chưa loại bỏ trùng lặp)
    $extractedRanks = [];

    foreach ($maBaiArray as $ma) {
        $ma = trim($ma); // Loại bỏ khoảng trắng thừa (nếu có)

        if (strlen($ma) >= 2) {
            // Kiểm tra độ dài mã để trích xuất Rank
            if (strlen($ma) > 2) {
                // Nếu dài hơn 2 ký tự (vd: '10C'), lấy 2 ký tự đầu tiên
                $rank = substr($ma, 0, 2); 
            } else {
                // Nếu dài đúng 2 ký tự (vd: 'AR'), lấy ký tự đầu tiên
                $rank = substr($ma, 0, 1);
            }
            
            // Thêm Rank đã trích xuất vào mảng
            $extractedRanks[] = $rank;
        }
    }

    // 3. Loại bỏ các giá trị Rank trùng lặp
    $uniqueRanks = array_unique($extractedRanks);

    // 4. Nối các giá trị Rank duy nhất lại thành chuỗi, ngăn cách bởi dấu phẩy
    return implode(',', $uniqueRanks);
}





?>