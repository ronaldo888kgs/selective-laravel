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
            <div class="d-flex justify-content-between">
                <div>
                    <h1>Welcome: Admin</h1>
                </div>
            </div>

            @if ($visitor_count > 180)
            <div id="messages-box" style="position:absolute; right:30px; top:20px;">
                <h6>Number of Visitors : <b>{{ $visitor_count }}</b></h6>
            </div>    
            @endif
            
        </div>

        @include('admin.categories')
        
        
        <div>
            <div class="table-responsive" style="padding: 10px">

                @include("admin.search_add")
                
                <div id="data-container">
                    @include('admin.pagination_table')
                </div>

                <div>
                    <form action="{{ route('adminpage.file-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$current_cat_id}}" id="form_cat_id" name="form_cat_id" />
                        <input type="file" name="file" class="custom-file-input" id="customFile">
                        <button class="btn btn-primary">Import data</button>
                        <a class="btn btn-success" onclick="exportAsExcel({{ $current_cat_id }})" >Export to Excel</a>
                        <a class="btn btn-success"onclick="exportAsPdf({{ $current_cat_id }})">Export to PDF</a>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade justify-content-center" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width:100% !important">
            <div class="modal-dialog" style="width:90%;  max-width:1920px !important">
                <div class="modal-content" style="width:100%;">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <h1>S.NO&nbsp;&nbsp;&nbsp;</h1><h1 id="modal_no"></h1>
                            <input type="hidden" id="db_id" />
                        </div>
                        <div>
                            <div class="d-flex" style="margin-top:30px;">
                                <div style="margin-right:30px;">
                                    <h5>Change category to : </h5>
                                </div>
                                <div  style="width:fit-content">
                                    <select id="category_select_modal" class="form-select" aria-label="Default select">
                                        @foreach ($categories as $category)
                                            @if ($category->id == $current_cat_id)
                                                <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div style="overflow: auto; margin-top:30px">
                                <table class="table  table-bordered table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead class="table-light">
                                        <th>Posted Date</th>
                                        <th>Buy Date</th>
                                        <th>Symbol</th>
                                        <th>Qty</th>
                                        <th>Expiration Date</th>
                                        <th>Sell Date</th>
                                        <th>Call or Put or Strategy</th>
                                        <th>Strike </th>
                                        <th>Strike Price</th>
                                        <th>Stoploss</th>
                                        <th>Out Price</th>
                                        <th>Net Difference</th> 
                                        <th>High Price</th> 
                                        <th>% Net Profit or Loss</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input id = "edit_posted_date" type="date" value="<?php echo date('Y-m-d'); ?>"  /></td>
                                            <td><input id = "edit_buy_date" type="date" value="<?php echo date('Y-m-d'); ?>" /></td>
                                            <td><input id = "edit_symbol" type="text" class="form-control" /></td>
                                            <td><input id = "edit_qty" type="text" class="form-control" onchange="calcNetDifference()" /></td>
                                            <td><input id = "edit_expiration_date" type="date" value="<?php echo date('Y-m-d'); ?>" /></td>
                                            <td><input id = "edit_sell_date" type="date" value="<?php echo date('Y-m-d'); ?>" /></td>
                                            <td>
                                                <select id="edit_call_put_strategy" class="form-select" aria-label="Default select" >
                                                    <option value="call" selected >Call</option>
                                                    <option value="put" >Put</option>
                                                    <option value="strategy" >Strategy</option>
                                                </select>
                                            </td>
                                            <td><input id = "edit_strike" type="text" class="form-control" /></td>
                                            <td><input id = "edit_strike_price" type="text" class="form-control" onchange="calcNetDifference()"/></td>
                                            <td><input id = "edit_inprice" type="text" class="form-control" /></td>
                                            <td><input id = "edit_outprice" type="text" class="form-control" onchange="calcNetDifference()"/></td>
                                            <td><input id = "edit_netdifference" type="text" class="form-control" /></td>
                                            <td><input id = "edit_highprice" type="text" class="form-control" /></td>
                                            <td><input id = "edit_percentage_net_profit" type="text" class="form-control" /></td>
                                            <td>
                                                <select id="edit_status_select" class="form-select" aria-label="Default select">
                                                    <option value="0" selected>CLOSE</option>
                                                    <option value="1" >OPEN</option>
                                                    <option value="2" >STOPLOSS HIT</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editField()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="fieldDelModal" tabindex="-1" aria-labelledby="fieldDelModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="fieldDelModalLabel">Select the Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <h1>S.NO&nbsp;&nbsp;&nbsp;</h1><h1 id="del_modal_no"></h1>
                            <input type="hidden" id="del_db_id" />
                        </div>
                        <div>
                                
                            <h2>Are you sure to delete this?</h2>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteField()">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    
    <script type="text/javascript">

        var selectedNumber = "";
        var selectedID = "";

       

        function calcNetDifference()
        {
            if(isNaN($('#edit_qty').val()))
            {
                $('#edit_qty').val('0');
                return;
            }
            if(isNaN($('#edit_outprice').val()))
            {
                $('#edit_outprice').val('0');
                return;
            }
            if(isNaN($('#edit_strike_price').val()))
            {
                $('#edit_strike_price').val('0');
                return;
            }
            var qty = isNaN($('#edit_qty').val()) ? 0: parseFloat($('#edit_qty').val());
            var outprice = isNaN($('#edit_outprice').val()) ? 0: parseFloat($('#edit_outprice').val());
            var strikeprice = isNaN($('#edit_strike_price').val()) ? 0: parseFloat($('#edit_strike_price').val());
            var diff = qty * (outprice - strikeprice);
            $('#edit_netdifference').val(diff.toFixed(2))
            var percent = (outprice * 100 / (strikeprice == 0? 1 : strikeprice)) - 100;
            $('#edit_percentage_net_profit').val(percent.toFixed(2))
        }
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
            var tr_records = document.getElementsByName("tr-records");
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
                                            console.log(high_price, i);
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
                                    else if(Number(hidden_strikes_price[k].value) < closeVal)
                                    {
                                        live_option_price[k].innerHTML ='<b>' + closeVal + '</b>';
                                        live_option_price[k].style.color="white";
                                        live_option_price[k].style.backgroundColor="green";

                                    }else{
                                        live_option_price[k].innerHTML = '<b>' + closeVal + '</b>';
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
        function activeRecord2(currentValue, dbID)
        {
            
            if(currentValue == '1')
                currentValue = '0';
            else
                currentValue = '1';
            
            $.ajax({
                url: "{{ route('adminpage.activeRecord2') }}",
                method: 'post',
                dataType: "json",
                data: {
                    dbID: dbID,
                    val: currentValue
                },
                success: function(data) {
                    if(data.status == true)
                    {
                        getFieldsByCategory(document.getElementById('category_select').value);
                    }
                    if(data.status == false)
                    {
                        alert(data.msg);
                    }
                }
            });
        }

        function activeRecorde(obj, id)
        {
            $.ajax({
                url: "{{ route('adminpage.activeRecord') }}",
                method: 'post',
                dataType: "json",
                data: {
                    dbID: id,
                    val: obj.checked
                },
                success: function(data) {
                    if(data.status == true)
                    {
                        getFieldsByCategory(document.getElementById('category_select').value);
                    }
                    if(data.status == false)
                    {
                        alert(data.msg);
                    }
                }
            });
        }
        function deleteField()
        {
            var dbID = document.getElementById('del_db_id').value;
            var cat_id = {{$current_cat_id}};
            $.ajax({
                url: "{{ route('adminpage.deleteField') }}",
                method: 'post',
                dataType: "json",
                data: {
                    dbID: dbID,
                    cat_id: cat_id
                },
                success: function(data) {
                    if(data.status == true)
                    {
                        getFieldsByCategory(document.getElementById('category_select').value);
                    }
                    if(data.status == false)
                    {
                        alert(data.msg);
                    }
                }
            });
        }

        function showDeleteFieldModal(number, id)
        {
            document.getElementById('del_modal_no').innerText = number;
            
            document.getElementById('del_db_id').value = id;
            
        }

        function editField()
        {
            var dbID = document.getElementById('db_id').value;
            var cat_id = document.getElementById('category_select_modal').value;
            
            $.ajax({
                url: "{{ route('adminpage.editField') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    dbID: dbID,
                    cat_id: cat_id,
                    posted_date:$('#edit_posted_date').val(),
                    buy_date:$('#edit_buy_date').val(),
                    symbol:$('#edit_symbol').val() === '' ? ' ':  $('#edit_symbol').val(),
                    qty:$('#edit_qty').val() === '' ? '0': $('#edit_qty').val(),
                    expiration_date:$('#edit_expiration_date').val(),
                    sell_date:$('#edit_sell_date').val(),
                    call_put_strategy: $('#edit_call_put_strategy').val(),
                    strike:$('#edit_strike').val() === '' ? '0': $('#edit_strike').val(),
                    strike_price:$('#edit_strike_price').val() === '' ? '0': $('#edit_strike_price').val(),
                    inprice:$('#edit_inprice').val() === '' ? '0': $('#edit_inprice').val(),
                    outprice:$('#edit_outprice').val() === '' ? '0': $('#edit_outprice').val(),
                    netdifference:$('#edit_netdifference').val() === '' ? '0': $('#edit_netdifference').val(),
                    highprice:$('#edit_highprice').val() === '' ? '0': $('#edit_highprice').val(),
                    percentage_net_profit:$('#edit_percentage_net_profit').val() === '' ? '0': $('#edit_percentage_net_profit').val(),
                    status_select:$('#edit_status_select').val() === '' ? ' ' : $('#edit_status_select').val()
                },
                success: function(data) {
                    if(data.status == true)
                    {
                        getFieldsByCategory(document.getElementById('category_select').value);
                    }
                    if(data.status == false)
                    {
                        alert(data.msg);
                    }
                }
            });
        }
        
        

        //function showEditModal(number, id, posted_date, buy_date, symbol, qty, expiration_date, call_put_strategy, strike ,strike_price, in_price, out_price, net_difference, percentage, status )
        function showEditModal(number, id, dataObj)
        {
            document.getElementById('modal_no').innerText = number;
            document.getElementById('db_id').value = id;
            $('#edit_posted_date').val(dataObj.posted_date);
            $('#edit_buy_date').val(dataObj.buy_date);
            $('#edit_symbol').val(dataObj.symbol);
            $('#edit_qty').val(dataObj.qty);
            $('#edit_expiration_date').val(dataObj.expiration_date);
            $('#edit_sell_date').val(dataObj.sell_date);
            $('#edit_call_put_strategy').val(dataObj.call_put_strategy);
            $('#edit_strike').val(dataObj.strike);
            $('#edit_strike_price').val(dataObj.strike_price);
            $('#edit_inprice').val(dataObj.in_price);
            $('#edit_outprice').val(dataObj.out_price);
            $('#edit_netdifference').val(dataObj.net_difference);
            $('#edit_highprice').val(dataObj.high_price);
            $('#edit_percentage_net_profit').val(dataObj.percentage);
            $('#edit_status_select').val(dataObj.status);
        }
    
        function exportAsExcel(id)
        {
            var sendData = {
                datetype: $('#date_search_select').val(),
                startdate: $('#search_date_start').val(),
                enddate: $('#search_date_end').val(),
                keyword: $('#type_search_select').val(),
                value: $('#search_value').val(),
                only_activated: 0,
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
                only_activated: 0,
            }
            window.location.href = "/file-export-pdf/{{ $current_cat_id }}" + "/" + JSON.stringify(sendData);
        }
    </script>
@endsection