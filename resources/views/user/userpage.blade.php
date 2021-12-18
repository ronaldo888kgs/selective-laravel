@extends('dashboard')

@section('content')
<?php 
$i = 0; 
$selected_category_name = "";
foreach ($categories as $category)
    if($category->id == $current_cat_id )
    {
        $selected_category_name = $category->name;
        break;
    }
?>

<div style="background-color:white; border-radius:5px; margin: 0px 10px;">
    <div class="d-flex justify-content-between" style="padding: 20px 10px; position: relative">
        <div class="d-flex">
            <div>
                <h1>Welcome: User</h1>
            </div>
            @if ($visitor_count > 180)
                <div id="messages-box" style="position:absolute; right:30px; top:20px;">
                    <h6>Number of Visitors : <b>{{ $visitor_count }}</b></h6>
                </div>    
            @endif
            
        </div>
    </div>
    <div>
        <div class="table-responsive" style="padding: 10px">
            <div style="margin:0px; padding:0px">
                <div class="d-flex align-items-center" style="margin:10px 5px; height:38px;">
                    <div style="margin-right:20px; width: fit-content;"> Categories : </div>
                    <div>
                        <select id="category_select" class="form-select" aria-label="Default select" onchange="getFieldsByCategory(this.value)">
                            @foreach ($categories as $category)
                                @if ($category->id == $current_cat_id)
                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                @else
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex align-items-center justify-content-center" style="margin-left:10px">
                        <span>Net Profit or Loss : </span>
                        <b style="margin-left:10px">${{ isset($avg_percent) ? $avg_percent : '0' }}</b>
                    </div>
                </div>
            </div>
            @include("user.search")
            <div id="data-container">
                @include("user.pagination_table")
            </div>
            
            <div>
                <a class="btn btn-success" onclick="exportAsExcel({{ $current_cat_id }})" >Export to Excel</a>
                <a class="btn btn-success"onclick="exportAsPdf({{ $current_cat_id }})">Export to PDF</a>
            </div>
        </div>
    </div>
</div>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('2a8a631c2ba0b86e8247', {
        cluster: 'ap3'
    });

    var channel = pusher.subscribe('selective-channel');
    channel.bind('new-data', function(data) {
        if(data.message == "new data")
            window.location.reload();
    });
</script>
<script type="text/javascript">

    let timer;
    timer = setInterval(refreshDataTable, 10 * 1000);
    function refreshDataTable()
    {
        clearInterval(timer);
        timer = 0;
        refreshDataWithPrice();
        
    }

    var calledCnt = 0;
    var returnedCnt = 0;

    function refreshDataWithPrice()
        {
            var hidden_symbols = document.getElementsByName("hidden_symbols");
            var hidden_expiratoin = document.getElementsByName("hidden_expirations");
            var hidden_records_status = document.getElementsByName("hidden_records_status");   
            var hidden_call_put_strategy = document.getElementsByName("hidden_call_put_strategy");   
            var hidden_strikes = document.getElementsByName("hidden_strikes");   
            var live_option_price = document.getElementsByName("live_option_price");
            for(var i = 0 ; i < hidden_symbols.length; i++)
            {
                if(hidden_records_status[i].value != '0' && hidden_symbols[i].value.length > 0)// not closed
                {
                    // var url = "{{ $live_option_price_url }}&symbol=" + hidden_symbols[i].value + "&expiration=" + hidden_expiratoin[i].value;
                    // fetch(url, {
                    //     headers:{
                    //         'Authorization': 'Bearer {{ $live_access_token }}',
                    //         'Accept': "application/json"
                    //     }
                    // }).then(response=> response.json())
                    // .then(data  => parseOptionChainsData(data));
                    calledCnt++;
                    var url = "{{ $ameri_base_url }}?apikey={{ $ameri_api_key }}&symbol=" + hidden_symbols[i].value + "&contractType=" + hidden_call_put_strategy[i].value.toUpperCase() + "&strike=" + hidden_strikes[i].value;
                    fetch(url).then(response=> response.json())
                    .then(data  => parseOptionChainsDataTD(data));


                    var url2 = "{{ $live_stock_price_url }}&symbols=" + hidden_symbols[i].value;
                    fetch(url2, {
                        headers:{
                            'Authorization': 'Bearer {{ $live_access_token }}',
                            'Accept': "application/json"
                        }
                    }).then(response=> response.json())
                    .then(data  => parseQuotesData(data));
                }
            }
        }


        function parseOptionChainsDataTD(jsonObj)
        {
            returnedCnt++;
            var hidden_symbols = document.getElementsByName("hidden_symbols");
            var hidden_expiratoin = document.getElementsByName("hidden_expirations");
            var hidden_records_status = document.getElementsByName("hidden_records_status");   
            var hidden_call_put_strategy = document.getElementsByName("hidden_call_put_strategy");   
            var hidden_strikes = document.getElementsByName("hidden_strikes");   
            var hidden_strikes_price = document.getElementsByName("hidden_strikes_price");   
            var live_option_price = document.getElementsByName("live_option_prices");
            var td_high_prices = document.getElementsByName("td_high_price");
            var tr_records = document.getElementsByName("tr-record");
            var retSymbol = jsonObj.symbol;
            var callExpDateMap = jsonObj.callExpDateMap;

            if(Object.keys(callExpDateMap).length > 0)
            {
                for(var i = 0 ; i < hidden_symbols.length ; i++)
                {
                    if(hidden_records_status[i].value == 0)
                        continue;
                    if(hidden_symbols[i].value == retSymbol)
                    {
                        if(hidden_call_put_strategy[i].value == "call")
                        {
                            var names = Object.keys(callExpDateMap);
                            for(var j = 0 ; j < names.length ; j++)
                            {
                                if(names[j].includes(hidden_expiratoin[i].value))
                                {
                                    var objData_by_expiration = callExpDateMap[names[j]];
                                    var names_by_strike = Object.keys(objData_by_expiration);
                                    for(var k = 0 ; k < names_by_strike.length ; k++)
                                    {
                                        var name_by_strike = names_by_strike[k];
                                        if(name_by_strike.includes(hidden_strikes[i].value))
                                        {
                                            var objStrike = objData_by_expiration[name_by_strike];
                                            var closeVal = objStrike[0].last;
                                            if(closeVal == null || closeVal == undefined || closeVal == '')
                                            {   
                                                live_option_price[i].innerHTML = '';
                                            }
                                            else if(Number(hidden_strikes_price[i].value) < closeVal)
                                            {
                                                live_option_price[i].innerHTML ='<b>' + closeVal + '</b>';
                                                live_option_price[i].style.color="white";
                                                live_option_price[i].style.backgroundColor="green";

                                            }else{
                                                live_option_price[i].innerHTML = '<b>' + closeVal + '</b>';
                                                live_option_price[i].style.color="white";
                                                live_option_price[i].style.backgroundColor="red";
                                            }
                                            var high_price = closeVal * 100 / hidden_strikes_price[i].value - 100;
                                            td_high_prices[i].innerHTML = (high_price).toFixed(2);
                                            if(high_price < -35)
                                            {
                                                tr_records[i].style.backgroundColor = 'red';
                                                tr_records[i].style.color = 'white';
                                            }
                                        }
                                        

                                    }
                                }
                            }
                        }
                    }
                }
            }

            var putExpDateMap = jsonObj.putExpDateMap;
            if(Object.keys(putExpDateMap).length > 0)
            {
                for(var i = 0 ; i < hidden_symbols.length ; i++)
                {
                    if(hidden_records_status[i].value == 0)
                        continue;
                    if(hidden_symbols[i].value == retSymbol)
                    {
                        if(hidden_call_put_strategy[i].value == "put")
                        {
                            var names = Object.keys(putExpDateMap);
                            for(var j = 0 ; j < names.length ; j++)
                            {
                                if(names[j].includes(hidden_expiratoin[i].value))
                                {
                                    var objData_by_expiration = putExpDateMap[names[j]];
                                    var names_by_strike = Object.keys(objData_by_expiration);
                                    for(var k = 0 ; k < names_by_strike.length ; k++)
                                    {
                                        var name_by_strike = names_by_strike[k];
                                        if(name_by_strike.includes(hidden_strikes[i].value))
                                        {
                                            var objStrike = objData_by_expiration[name_by_strike];
                                            var closeVal = objStrike[0].last;
                                            if(closeVal == null || closeVal == undefined || closeVal == '')
                                            {   
                                                live_option_price[i].innerHTML = '';
                                            }
                                            else if(Number(hidden_strikes_price[i].value) < closeVal)
                                            {
                                                live_option_price[i].innerHTML ='<b>' + closeVal + '</b>';
                                                live_option_price[i].style.color="white";
                                                live_option_price[i].style.backgroundColor="green";

                                            }else{
                                                live_option_price[i].innerHTML = '<b>' + closeVal + '</b>';
                                                live_option_price[i].style.color="white";
                                                live_option_price[i].style.backgroundColor="red";
                                            }
                                            var high_price = closeVal * 100 / hidden_strikes_price[i].value - 100;
                                            td_high_prices[i].innerHTML = (high_price).toFixed(2);
                                            if(high_price < -35)
                                            {
                                                tr_records[i].style.backgroundColor = 'red';
                                                tr_records[i].style.color = 'white';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if(timer == 0 && returnedCnt == calledCnt)
            {
                timer = setInterval(refreshDataTable, 10 * 1000);
            }
        }

        function parseQuotesData(jsonObj)
        {
            var hidden_symbols = document.getElementsByName("hidden_symbols");
            var hidden_records_status = document.getElementsByName("hidden_records_status");  
            var stock_prices = document.getElementsByName("stock_prices"); 
            for(var i = 0 ; i < hidden_symbols.length ; i++)
            {
                if(jsonObj.quotes != null || jsonObj.quotes != undefined)
                {
                    if(jsonObj.quotes.quote != null || jsonObj.quotes.quote != undefined )
                    {
                        if(jsonObj.quotes.quote.symbol == hidden_symbols[i].value && 
                            hidden_records_status[i].value != '0')
                        {
                            stock_prices[i].innerHTML = "<b>" + jsonObj.quotes.quote.last + "</b>";
                        }
                    }
                }
            }
        }
        function parseOptionChainsData(jsonObj)
        {
            var hidden_symbols = document.getElementsByName("hidden_symbols");
            var hidden_expiratoin = document.getElementsByName("hidden_expirations");
            var hidden_records_status = document.getElementsByName("hidden_records_status");   
            var hidden_call_put_strategy = document.getElementsByName("hidden_call_put_strategy");   
            var hidden_strikes = document.getElementsByName("hidden_strikes");   
            var hidden_strikes_price = document.getElementsByName("hidden_strikes_price");   
            
            var live_option_price = document.getElementsByName("live_option_prices");
            if(jsonObj.options != null || jsonObj.options != undefined)
            {
                if(jsonObj.options.option != null || jsonObj.options.option != undefined )
                {
                    for(var j = 0 ; j < jsonObj.options.option.length ; j++)
                    {
                        var option = jsonObj.options.option[j];
                        for(var k = 0 ; k < hidden_symbols.length; k++)
                        {
                            if(option.underlying == hidden_symbols[k].value)
                            {
                                
                                if(hidden_call_put_strategy[k].value == option.option_type && 
                                Number(hidden_strikes[k].value) == option.strike && 
                                hidden_expiratoin[k].value == option.expiration_date && 
                                hidden_records_status[k].value != '0')
                                {
                                    
                                    var closeVal = option.close;
                                    if(closeVal == null || closeVal == undefined || closeVal == '')
                                    {   
                                        closeVal = option.last;
                                    }
                                    if(closeVal == null || closeVal == undefined || closeVal == '')
                                    {   
                                        live_option_price[k].innerHTML = '';
                                    }
                                    else if(Number(hidden_strikes_price[k].value) < option.close)
                                    {
                                        live_option_price[k].innerHTML ='<b>' + option.close + '</b>';
                                        live_option_price[k].style.color="white";
                                        live_option_price[k].style.backgroundColor="green";

                                    }else{
                                        live_option_price[k].innerHTML = '<b>' + option.close + '</b>';
                                        live_option_price[k].style.color="white";
                                        live_option_price[k].style.backgroundColor="red";
                                    }
                                    
                                    
                                }
                                
                            }
                        }
                    }
                }
            }

            if(timer == 0)
            {
                timer = setInterval(refreshDataTable, 10 * 1000);
            }
        }

    function exportAsExcel(id)
        {
            var sendData = {
                datetype: $('#date_search_select').val(),
                startdate: $('#search_date_start').val(),
                enddate: $('#search_date_end').val(),
                keyword: $('#type_search_select').val(),
                value: $('#search_value').val(),
                only_activated: 1,
            }
            window.location.href = "/file-export/{{ $current_cat_id }}" + "/" + JSON.stringify(sendData);
        }

        function exportAsPdf(id)
        {
            var sendData = {
                datetype: $('#date_search_select').val(),
                startdate: $('#search_date_start').val(),
                enddate: $('#search_date_end').val(),
                keyword: $('#type_search_select').val(),
                value: $('#search_value').val(),
                only_activated: 1,
            }
            window.location.href = "/file-export-pdf/{{ $current_cat_id }}" + "/" + JSON.stringify(sendData);
        }
</script>
@endsection