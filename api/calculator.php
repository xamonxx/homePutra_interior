<?php

/**
 * Calculator API Endpoint
 * Home Putra Interior
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../config/database.php';

// Initialize calculator tables if not exist
function initCalculatorTables()
{
    try {
        $db = getDB();
        $sql = file_get_contents(__DIR__ . '/../config/calculator_schema.sql');
        $db->exec($sql);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Get all products
function getProducts()
{
    $db = getDB();
    $stmt = $db->query("SELECT * FROM calculator_products WHERE is_active = 1 ORDER BY display_order");
    return $stmt->fetchAll();
}

// Get materials for a product
function getMaterials($productId = null)
{
    $db = getDB();
    if ($productId) {
        $stmt = $db->prepare("
            SELECT m.* FROM calculator_materials m
            INNER JOIN calculator_product_materials pm ON m.id = pm.material_id
            WHERE pm.product_id = ? AND pm.is_available = 1 AND m.is_active = 1
            ORDER BY m.display_order
        ");
        $stmt->execute([$productId]);
    } else {
        $stmt = $db->query("SELECT * FROM calculator_materials WHERE is_active = 1 ORDER BY display_order");
    }
    return $stmt->fetchAll();
}

// Get all models
function getModels()
{
    $db = getDB();
    $stmt = $db->query("SELECT * FROM calculator_models WHERE is_active = 1 ORDER BY display_order");
    return $stmt->fetchAll();
}

// Get price per meter
function getPrice($productId, $materialId, $modelId, $locationType)
{
    $db = getDB();
    $stmt = $db->prepare("
        SELECT price_per_meter FROM calculator_prices 
        WHERE product_id = ? AND material_id = ? AND model_id = ? AND location_type = ? AND is_active = 1
    ");
    $stmt->execute([$productId, $materialId, $modelId, $locationType]);
    $result = $stmt->fetch();
    return $result ? (float)$result['price_per_meter'] : null;
}

// Get shipping cost
function getShippingCost($total, $locationType)
{
    $db = getDB();
    $stmt = $db->prepare("
        SELECT shipping_cost FROM calculator_shipping 
        WHERE location_type = ? AND min_total <= ? AND (max_total IS NULL OR max_total >= ?) AND is_active = 1
        ORDER BY min_total DESC LIMIT 1
    ");
    $stmt->execute([$locationType, $total, $total]);
    $result = $stmt->fetch();
    return $result ? (float)$result['shipping_cost'] : 0;
}

// Get additional costs
function getAdditionalCosts()
{
    $db = getDB();
    $stmt = $db->query("SELECT * FROM calculator_additional_costs WHERE is_active = 1");
    return $stmt->fetchAll();
}

// Calculate estimate
function calculateEstimate($data)
{
    $productId = (int)$data['product_id'];
    $materialId = (int)$data['material_id'];
    $modelId = (int)$data['model_id'];
    $locationType = $data['location_type'];
    $length = (float)$data['length'];
    $additionalCostIds = $data['additional_costs'] ?? [];
    $includeShipping = $data['include_shipping'] ?? true;

    // Get price per meter
    $pricePerMeter = getPrice($productId, $materialId, $modelId, $locationType);
    if (!$pricePerMeter) {
        return ['error' => 'Harga tidak ditemukan untuk kombinasi ini'];
    }

    // Calculate subtotal
    $subtotal = $pricePerMeter * $length;

    // Calculate shipping
    $shippingCost = $includeShipping ? getShippingCost($subtotal, $locationType) : 0;

    // Calculate additional costs
    $additionalTotal = 0;
    $additionalDetails = [];
    if (!empty($additionalCostIds)) {
        $db = getDB();
        $placeholders = implode(',', array_fill(0, count($additionalCostIds), '?'));
        $stmt = $db->prepare("SELECT * FROM calculator_additional_costs WHERE id IN ($placeholders) AND is_active = 1");
        $stmt->execute($additionalCostIds);
        $additionalCostsData = $stmt->fetchAll();

        foreach ($additionalCostsData as $cost) {
            $costAmount = $cost['cost_type'] === 'percentage'
                ? ($subtotal * $cost['cost_value'] / 100)
                : $cost['cost_value'];
            $additionalTotal += $costAmount;
            $additionalDetails[] = [
                'name' => $cost['name'],
                'amount' => $costAmount
            ];
        }
    }

    // Grand total
    $grandTotal = $subtotal + $shippingCost + $additionalTotal;

    // Calculate range (±10%)
    $minTotal = $grandTotal * 0.9;
    $maxTotal = $grandTotal * 1.1;

    // Determine badge
    $badge = 'Best Value';
    if ($pricePerMeter <= 2500000) {
        $badge = 'Ekonomis';
    } elseif ($pricePerMeter >= 4500000) {
        $badge = 'Premium';
    }

    // Get product, material, model names
    $db = getDB();
    $productStmt = $db->prepare("SELECT name FROM calculator_products WHERE id = ?");
    $productStmt->execute([$productId]);
    $productName = $productStmt->fetch()['name'] ?? '';

    $materialStmt = $db->prepare("SELECT name FROM calculator_materials WHERE id = ?");
    $materialStmt->execute([$materialId]);
    $materialName = $materialStmt->fetch()['name'] ?? '';

    $modelStmt = $db->prepare("SELECT name FROM calculator_models WHERE id = ?");
    $modelStmt->execute([$modelId]);
    $modelName = $modelStmt->fetch()['name'] ?? '';

    return [
        'success' => true,
        'data' => [
            'location_type' => $locationType,
            'location_label' => $locationType === 'dalam_kota' ? 'Dalam Kota (Jawa Timur)' : 'Luar Kota (Jabodetabek, Pantura, Jateng)',
            'product' => $productName,
            'material' => $materialName,
            'model' => $modelName,
            'length' => $length,
            'price_per_meter' => $pricePerMeter,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'shipping_label' => $shippingCost == 0 ? 'Gratis' : 'Rp ' . number_format($shippingCost, 0, ',', '.'),
            'additional_costs' => $additionalTotal,
            'additional_details' => $additionalDetails,
            'grand_total' => $grandTotal,
            'min_total' => $minTotal,
            'max_total' => $maxTotal,
            'badge' => $badge,
            'summary' => sprintf(
                'Estimasi biaya %s %s %s sepanjang %.1f meter di wilayah %s adalah sekitar Rp %s – Rp %s %s.',
                $productName,
                $materialName,
                $modelName,
                $length,
                $locationType === 'dalam_kota' ? 'Dalam Kota' : 'Luar Kota',
                number_format($minTotal, 0, ',', '.'),
                number_format($maxTotal, 0, ',', '.'),
                $shippingCost > 0 ? 'belum termasuk ongkir' : 'termasuk ongkir gratis'
            )
        ]
    ];
}

// Save estimate to database
function saveEstimate($data, $estimateData)
{
    $db = getDB();
    $code = 'EST-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

    $stmt = $db->prepare("
        INSERT INTO calculator_estimates 
        (estimate_code, customer_name, customer_phone, customer_email, location_type, 
         product_id, material_id, model_id, length_meter, price_per_meter, 
         subtotal, shipping_cost, additional_costs, grand_total, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $code,
        $data['customer_name'] ?? null,
        $data['customer_phone'] ?? null,
        $data['customer_email'] ?? null,
        $data['location_type'],
        $data['product_id'],
        $data['material_id'],
        $data['model_id'],
        $data['length'],
        $estimateData['data']['price_per_meter'],
        $estimateData['data']['subtotal'],
        $estimateData['data']['shipping_cost'],
        $estimateData['data']['additional_costs'],
        $estimateData['data']['grand_total'],
        $data['notes'] ?? null
    ]);

    return $code;
}

// Check materials availability for product
function getAvailableMaterialsForProduct($productId)
{
    $db = getDB();
    $stmt = $db->prepare("
        SELECT DISTINCT m.* FROM calculator_materials m
        INNER JOIN calculator_prices p ON m.id = p.material_id
        WHERE p.product_id = ? AND p.is_active = 1 AND m.is_active = 1
        ORDER BY m.display_order
    ");
    $stmt->execute([$productId]);
    return $stmt->fetchAll();
}

// Handle API requests
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Initialize tables on first request
initCalculatorTables();

switch ($action) {
    case 'init':
        echo json_encode([
            'success' => true,
            'data' => [
                'products' => getProducts(),
                'materials' => getMaterials(),
                'models' => getModels(),
                'additional_costs' => getAdditionalCosts()
            ]
        ]);
        break;

    case 'get_materials':
        $productId = $_GET['product_id'] ?? null;
        echo json_encode([
            'success' => true,
            'data' => getAvailableMaterialsForProduct($productId)
        ]);
        break;

    case 'get_price':
        $pricePerMeter = getPrice(
            $_GET['product_id'],
            $_GET['material_id'],
            $_GET['model_id'],
            $_GET['location_type']
        );
        echo json_encode([
            'success' => true,
            'price_per_meter' => $pricePerMeter
        ]);
        break;

    case 'calculate':
        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $result = calculateEstimate($input);
        echo json_encode($result);
        break;

    case 'save':
        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $estimateData = calculateEstimate($input);
        if (isset($estimateData['error'])) {
            echo json_encode($estimateData);
        } else {
            $code = saveEstimate($input, $estimateData);
            $estimateData['data']['estimate_code'] = $code;
            echo json_encode($estimateData);
        }
        break;

    default:
        echo json_encode([
            'success' => false,
            'error' => 'Invalid action'
        ]);
}
