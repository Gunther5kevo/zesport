<?php
function getVideosByCategory($pdo, $categories, $limit = 4) {
    $categories = is_array($categories) ? $categories : [$categories];
    $placeholders = rtrim(str_repeat('?,', count($categories)), ',');

    $query = "SELECT * FROM videos WHERE category IN ($placeholders) ORDER BY upload_date DESC LIMIT ?";
    $stmt = $pdo->prepare($query);

    $params = array_merge($categories, [$limit]);
    
    foreach ($params as $key => $value) {
        $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue($key + 1, $value, $paramType);
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

