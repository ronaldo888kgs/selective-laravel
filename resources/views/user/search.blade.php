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
            <button class="btn btn-success" type="button" onclick="resetDateFilters()" style="margin-left:10px">
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
                <select id="type_search_select" class="form-select" aria-label="Default select" onchange="changedSearchKeyword(this.value)">
                    <option value="all" {{ isset($filters) && $filters->keyword === 'all'? 'selected'  : '' }} >All</option>
                    <option value="symbol" {{ isset($filters) && $filters->keyword === 'symbol'? 'selected'  : '' }} >Symbol</option>
                    <option value="call_put_strategy" {{ isset($filters) && $filters->keyword === 'call_put_strategy'? 'selected'  : '' }} >Call or Put or Strategy</option>
                    <option value="strike" {{ isset($filters) && $filters->keyword === 'strike'? 'selected'  : '' }} >Strike</option>
                    <option value="strike_price" {{ isset($filters) && $filters->keyword === 'strike_price'? 'selected'  : '' }} >Strike Price</option>
                    <option value="in_price" {{ isset($filters) && $filters->keyword === 'in_price'? 'selected'  : '' }} >Stoploss</option>
                    <option value="out_price" {{ isset($filters) && $filters->keyword === 'out_price'? 'selected'  : '' }} >Out Price</option>
                    <option value="net_difference" {{ isset($filters) && $filters->keyword === 'net_difference'? 'selected'  : '' }} >Net Difference</option>
                    <option value="high_price" {{ isset($filters) && $filters->keyword === 'high_price'? 'selected'  : '' }} >High Price</option>
                    <option value="status" {{ isset($filters) && $filters->keyword === 'status'? 'selected'  : '' }} >Status</option>
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

    
</div>

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
        url: "/userpage/{{ $current_cat_id }}" + "/" + JSON.stringify(data),
        success: function(data) {
            $('#data-container').html(data);
        }
    });
}
function getFieldsByCategory(category)
{
    window.location.href = "/userpage/" + category ;
}
</script>
    {{-- end add data form --}}