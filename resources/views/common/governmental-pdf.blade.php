<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="root @if (app()->isLocale('ar')) rtl @endif">

<head>
    <meta charset="utf-8" />
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
            background-color: #3e4148;
            padding: 10px;
            color: white;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border: 1px solid gray;
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
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="5">
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
                                @php
                                use Carbon\Carbon;
                                $locale = App::getLocale(); // Get the current locale
                                Carbon::setLocale($locale); // Set locale for Carbon

                                $date = Carbon::now(); // Get the current date and time
                                @endphp

                                <strong>{{__('translate.date')}}:</strong> {{ $date->translatedFormat('l, F,  Y')}}<br />
                                <strong>{{__('translate.time')}}:</strong> {{ $date->translatedFormat('g:i A')}}<br />
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="text-align: start;">
                                <strong> {{__('translate.commercialRegister')}}: </strong>4030443947<br />
                                <strong> {{__('translate.taxNumber')}}: </strong>31073774550003<br />
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
                            <td class="head">
                                @if($user->type == 'Company')
                                <strong> {{__('translate.companyName')}}: </strong>{{ $user->name }}<br />
                                <strong> {{__('translate.tax')}}: </strong>{{ $user->tax_number }}<br />
                                @else
                                <strong> {{__('translate.name')}}: </strong>{{ $user->name }}<br />
                                @endif
                                <strong> {{__('translate.address')}}: </strong>{{ $user->address }}<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- ---------------------------Spare Part Table--------------------------- -->
            <tr class="heading">
                <td>{{__('translate.carType')}}</td>
                <td>{{__('translate.carModel')}}</td>
                <td>{{__('translate.plateLatters')}}</td>
                <td>{{__('translate.plateNumbers')}}</td>
                <td>{{__('translate.affiliatedCenter')}}</td>
            </tr>
            @foreach ($requests as $request)
            @foreach($request->request_details as $car)
            <tr class="item">
                <td colspan="1">{{$car->factory }}</td>
                <td colspan="1">{{$car->model_year }}</td>
                <td colspan="1">{{$car->plate }}</td>
                <td colspan="1">{{$car->plate }}</td>
                <td colspan="1">{{$car->place }}</td>
            </tr>
            @endforeach
            @endforeach
        </table>
        <br>
        <span>{{__('translate.pdfTitle')}}</span><br>
        <br>
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>{{__('translate.sequence')}}</td>
                <td>{{__('translate.services_maintenance')}}</td>
                <td>{{__('translate.remarks')}}</td>
                <td>{{__('translate.quantity')}}</td>
                <td>{{__('translate.unit')}}</td>
            </tr>
            @foreach ($requests as $request)
                @foreach($request->request_details as $index => $offer)
                    @foreach($offer->offer_details as $details)
                    <tr class="item">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $details->description }}</td>
                        <td>{{__('translate.remarks')}}</td>
                        <td>{{ $details->quantity }}</td>
                        <td>{{__('translate.unit')}}</td>
                    </tr>
                    @endforeach
                @endforeach
            @endforeach
        </table>
        <br>
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>{{__('translate.name')}}</td>
                <td>{{__('translate.vehicleReceiptCenter')}}</td>
                <td>{{__('translate.phoneNumber')}}</td>
            </tr>
            <tr class="item">
                <td>........................................................</td>
                <td>........................................................</td>
                <td>........................................................</td>
            </tr>
        </table>
        <br>
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td colspan="4">{{__('translate.technicalMembers')}}</td>
            </tr>
            <tr class="item">
                <td>{{__('translate.name')}}</td>
                <td>............................</< /td>
                <td>{{__('translate.signature')}}</td>
                <td>............................</< /td>
            </tr>
        </table>
        <br>
        <table cellpadding="0" cellspacing="0" style="text-align: start;">
            <tr>
                <td><strong>{{__('translate.accreditationApproval')}}</strong></td>
            </tr>
            <tr>
                <td>{{__('translate.name')}} ................................................................................................................</td>
            </tr>
            <tr>
                <td>{{__('translate.signature')}} .........................................................................................................</td>
            </tr>
        </table>
    </div>
</body>

</html>