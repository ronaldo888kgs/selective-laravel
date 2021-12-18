<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fields</title>
        <style>
            #emp{
                font-family:Arial, Helvetica, sans-serif;
                font-size:12px;
                border-collapse: collapse;
                width:100%;
            }
            #emp td, #emp th{
                border: 1px solid #ddd;
                padding:8px;
            }
            #emp tr:nth-child(even){
                background-color:#0bfdfd;
            }
            #emp th{
                padding-top:12px;
                padding-bottom:12px;
                text-align: left;
                background-color:#4CAF50;
                color:#fff;
            }
            #emp2{
                font-family:Arial, Helvetica, sans-serif;
                font-size:12px;
                border:none;
                border-collapse: unset;
            }
            #emp2 td, #emp2 th{
                border: none;
                padding:8px;
            }
            #emp2 tr:nth-child(even){
                background-color:#0bfdfd;
            }
            #emp2 th{
                padding-top:12px;
                padding-bottom:12px;
                text-align: left;
                background-color:#4CAF50;
                color:#fff;
            }
        </style>
    </head>
    <body>
        <?php $i = 0; ?>
        <table id="emp2">
            <tbody>
                <tr>
                    <td>Search By : </td>
                    <td><b>DateType :</b></td>
                    <td >{{ $filters->datetype }}</td>
                    @if ($filters->datetype != 'all')
                        <td >From</td>
                        <td >{{ $filters->startdate }}</td>
                        <td >To</td>
                        <td >{{ $filters->startdate }}</td>
                    @endif
                    <td>&nbsp;</td>
                    <td ><b>Keywords :</b></td>
                    <td >{{ $filters->keyword }}</td>
                    @if ($filters->keyword != 'all')
                        <td >{{ $filters->keyword }}</td>
                        <td >{{ $filters->value }}</td>
                    @endif
                </tr>
            </tbody>
        </table>
        <table id="emp" > 
            <thead >
                <tr>
                    <th>S.NO</th>
                    <th>Posted Date</th>
                    <th>Buy Date</th>
                    <th>Symbol</th>
                    <th>Qty</th>
                    <th>Expiration Date</th>
                    <th>Sell Date</th>
                    <th>Tracker</th>
                    <th>Call or Put or Strategy</th>
                    <th>Strike </th>
                    <th>Strike Price</th>
                    <th>Stoploss</th>
                    <th>Out Price</th>
                    <th>Net Difference</th> 
                    <th>High Price</th> 
                    <th>% Net Profit or Loss</th>
                    <th>Status</th>
                    <th>Category</th>
                </tr>
                
            </thead>
            <tbody style="width:100%">
                @foreach ($fields as $field)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$field->posted_date}}</td>
                    <td>{{$field->buy_date}}</td>
                    <td>{{$field->symbol}}</td>
                    <td>{{$field->qty}}</td>
                    <td>{{$field->expiration_date}}</td>
                    <td>{{$field->sell_date}}</td>
                    <td>{{$field->tracker}}</td>
                    <td>{{$field->call_put_strategy}}</td>
                    <td>{{$field->strike}} </td>
                    <td>{{$field->strike_price}}</td>
                    <td>{{$field->in_price}}</td>
                    <td>{{$field->out_price}}</td>
                    <td>{{$field->net_difference}}</td>
                    <td>{{$field->high_price}}</td>
                    <td>{{$field->percentage}}</td>
                    <td>
                        @if ($field->status == 1)
                            OPEN
                        @endif
                        @if ($field->status == 0)
                            CLOSED
                        @endif
                        @if ($field->status == 2)
                            STOPLOSS HIT
                        @endif
                    </td>
                    <td>{{$category_name}}</td>
                @endforeach
                </tr>
            </tbody>
        </table>
    </body>
</html>