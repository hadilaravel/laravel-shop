<?php

namespace App\Http\Services\payment;

use App\Models\Market\OnlinePayment;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Config;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentService
{


    public function zarinpal( $order , $onlinePayment )
    {
        $invoice = new Invoice();
        $invoice->amount((int)$order->order_final_amount);
        $invoice->detail(['title' => 'فروشگاه آمازون' , 'description' => 'ممنون که از فروشگاه ما خرید میکنید']);
        $callBackRoute = route('customer.sales-process.payment-call-back' , [$order , $onlinePayment]);

        $payment = Payment::callbackUrl($callBackRoute)->purchase($invoice , function ($driver, $transactionId) use ($onlinePayment){
            $onlinePayment->update([
                'gateway' => "زرین پال",
                'transaction_id' => $transactionId,
            ]);
        });
        return $payment->pay()->getAction();
    }



    public function zarinpalVerify($amount, $onlinePayment)
    {

        try {
            $receipt = Payment::amount($amount)->transactionId($onlinePayment->transaction_id)->verify();

            $data = [
                'referenceId' => $receipt->getReferenceId(),
                'driver' => $receipt->getDriver(),
                'date' => $receipt->getDate()->toDayDateTimeString(),
            ];

            return $data;

        }catch (InvalidPaymentException $exception){
            return $exception->getMessage();
        }

    }





    function resultCodes($code)
    {
        switch ($code) {
            case 100:
                return "با موفقیت تایید شد";

            case 102:
                return "merchant یافت نشد";

            case 103:
                return "merchant غیرفعال";

            case 104:
                return "merchant نامعتبر";

            case 201:
                return "قبلا تایید شده";

            case 105:
                return "amount بایستی بزرگتر از 1,000 ریال باشد";

            case 106:
                return "callbackUrl نامعتبر می‌باشد. (شروع با http و یا https)";

            case 113:
                return "amount مبلغ تراکنش از سقف میزان تراکنش بیشتر است.";

            case 201:
                return "قبلا تایید شده";

            case 202:
                return "سفارش پرداخت نشده یا ناموفق بوده است";

            case 203:
                return "trackId نامعتبر می‌باشد";

            default:
                return "وضعیت مشخص شده معتبر نیست";
        }
    }

    /**
     * returns a string message based on status parameter from $_GET
     * @param $code
     * @return String
     */
    function statusCodes($code)
    {
        switch ($code) {
            case -1:
                return "در انتظار پردخت";

            case -2:
                return "خطای داخلی";

            case 1:
                return "پرداخت شده - تاییدشده";

            case 2:
                return "پرداخت شده - تاییدنشده";

            case 3:
                return "لغوشده توسط کاربر";

            case 4:
                return "‌شماره کارت نامعتبر می‌باشد";

            case 5:
                return "‌موجودی حساب کافی نمی‌باشد";

            case 6:
                return "رمز واردشده اشتباه می‌باشد";

            case 7:
                return "‌تعداد درخواست‌ها بیش از حد مجاز می‌باشد";

            case 8:
                return "‌تعداد پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد";

            case 9:
                return "مبلغ پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد";

            case 10:
                return "‌صادرکننده‌ی کارت نامعتبر می‌باشد";

            case 11:
                return "خطای سوییچ";

            case 12:
                return "کارت قابل دسترسی نمی‌باشد";

            default:
                return "وضعیت مشخص شده معتبر نیست";
        }
    }

}
