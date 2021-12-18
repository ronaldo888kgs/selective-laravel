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
        <table id="emp" > 
            <thead >
                <tr>
                    <th>S.NO</th>
                    <th>Stock Name</th>
                    <th>Stock Price</th>
                    <th>ER Date</th>
                    <th>ER Type</th>
                    <th>Price Before</th>
                    <th>Price After</th>
                    <th>% Change</th>
                </tr>
                
            </thead>
            <tbody style="width:100%">
                @foreach ($er_datas as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->stock_name }}</td>
                    <td>{{ $data->stock_price }}</td>
                    <td>{{ $data->er_date }}</td>
                    <td>
                        @if ($data->er_type == 1)
                        Very Good
                        @endif
                        @if ($data->er_type == 2)
                        Bad
                        @endif
                        @if ($data->er_type == 3)
                        Very Bad 
                        @endif
                    </td>
                    <td>{{ $data->price_before }}</td>
                    <td>{{ $data->price_after }}</td>
                    <td>
                        @if ($data->price_before > 0)
                        {{ round(($data->price_after * 100) / $data->price_before - 100, 2) }}    
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>