<div class="d-flex justify-content-between">
        <div class="d-flex align-items-center" style="margin:10px 5px; height:38px;">
            <div class="d-flex align-items-center" style="margin-right: 10px">
                <div class="d-flex align-items-center" style="margin:0px; padding: 0px; height:100%; margin-right: 10px">
                    Type:
                </div>
                <div>
                    <select id="date_search_select" class="form-select" aria-label="Default select" onchange="changedSearchDate(this.value)">
                        <option value="all" {{ isset($filters) && $filters->datetype === 'all'? 'selected'  : '' }} >All</option>
                        <option value="posted_date" {{ isset($filters) && $filters->datetype === 'posted_date'? 'selected'  : '' }}>Posted Date</option>
                        <option value="buy_date" {{ isset($filters) && $filters->datetype === 'buy_date' ?'selected'  : '' }}>Buy Date</option>
                        <option value="expiration_date" {{ isset($filters) && $filters->datetype === 'expiration_date'? 'selected'  : '' }}>Expiration Date</option>
                        <option value="sell_date" {{ isset($filters) && $filters->datetype === 'sell_date'? 'selected'  : '' }}>Sell Date</option>
                    </select>
                    <input type="hidden" id="hidden_date_search_select" value="all">
                </div>
            </div>
            <div class="d-flex align-items-center" style="margin:0px; padding: 0px; height:100%; margin-right: 10px">From:</div>
            <div style="margin:0px; padding: 0px; height:100%; margin-right: 10px">
                <input id = "search_date_start" type="date" value="{{ isset($filters) ? $filters->startdate : 'MM/dd/yyyy' }}"  style="height:100%" /> 
                <input type="hidden" id="hidden_search_date_start" value="">
            </div>
            <div class="d-flex align-items-center" style="margin:0px; padding: 0px; height:100%; margin-right: 10px">
                To:
            </div>
            <div style="margin:0px; padding: 0px; height:100%; margin-right: 10px">
                <input id = "search_date_end" type="date" value="{{ isset($filters) ? $filters->enddate : 'MM/dd/yyyy' }}"  style="height:100%"/> 
                <input type="hidden" id="hidden_search_date_end" value="">
            </div>
            <div style="margin-right: 10px">
                <button onclick="searchByDate()" class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch">
                    Search
                </button>
                <button class="btn btn-success" type="button" onclick="resetDateFilters()" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="color:white">
                        <path style="fill:currentColor" d="M20.944 12.979c-.489 4.509-4.306 8.021-8.944 8.021-2.698 0-5.112-1.194-6.763-3.075l1.245-1.633c1.283 1.645 3.276 2.708 5.518 2.708 3.526 0 6.444-2.624 6.923-6.021h-2.923l4-5.25 4 5.25h-3.056zm-15.864-1.979c.487-3.387 3.4-6 6.92-6 2.237 0 4.228 1.059 5.51 2.698l1.244-1.632c-1.65-1.876-4.061-3.066-6.754-3.066-4.632 0-8.443 3.501-8.941 8h-3.059l4 5.25 4-5.25h-2.92z"/>
                    </svg>
                </button>
                
            </div>
        </div>

        <div class="d-flex align-items-center" style="margin:10px 5px; height:38px;">
            <div class="d-flex align-items-center" style="margin-right: 10px">
                <div class="d-flex align-items-center" style="margin:0px; padding: 0px; height:100%; margin-right: 10px">
                    Type:
                </div>
                <div>
                    <select id="type_search_select" class="form-select" aria-label="Default select" onchange="changedSearchKeyword(this.value)" >
                        <option value="all" {{ isset($filters) && $filters->keyword === 'all'? 'selected'  : '' }} >All</option>
                        <option value="symbol" {{ isset($filters) && $filters->keyword === 'symbol'? 'selected'  : '' }} >Symbol</option>
                        <option value="call_put_strategy" {{ isset($filters) && $filters->keyword === 'call_put_strategy'? 'selected'  : '' }} >Call or Put or Strategy</option>
                        <option value="strike" {{ isset($filters) && $filters->keyword === 'strike'? 'selected'  : '' }} >Strike</option>
                        <option value="strike_price" {{ isset($filters) && $filters->keyword === 'strike_price'? 'selected'  : '' }} >Strike Price</option>
                        <option value="in_price" {{ isset($filters) && $filters->keyword === 'in_price'? 'selected'  : '' }} >Stoploss</option>
                        <option value="out_price" {{ isset($filters) && $filters->keyword === 'out_price'? 'selected'  : '' }} >Out Price</option>
                        <option value="net_difference" {{ isset($filters) && $filters->keyword === 'net_difference'? 'selected'  : '' }} >Net Difference</option>
                        <option value="high_price" {{ isset($filters) && $filters->keyword === 'high_price'? 'selected'  : '' }} >High Price</option>
                        <option value="status" {{ isset($filters) && $filters->keyword === 'status'? 'status'  : '' }} >Status</option>
                    </select>
                    <input type="hidden" id="hidden_type_search_select" value="all">
                </div>
            </div>
            <div class="d-flex">
                <div id="search_value_container">
                    <input id = "search_value" type="text" class="form-control" value="{{ isset($filters) ? $filters->value : '' }}" />
                </div>
                <input type="hidden" id="hidden_search_value">
                <button onclick="searchByKeys()"  class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch" style="margin-left:20px;">
                    Search...
                </button>
                <button class="btn btn-success" type="button" onclick="resetKeywordFilters()" style="margin-left:10px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="color:white">
                        <path style="fill:currentColor" d="M20.944 12.979c-.489 4.509-4.306 8.021-8.944 8.021-2.698 0-5.112-1.194-6.763-3.075l1.245-1.633c1.283 1.645 3.276 2.708 5.518 2.708 3.526 0 6.444-2.624 6.923-6.021h-2.923l4-5.25 4 5.25h-3.056zm-15.864-1.979c.487-3.387 3.4-6 6.92-6 2.237 0 4.228 1.059 5.51 2.698l1.244-1.632c-1.65-1.876-4.061-3.066-6.754-3.066-4.632 0-8.443 3.501-8.941 8h-3.059l4 5.25 4-5.25h-2.92z"/>
                    </svg>
                </button>
            </div>
            
        </div>

        <div>
            <button class="btn btn-primary" style="margin:10px 5px; height:38px;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Add Data
            </button>
        </div>
    </div>

    {{-- add data form --}}
    <div class="collapse " id="collapseExample" style="margin-top:10px">
        <div class="card card-body table-responsive">
            @csrf
            <table class="table  table-bordered table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead class="table-light">
                    <th>Posted Date</th>
                    <th>Buy Date</th>
                    <th>Symbol</th>
                    <th>Qty</th>
                    <th>Expiration Date</th>
                    <th>Sell Date</th>
                    <th>
                        <div>Call</div>
                        <div>Put</div>
                        <div>Strategy</div>
                    </th>
                    <th>Strike </th>
                    <th>Strike Price</th>
                    <th>Stoploss</th>
                    <th>Out Price</th>
                    <th>Net Difference</th> 
                    <th>High Price</th> 
                    <th>% Net Profit or Loss</th>
                    <th>Status</th>
                    <th>Edit</th>
                </thead>
                <tbody>
                    <tr>
                        <td><input id = "posted_date" type="date" value="<?php echo date('Y-m-d'); ?>"  /></td>
                        <td><input id = "buy_date" type="date" value="<?php echo date('Y-m-d'); ?>" /></td>
                        <td><input id = "symbol" type="text" class="form-control" /></td>
                        <td><input id = "qty" type="text" class="form-control" onchange="calcNetDifference2()" /></td>
                        <td><input id = "expiration_date" type="date" value="<?php echo date('Y-m-d'); ?>" /></td>
                        <td><input id = "sell_date" type="date" value="<?php echo date('Y-m-d'); ?>" /></td>
                        <td>
                            <select id="call_put_strategy" class="form-select" aria-label="Default select" >
                                <option value="call" selected >Call</option>
                                <option value="put" >Put</option>
                                <option value="strategy" >Strategy</option>
                            </select>
                        </td>
                        <td><input id = "strike" type="text" class="form-control" /></td>
                        <td><input id = "strike_price" type="text" class="form-control" onchange="calcNetDifference2()"/></td>
                        <td><input id = "inprice" type="text" class="form-control"   /></td>
                        <td><input id = "outprice" type="text" class="form-control"  onchange="calcNetDifference2()" /></td>
                        <td><input id = "netdifference" type="text" class="form-control" /></td>
                        <td><input id = "highprice" type="text" class="form-control" /></td>
                        <td><input id = "percentage_net_profit" type="text" class="form-control" /></td>
                        <td>
                            <select id="status_select" class="form-select" aria-label="Default select">
                                <option value="0" >CLOSE</option>
                                <option value="1" selected>OPEN</option>
                                <option value="2" >STOPLOSS HIT</option>
                            </select>
                        </td>
                        {{-- <td>$selected_category_name </td> --}}
                        <td><button class="btn btn-primary" onclick="addData()">Add</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    {{-- end add data form --}}

<script type="text/javascript">
function resetDateFilters()
{
    $('#search_date_end').val('');
    $('#search_date_start').val('');
    $('#date_search_select').val('all');
    $('#hidden_search_date_end').val('');
    $('#hidden_search_date_start').val('');
    $('#hidden_date_search_select').val('all');
    searchByDate();
}

function resetKeywordFilters()
{
    $('#search_value').val('');
    $('#type_search_select').val('all');
    $('#hidden_search_value').val('');
    $('#hidden_type_search_select').val('all');
    searchByDate();
}

function changedSearchKeyword(value)
{
    
    if(value == "status")
    {    
        $('#search_value_container').html(
            '<select id="search_value" class="form-select" aria-label="Default select">' +
                '<option value="0"  selected>CLOSE</option>'+
                '<option value="1">OPEN</option>'+
                '<option value="2" >STOPLOSS HIT</option>'+
            '</select>'
        );
    }else if($('#search_value_container').html().startsWith("<select")){
        $('#search_value_container').html(
            '<input id = "search_value" type="text" class="form-control" value="{{ isset($filters) ? $filters->value : '' }}" />'
        );
    }
    if(value == 'all')
    {
        $('#search_value').val('');
    }    
}
function changedSearchDate(value)
{
    if(value == 'all')
    {
        $('#search_date_end').val('');
        $('#search_date_start').val('');
    }
}
function calcNetDifference2()
{
    if(isNaN($('#qty').val()))
    {
        $('#qty').val('0');
        return;
    }
    if(isNaN($('#outprice').val()))
    {
        $('#outprice').val('0');
        return;
    }
    if(isNaN($('#strike_price').val()))
    {
        $('#strike_price').val('0');
        return;
    }
    var qty = isNaN($('#qty').val()) ? 0: parseFloat($('#qty').val());
    var outprice = isNaN($('#outprice').val()) ? 0: parseFloat($('#outprice').val());
    var strike_price = isNaN($('#strike_price').val()) ? 0: parseFloat($('#strike_price').val());
    var diff = qty * (outprice - strike_price);
    $('#netdifference').val(diff.toFixed(2))
    var percent = (outprice * 100 / (strike_price == 0? 1 : strike_price)) - 100;
    $('#percentage_net_profit').val(percent.toFixed(2))
}
function searchField()
{
    var data = {
        datetype: $('#hidden_date_search_select').val(),
        startdate: $('#hidden_search_date_start').val(),
        enddate: $('#hidden_search_date_end').val(),
        keyword: $('#hidden_type_search_select').val(),
        value: $('#hidden_search_value').val(),
    }
    $.ajax({
        url: "/adminpage/{{ $current_cat_id }}" + "/" + JSON.stringify(data),
        success: function(data) {
            $('#data-container').html(data);
        }
    });
}
function searchByDate()
{
    $('#hidden_date_search_select').val($('#date_search_select').val()),
    $('#hidden_search_date_start').val($('#search_date_start').val()),
    $('#hidden_search_date_end').val($('#search_date_end').val()),
    searchField();
}
function searchByKeys()
{
    $('#hidden_type_search_select').val($('#type_search_select').val());
    $('#hidden_search_value').val($('#search_value').val());
    searchField();
}
function addData()
{
    var postedDate = document.getElementById('posted_date').value;
    var buy_date = document.getElementById('buy_date').value;
    var symbol = document.getElementById('symbol').value;
    symbol = symbol === "" ? " " : symbol;
    var qty = document.getElementById('qty').value;
    qty = qty === "" ? "0" : qty;
    var expiration_date = document.getElementById('expiration_date').value;
    var sell_date = ' ';
    var call_put_strategy = document.getElementById('call_put_strategy').value;
    var strike = document.getElementById('strike').value;
    strike = strike === "" ? "0" : strike;
    var inprice = document.getElementById('inprice').value;
    inprice = inprice === "" ? "0" : inprice;
    var outprice = document.getElementById('outprice').value;
    outprice = outprice === "" ? "0" : outprice;
    var strike_price = document.getElementById('strike_price').value;
    strike_price = strike_price === "" ? "0" : strike_price;
    var netdifference = document.getElementById('netdifference').value;
    netdifference = netdifference === "" ? "0" : netdifference;
    var highprice = document.getElementById('highprice').value;
    highprice = highprice === "" ? "0" : highprice;
    var percentage_net_profit = document.getElementById('percentage_net_profit').value;
    percentage_net_profit = percentage_net_profit === "" ? " " : percentage_net_profit;
    var status = document.getElementById('status_select').value;
    var activated = 0;

    $.ajax({
        url: "{{ route('adminpage.postField') }}",
        type: 'POST',
        dataType: "json",
        data: {
            postedData: postedDate,
            buy_date: buy_date,
            symbol: symbol,
            qty: qty,
            expiration_date: expiration_date,
            sell_date:sell_date,
            call_put_strategy: call_put_strategy,
            strike: strike,
            inprice: inprice,
            outprice: outprice,
            strike_price: strike_price,
            netdifference: netdifference,
            highprice:highprice,
            percentage_net_profit:percentage_net_profit,
            status: status,
            category:{{$current_cat_id}},
            activated:activated
        },
        success: function(data) {
            if(data.status == true)
            {
                document.getElementById('symbol').value = "";
                document.getElementById('qty').value= "";
                document.getElementById('call_put_strategy').value= "";
                document.getElementById('strike').value= "";
                document.getElementById('inprice').value= "";
                document.getElementById('outprice').value= "";
                document.getElementById('strike_price').value= "";
                document.getElementById('netdifference').value= "";
                document.getElementById('percentage_net_profit').value= "";

                getFieldsByCategory(document.getElementById('category_select').value);
            }
            if(data.status == false)
            {
                alert(data.msg);
            }
            
        }
    });
}
</script>