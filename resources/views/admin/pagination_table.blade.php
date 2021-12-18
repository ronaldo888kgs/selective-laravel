<?php $i = 0; ?>
<table class="table  table-bordered table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" style=" font-size:14px;">
    <thead class="table-light">
        <th style="width:30px;">No</th>
        <th style="width:110px">Posted Date</th>
        <th style="width:110px">Buy Date</th>
        <th>Symbol</th>
        <th style="width:80px">Qty</th>
        <th style="width:110px">Expiration Date</th>
        <th style="width:110px">Sell Date</th>
        <th>
            <div>Call</div>
            <div>Put </div>
            <div>Strategy</div>
        </th>
        <th>Strike </th>
        <th>Strike Price</th>
        <th>Tracker</th>
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
        <th>
            <div>% Net Profit</div>
            <div>Loss</div>
        </th>
        <th>Status</th>
        <th>Manage</th>
    </thead>
    <tbody id="tb-data">
        @foreach ($fields as $field)
        @if ($field->activated == 1)
            <tr name="tr-records" class="table-success">
        @else
            <tr name="tr-records">
        @endif
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
            <td>{{ $field->tracker }}</td>
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
                            <td style="color:black">{{$field->percentage}}</td>    
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
            <td>
                    {{-- <a data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showEditModal({{$i}}, {{$field->id}}, {{ $field->posted_date }}, {{ $field->buy_date }}, {{ $field->symbol }}, {{ $field->qty }}, {{ $field->expiration_date }}, {{ $field->call_put_strategy }}, {{$field->strike}} ,{{$field->strike_price}},{{$field->in_price}}, {{$field->out_price}}, {{$field->net_difference}}, {{$field->percentage}}, {{ $field->status }})"> --}}
                <a data-toggle="tooltip" title="Edit record" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showEditModal({{$i}}, {{$field->id}}, {{ json_encode($field) }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                </a>
                <a data-toggle="tooltip" title="Delete record" data-bs-toggle="modal" data-bs-target="#fieldDelModal" onclick="showDeleteFieldModal({{$i}}, {{$field->id}})" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </a>
                <a data-toggle="tooltip" title="Activate record" onclick="activeRecord2({{$field->activated}}, {{$field->id}})">
                    @if ($field->activated == 1)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-check2-circle" viewBox="0 0 16 16">
                            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                        </svg>
                    @endif
                    @if ($field->activated == 0)
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                    @endif
                    
                </a>
            </td>
        @endforeach
        </tr>
    </tbody>
</table>
<div id="pagination-container">
   {{ $fields->links() }}
</div>