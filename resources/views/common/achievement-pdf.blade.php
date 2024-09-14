<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="root @if (app()->isLocale('ar')) rtl @endif">

<head>
    <meta charset="utf-8" />
    <title></title>

    @if (app()->getLocale() == 'en')
    <style>
        .invoice-box {
            direction: ltr;
        }

        .invoice-box table tr.heading td {
            font-weight: bold;
        }

        .head {
            text-align: left;
        }

        .headLeft {
            text-align: right;
        }
    </style>

    @elseif(app()->getLocale() == 'ar')
    <style>
        .invoice-box {
            direction: rtl;
        }

        .invoice-box.rtl {
            direction: rtl;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box .companyInfo {
            display: inline-block !important;
        }

        .invoice-box table tr.heading td {
            font-weight: lighter;
        }

        .head {
            text-align: right;
        }

        .headLeft {
            text-align: left;
        }
    </style>
    @endif

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid rgb(214, 214, 214);
            border-radius: 10px;
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: center;
        }


        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background-color: #f5f5f5;
            border-bottom: 1px solid #f5f5f5;
            padding: 10px;
            color: #333;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(even) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        .info {
            text-align: left;
        }

        hr {
            width: 100% !important;
            height: 1px;
            background-color: red;
        }


        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="6">
                    <table>
                        <tr>
                            <td>
                                <img src="Images/Logos/Logo.png" style="width: 100%; max-width: 85px; margin: 5px 0;" />
                            </td>
                            <td style="line-height: 23px;" class="head" style="text-align: end;">
                                <h4>
                                    The Saudi Green <br>
                                    Car Services
                                </h4>
                                +0570203360-0556556067
                                <br>
                                info@thesgreen.com
                            </td>

                            <td class="headLeft" style="line-height: 23px;">
                                {{__('translate.date')}}: {{now()->format('D-d/m/y')}}<br />
                                {{__('translate.time')}}: {{now()->format('h:i A')}}<br />
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="text-align: start;">
                                {{__('translate.commercialRegister')}}: 4030443947<br />
                                {{__('translate.tax')}}: 31073774550003<br />
                            </td>
                        </tr>
                    </table>
                    <hr>
                </td>
            </tr>
            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            @if($user->type == 'Company')
                            <td class="head">
                                {{__('translate.companyName')}}: {{ $user->name }}<br />
                                {{__('translate.tax')}}: {{ $user->tax_number }}<br />
                                {{__('translate.address')}}: {{ $user->address }}<br />
                            </td>
                            @else
                            <td class="head">
                                {{__('translate.name')}}: {{ $user->name }}<br />
                            </td>
                            @endif
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- ---------------------------Spare Part Table--------------------------- -->
            <tr class="heading">
                <td>{{__('translate.factory')}}</td>
                <td>{{__('translate.modelYear')}}</td>
                <td>{{__('translate.plate')}}</td>
                <td>{{__('translate.vin')}}</td>
                <td>{{__('translate.km')}}</td>
                <td>{{__('translate.place')}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            @foreach ($requests as $request)
            <tr class="heading">
                <td colspan="2">{{__('translate.requestID')}}</td>
                <td colspan="1">{{__('translate.noCars')}}</td>
                <td colspan="1">{{__('translate.date')}}</td>
                <td colspan="2">{{__('translate.totalPrice')}}</td>
            </tr>

            <tr class="item" style="background-color: #eee;">
                <td colspan="2">{{ $request->id }}</td>
                <td colspan="1">{{ count($request->request_details) }}</td>
                <td colspan="1">{{ $request->created_at->format('D - d/m/y') }}</td>
                <td colspan="2">{{ $request->total_price->total_price}}</td>
            </tr>
            @foreach($request->request_details as $detials)
            <tr class="item">
                <td>{{ $detials->factory }}</td>
                <td>{{ $detials->model_year }}</td>
                <td>{{ $detials->plate }}</td>
                <td>{{ $detials->vin }}</td>
                <td>{{ $detials->km }}</td>
                <td>{{ $detials->place}}</td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </table>
        <br>
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td style="color: red;">{{__('translate.price')}}</td>
                <td>{{__('translate.numberOfCars')}}</td>
            </tr>
            <tr class="item">
                <td>{{ $totalPrice }}</td>
                <td>{{ $cars }}</td>
            </tr>
        </table>
    </div>
</body>

</html>