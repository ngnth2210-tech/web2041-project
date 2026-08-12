<?php

class MomoPayment
{
    /**
     * Tạo request thanh toán MoMo, trả về URL redirect.
     *
     * @param  int    $orderId     ID đơn hàng trong DB
     * @param  int    $amount      Số tiền (VNĐ, nguyên)
     * @param  string $orderInfo   Mô tả đơn hàng
     * @return string              URL thanh toán MoMo
     */
    public static function createPayment(int $orderId, int $amount, string $orderInfo = ''): string
    {
        $partnerCode = MOMO_PARTNER_CODE;
        $accessKey   = MOMO_ACCESS_KEY;
        $secretKey   = MOMO_SECRET_KEY;
        $requestId   = $partnerCode . time() . '_' . $orderId;
        $requestType = 'payWithMethod';
        $extraData   = base64_encode(json_encode(['order_id' => $orderId]));
        $autoCapture = true;
        $lang        = 'vi';
        $orderInfo   = $orderInfo ?: "Thanh toán đơn hàng #$orderId tại FoodShop";

        // Chuỗi ký theo đúng thứ tự MoMo quy định
        $rawHash = "accessKey=$accessKey"
            . "&amount=$amount"
            . "&extraData=$extraData"
            . "&ipnUrl=" . MOMO_NOTIFY_URL
            . "&orderId=$requestId"
            . "&orderInfo=$orderInfo"
            . "&partnerCode=$partnerCode"
            . "&redirectUrl=" . MOMO_RETURN_URL
            . "&requestId=$requestId"
            . "&requestType=$requestType";

        $signature = hash_hmac('sha256', $rawHash, $secretKey);

        $body = json_encode([
            'partnerCode' => $partnerCode,
            'partnerName' => 'FoodShop',
            'storeId'     => 'FoodShop01',
            'requestId'   => $requestId,
            'amount'      => $amount,
            'orderId'     => $requestId,
            'orderInfo'   => $orderInfo,
            'redirectUrl' => MOMO_RETURN_URL,
            'ipnUrl'      => MOMO_NOTIFY_URL,
            'lang'        => $lang,
            'requestType' => $requestType,
            'autoCapture' => $autoCapture,
            'extraData'   => $extraData,
            'signature'   => $signature,
        ]);

        $ch = curl_init(MOMO_ENDPOINT);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => false, // sandbox
        ]);
         $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!empty($result['payUrl'])) {
            return $result['payUrl'];
        }

        // Nếu MoMo trả lỗi
        $msg = $result['message'] ?? 'Kết nối MoMo thất bại.';
        throw new Exception("MoMo: $msg (code: " . ($result['resultCode'] ?? '?') . ")");
    }

    /**
     * Xác minh chữ ký callback từ MoMo.
     */
    public static function verifySignature(array $params): bool
    {
        $secretKey = MOMO_SECRET_KEY;
        $accessKey = MOMO_ACCESS_KEY;

        $rawHash = "accessKey=$accessKey"
            . "&amount={$params['amount']}"
            . "&extraData={$params['extraData']}"
            . "&message={$params['message']}"
            . "&orderId={$params['orderId']}"
            . "&orderInfo={$params['orderInfo']}"
            . "&orderType={$params['orderType']}"
            . "&partnerCode={$params['partnerCode']}"
            . "&payType={$params['payType']}"
            . "&requestId={$params['requestId']}"
            . "&responseTime={$params['responseTime']}"
            . "&resultCode={$params['resultCode']}"
            . "&transId={$params['transId']}";

        $expected = hash_hmac('sha256', $rawHash, $secretKey);
        return hash_equals($expected, $params['signature'] ?? '');
    }

    /**
     * Lấy order_id gốc từ orderId MoMo (format: MOMO{timestamp}_{orderId})
     */
    public static function extractOrderId(string $momoOrderId): ?int
    {
        // Format: MOMO1234567890_42  → 42
        if (preg_match('/_(\d+)$/', $momoOrderId, $m)) {
            return (int) $m[1];
        }
        return null;
    }
}
