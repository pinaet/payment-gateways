<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Harrow Asia Limited</title>
    <style type="text/css">
        body{
            font-family: \'Helvetica Neue\',sans-serif;
            font-size: 17px;
            color:#222222;
        }
        td.left {
            width: 30%;
        }
        td.right {
            width: 70%;
        }
        .left-col {
            background-color:#001844; color:#a39163; padding-left:10px;
        }
        .right-col {
            background-color:#FDF8EF; color:#000000; padding-left:10px;
        }
    </style>
</head>
<body>
    <table id="bank" width="700" align="center" style="margin-top: 30px">
        <tr>
            <td colspan="2">
            <br/>
                Dear {{ $order['customer_name'] }},<br><br>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr width="700px"></td>
        </tr>
        <tr>
            <td colsapn="2">
                <h3>Payment Successful</h3>
            </td>
        </tr>
        <tr height="5px">
            <td class="left"><span class="style6"></span></td>
            <td class="right"><span class="style6"></span></td>
        </tr>
        <tr>
            <td class="left-col" style="background-color:#001844; color:#a39163; padding-left:10px;">Product</td>
            <td colsapn="3" class="right-col" style="background-color:#FDF8EF; color:#000000; padding-left:10px;">{{ $order['description'] }}</td>
        </tr>
        <tr>
            <td class="left-col" style="background-color:#001844; color:#a39163; padding-left:10px;">Amount Paid</td>
            <td colsapn="3" class="right-col" style="background-color:#FDF8EF; color:#000000; padding-left:10px;">{{ number_format((float)$order['total_amount'], 2, '.', ',') . ' ' . $order['currency'] }}</td>
        </tr>
        <tr>
            <td class="left-col" style="background-color:#001844; color:#a39163; padding-left:10px;">Invoice Number</td>
            <td colsapn="3" class="right-col" style="background-color:#FDF8EF; color:#000000; padding-left:10px;">{{ $order['reference_order'] }}</td>
        </tr>
        <tr>
            <td class="left-col" style="background-color:#001844; color:#a39163; padding-left:10px;">Student Code</td>
            <td colsapn="3" class="right-col" style="background-color:#FDF8EF; color:#000000; padding-left:10px;">{{ $order['ref3'] }}</td>
        </tr>
        <tr>
            <td class="left-col" style="background-color:#001844; color:#a39163; padding-left:10px;">Payment Method</td>
            <td colsapn="3" class="right-col" style="background-color:#FDF8EF; color:#000000; padding-left:10px;">
                @if( empty($order['source']) )
                    {{ $sourceType['name'] }}
                @else
                    {{ $sourceType['name'] . ' (**** **** **** ' . $order['source'] .')' }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="left-col" style="background-color:#001844; color:#a39163; padding-left:10px;">Payment ID</td>
            <td colsapn="3" class="right-col" style="background-color:#FDF8EF; color:#000000; padding-left:10px;">{{ $order['transaction_id'] }}</td>
        </tr>
        <tr>
            <td class="left-col" style="background-color:#001844; color:#a39163; padding-left:10px;">Payment Date</td>
            <td colsapn="3" class="right-col" style="background-color:#FDF8EF; color:#000000; padding-left:10px;">{{ $order['updated_at'] . ' ' . $timezone }}</td>
        </tr>
        <tr height="5px">
            <td><span class="style6"></span></td>
            <td><span class="style6"></span></td>
        </tr>
        <tr>
            <td colspan="2">
            <br/>
                <b>Thank you for using Harrow International School Bangkok Online Payment.</b><br/>
                <b>School will send you a receipt by mail.</b><br/>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr width="700px"></td>
        </tr>
        <tr>
            <td colspan="2">
            <br/>
                Kind regards,<br/><br/>
                Finance Team<br/>
                Harrow International School Bangkok<br/><br/>
            </td>
        </tr>
    </table>
</body>
</html>