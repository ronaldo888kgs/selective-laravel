<?php 
$i = 0
?>
<div>
    <table class="table  table-bordered table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
        <thead class="table-light">
            <th>No</th>
            <th style="width:110px">Posted Date</th>
            <th style="width:110px">Buy Date</th>
            <th>Symbol</th>
            <th style="width:80px">Qty</th>
            <th style="width:110px">Expiration Date</th>
            <th style="width:110px">Sell Date</th>
            <th>
                <div>
                    Call
                </div>
                <div>
                    Put
                </div>
                <div>
                    Strategy
                </div>
            </th>
            <th>Strike </th>
            <th>Strike Price</th>
            
            <th>Stoploss</th>
            <th>Out Price</th>
            <th>Net Difference</th> 
            <th>% Change</th> 
            <th>
                <div>
                    Live Option Price
                </div>
            </th>
            <th>stock price</th>
            <th>% Net Profit or Loss</th>
            <th>Status</th>
        </thead>
        <tbody>
            @foreach ($fields as $field)
            <tr name="tr-record">
                <td>{{(++$i) + ($fields->currentPage() - 1) * 150}}</td>
                <td>{{$field->posted_date}}</td>
                <td>{{$field->buy_date}}</td>
                <td>
                    <b>{{$field->symbol}}</b>
                    <input type="hidden" name="hidden_symbols" value="{{$field->symbol}}">
                </td>
                <td >
                    @if ($field->qty >= 100)
                        {{ $field->qty/100 }} Lot
                    @else
                        {{$field->qty}}    
                    @endif
                    
                </td>
                <td>
                    {{$field->expiration_date}}
                    <input type="hidden" name="hidden_expirations" value="{{$field->expiration_date}}">
                </td>
                <td>{{$field->sell_date}}</td>
                <td>
                    {{$field->call_put_strategy}}
                    <input type="hidden" name="hidden_call_put_strategy" value="{{$field->call_put_strategy}}">
                </td>
                <td>
                    {{$field->strike}} 
                    <input type="hidden" name="hidden_strikes" value="{{$field->strike}}">
                </td>
                <td>
                    {{$field->strike_price}}
                    <input type="hidden" name="hidden_strikes_price" value="{{$field->strike_price}}">
                </td>
                
                <td>{{$field->in_price}}</td>
                <td>{{$field->out_price}}</td>
                <td>{{$field->net_difference}}</td>
                <td>
                    <span name="td_high_price">{{$field->high_price}}</span>
                </td>
                <td name="live_option_prices"></td>
                <td name="stock_prices"></td>
                @if (!is_numeric($field->percentage))
                        <td >{{$field->percentage}}</td>    
                    @else
                        @if (intval($field->percentage) >= 80)
                            <td style="background-color:yellow">{{$field->percentage}}</td>    
                        @else
                            @if (intval($field->percentage) >= 40 && intval($field->percentage) < 80 )
                                <td style="background-color:green; color:white">{{$field->percentage}}</td>    
                            @else
                                @if (intval($field->percentage) >= 0 && intval($field->percentage) < 40 )
                                    <td style="background-color:white; color:black">{{$field->percentage}}</td>    
                                @else
                                    @if (intval($field->percentage) >= -35 && intval($field->percentage) < 0 )
                                        <td style="background-color:orangered; color:white">{{$field->percentage}}</td>    
                                    @else
                                        <td style="background-color:darkred; color:white">{{$field->percentage}}</td>    
                                    @endif
                                @endif
                            @endif
                        @endif    
                    @endif
                <td>
                    @if ($field->status == 1)
                        OPEN
                    @endif
                    @if ($field->status == 0)
                        CLOSED
                    @endif
                    @if ($field->status == 2)
                        STOP LOSS HIT
                    @endif
                    <input type="hidden" name="hidden_records_status" value="{{ $field->status }}" >
                </td>
            @endforeach
            </tr>
        </tbody>
    </table>
    <div>
        {{ $fields->links() }}
    </div>
</div>