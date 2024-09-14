<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="root @if (app()->isLocale('ar')) rtl @endif">

<head>
    <meta charset="utf-8" />
    <title>{{ $offer->offer_number }}</title>

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
                                {{__('translate.commercialRegister')}}: 4030443947<br />
                                {{__('translate.taxNumber')}}: 31073774550003<br />
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
                                {{__('translate.companyName')}}: {{ $user->name }}<br />
                                {{__('translate.tax')}}: {{ $user->tax_number }}<br />
                                {{__('translate.address')}}: {{ $user->address }}<br />
                                @else
                                {{__('translate.name')}}: {{ $user->name }}<br />
                                @endif
                                {{__('translate.requestID')}}: SS{{ $request_id }}<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- ---------------------------Spare Part Table--------------------------- -->
            <tr class="heading">
                <td>{{__('translate.description')}}</td>
                <td>{{__('translate.price')}}</td>
                <td>{{__('translate.sale')}}</td>
                <td>{{__('translate.quantity')}}</td>
                <td>{{__('translate.total')}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            @foreach ($requests as $car)
            <tr class="heading">
                <td colspan="1">{{__('translate.factory').'-'.$car->factory }}</td>
                <td colspan="1">{{$car->km.'-'.__('translate.km')}}</td>
                <td colspan="1">{{__('translate.place').'-'.$car->place }}</td>
                <td colspan="2">{{__('translate.plate').'-'.$car->plate }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            @foreach($car->offer_details as $detials)
            <tr class="item">
                <td>{{ $detials->description }}</td>
                <td>{{ $detials->price }}</td>
                <td>{{ $detials->sale }}</td>
                <td>{{ $detials->quantity }}</td>
                <td>{{ ($detials->price * $detials->quantity) * (1 - $detials->sale / 100) }}</td>
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
                <td>{{__('translate.price')}}</td>
                <td style="color: red;">{{__('translate.sale')}}</td>
                <td>{{__('translate.price')}}</td>
                <td style="direction: ltr;">VAT(15%)</td>
                <td>{{__('translate.totalPrice')}}</td>
            </tr>
            <tr class="item">
                <td>{{ $offer->price_before_sale }}</td>
                <td>{{ $offer->sale }}</td>
                <td>{{ $offer->price_after_sale }}</td>
                <td>{{ $offer->vat }}</td>
                <td>{{ $offer->price_after_sale + $offer->vat }}</td>
            </tr>
        </table>
    </div>
</body>

</html>