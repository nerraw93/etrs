
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
    <link href="{{ url('css/pdf.css') }}" type="text/css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h2 class="column has-text-centered mb-lg">SEND OUT ORDER</h2>
        <table class="is-full column mb-lg">
            <tr>
                <td class="has-text-left">
                    <img src="{{url($barcode)}}" alt="barcode"   />
                    <br>
                    <strong>BATCH NO: </strong>
                    {{$batch->id}}
                </td>
                <td class="has-text-right">
                    <strong>DATE:</strong>
                    {{date("M. d, Y h:i A", strtotime($batch->created_at))}}
                </td>
            </tr>
            <tr>
                <td class="has-text-left">
                </td>
                <td class="has-text-right">
                    <strong>SOURCE:</strong>
                    {{optional($batch->source)->name}}
                </td>
            </tr>
        </table>

        <div class="hr"></div>

        <h4 class="column has-text-left mb-lg"><strong>ORDER ITEMS</strong></h4>

        <table class="is-full column">
            <tr>
                <td class="has-text-left">Lab no.</td>
                <td class="has-text-left">Patient Name</td>
                <td class="has-text-left">Payment Mode</td>
                <td class="has-text-left">Gender</td>
                <td class="has-text-left">Birthdate</td>
                <td class="has-text-left">Total Cost</td>
            </tr>
        </table>

        <div class="hr dotted"></div>
        <?php $grand_total = 0; ?>
        <table class="is-full column">
            @foreach ($batch->orders as $order)
                <?php $total_cost = 0; ?>
                @foreach ($order->services as $order_service)
                    <?php $total_cost += $order_service->service->price; ?>
                @endforeach
                <tr>
                    <td class="has-text-left">{{$order->id}}</td>
                    <td class="has-text-left">{{optional($order->patient)->first_name . ' ' . optional($order->patient)->last_name}}</td>
                    <td class="has-text-left">{{$batch->payment_mode == 1 ? 'Charge' : 'Cash'}}</td>
                    <td class="has-text-left">{{optional($order->patient)->gender}}</td>
                    <td class="has-text-left">{{$order->patient ? date('m/d/Y', strtotime($order->patient->birth_date)) : ''}}</td>
                    <td class="has-text-left">{{number_format($total_cost, 2, '.', ',')}}</td>
                </tr>

                @foreach ($order->services as $order_service)
                    <tr>
                        <td class="has-text-left"><strong>Tests</strong></td>
                        <td class="has-text-left">{{ optional($order_service->service)->name }}</td>
                        <td class="has-text-left"><strong>OR/PR No.</strong></td>
                    </tr>
                @endforeach

                <?php $grand_total += $total_cost; ?>
            @endforeach
        </table>

        <div class="hr dotted"></div>
        <h4 class="column has-text-left mb-lg"><strong>BREAKDOWN:</strong></h4>
        <table class="is-full column">
            <tr>
                <td class="has-text-left" width="250">TOTAL ORDER COUNT: <strong style="font-size:18px">{{ count($batch->orders) }}</strong></td>
                <td class="has-text-left">Slides: {{$batch->slides}}</td>
                <td class="has-text-right">
                    <strong style="font-size:20px">
                        Grand Total: 
                        <br>
                        P {{number_format($grand_total, 2, '.', ',')}}
                    </strong>
                </td>
            </tr>
            <tr>
                <td class="has-text-left">Encoded by: {{$batch->encoded_by}}</td>
                <td class="has-text-left">Blood: {{$batch->blood}}</td>
                <td class="has-text-right"></td>
            </tr>
            <tr>
                <td class="has-text-left">Prepared by: {{$batch->client != null ? $batch->client->full_name : ''}}</td>
                <td class="has-text-left">Forms: {{$batch->forms}}</td>
                <td class="has-text-right"></td>
            </tr>
            <tr>
                <td class="has-text-left">TESTING</td>
                <td class="has-text-left">Specimens: {{$batch->specimen}}</td>
                <td class="has-text-right"></td>
            </tr>
        </table>
    </div>
</body>
</html>
