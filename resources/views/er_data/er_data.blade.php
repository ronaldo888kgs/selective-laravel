@extends('dashboard')

@section('content')
<div>
    <div class="header_menu d-flex justify-content-between" style="border-bottom:1px solid #2578b5; padding:10px;">
        <div>
            <button 
                class="btn btn-primary" 
                style="margin-left:10px; width:100px; font-size:18px;"
                data-bs-toggle="collapse" 
                data-bs-target="#collapseAddERData" 
                aria-expanded="false" 
                aria-controls="collapseAddERData"
            >Add</button>
            <button 
                class="btn btn-primary" 
                style="margin-left:10px; width:100px; font-size:18px;"
                data-bs-toggle="modal" 
                data-bs-target="#importERDataModal" 
            >Import</button>
            <button 
                class="btn btn-primary" 
                style="margin-left:10px; width:100px; font-size:18px;"
                data-bs-toggle="collapse" 
                data-bs-target="#collapseExportData" 
                aria-expanded="false" 
                aria-controls="collapseExportData"
            >Export</button>
        </div>
        <div> 
            <div class="d-flex" style="margin-right:10px; align-items: center;">
                <h5 style="white-space: nowrap">Search Type : </h5>
                <select class="form-select" style="margin-left:10px; width:150px" onchange="changedSearchType()" id="selectSearchType" name="selectSearchType">
                    <option value='1' {{ isset($key) && $key == '1' ? 'selected' : '' }}>Stock Name</option>
                    <option value='2' {{ isset($key) && $key == '2' ? 'selected' : '' }}>Stock Price</option>
                    <option value='3' {{ isset($key) && $key == '3' ? 'selected' : '' }}>ER Date</option>
                    <option value='4' {{ isset($key) && $key == '4' ? 'selected' : '' }}>ER Type</option>
                    <option value='5' {{ isset($key) && $key == '5' ? 'selected' : '' }}>Price Before</option>
                    <option value='6' {{ isset($key) && $key == '6' ? 'selected' : '' }}>Price After</option>
                </select>
                <div id="searchInputForm" style="margin-left:10px; width:200px;">
                    @if (isset($key) && $key == '3')
                        <input type="date" class="form-control" id="inputSearchData" value={{ isset($key) ? $value : '' }}>
                    @else
                        @if (isset($key) && $key == '4')
                            <select id="inputSearchData" class="form-select" aria-label="Default select">
                                <option value="1"  {{ isset($value) && $value == '1' ? 'selected' : '' }}>Very Good</option>
                                <option value="2" {{ isset($value) && $value == '2' ? 'selected' : '' }}>Bad</option>
                                <option value="3" {{ isset($value) && $value == '3' ? 'selected' : '' }}>Very Bad</option>
                            </select>        
                        @else
                            <input type="text" class="form-control" id="inputSearchData" value={{ isset($key) ? $value : '' }}>        
                        @endif
                    @endif
                    
                </div>
                <button 
                    class="btn btn-success" 
                    style="margin-left:10px; width:80px; font-size:18px;"
                    onclick="searchData()"
                >Search</button>
                <button class="btn btn-success" style="margin-left:10px; width:60px; font-size:18px;" onclick="resetSearch()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="color:white">
                        <path style="fill:currentColor" d="M20.944 12.979c-.489 4.509-4.306 8.021-8.944 8.021-2.698 0-5.112-1.194-6.763-3.075l1.245-1.633c1.283 1.645 3.276 2.708 5.518 2.708 3.526 0 6.444-2.624 6.923-6.021h-2.923l4-5.25 4 5.25h-3.056zm-15.864-1.979c.487-3.387 3.4-6 6.92-6 2.237 0 4.228 1.059 5.51 2.698l1.244-1.632c-1.65-1.876-4.061-3.066-6.754-3.066-4.632 0-8.443 3.501-8.941 8h-3.059l4 5.25 4-5.25h-2.92z"/>
                    </svg>
                </button>
            </div> 
        </div>
        

    </div>
    <div 
        class="collapse " 
        id="collapseExportData" 
        style="padding-left:20px; padding-right:20px; padding-bottom:10px; border-bottom:1px solid #2578b5; padding:10px;"
    >
        <div class="d-flex">
            <button 
                class="btn btn-success" 
                style="margin-left:10px; font-size:14px;"
                onclick="exportAsPdf()"
            >Export As PDF</button>
            <button 
                class="btn btn-success" 
                style="margin-left:10px; font-size:14px;"
                onclick="exportAsCsv()"
            >Export As CSV</button>
        </div>
        
    </div>
    <div 
        class="collapse " 
        id="collapseAddERData" 
        style="padding-left:20px; padding-right:20px; padding-bottom:10px; border-bottom:1px solid #2578b5; padding:10px;"
    >
        <table 
            class="table table-bordered table-row-dashed table-striped table-row-gray-300 align-middle gs-0 gy-4" 
            style=" font-size:14px; ">
            <thead class="table-light" >
                <th style="background-color:#8d8d8d !important; color:white">Stock Name</th>
                <th style="background-color:#8d8d8d !important; color:white">Stock Price</th>
                <th style="background-color:#8d8d8d !important; color:white">ER Date</th>
                <th style="background-color:#8d8d8d !important; color:white">ER Type</th>
                <th style="background-color:#8d8d8d !important; color:white">Price Before</th>
                <th style="background-color:#8d8d8d !important; color:white">Price After</th>
                <th style="background-color:#8d8d8d !important; color:white">Actions</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" class="form-control" placeholder="Stock Name" id="inputStockName" name="inputStockName">
                    </td>
                    <td>
                        <input type="text" class="form-control" placeholder="Stock Price" id="inputStockPrice" name="inputStockPrice">
                    </td>
                    <td>
                        <input type="date" value="'MM/dd/yyyy'" class="form-control" name="inputERDate" id="inputERDate"/> 
                    </td>
                    <td>
                        <select class="form-select" aria-label="Default select" id="inputERType" name="inputERType">
                            <option value="1" >Very Good</option>
                            <option value="2" >Bad</option>
                            <option value="3" >Very Bad</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" placeholder="Price Before" id="inputERPriceBefore" name="inputERPriceBefore">
                    </td>
                    <td>
                        <input type="text" class="form-control" placeholder="Price After" id="inputERPriceAfter" name="inputERPriceAfter">
                    </td>
                    <td>
                        <button class="btn btn-success" onclick="addERData()">Add</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="padding-left:20px; padding-right:20px; padding-top:10px;">
        @include('er_data.er_data_table')
    </div>

    <div 
        class="modal fade" 
        id="importERDataModal" 
        tabindex="-1" 
        aria-labelledby="importERDataModalLabel" 
        aria-hidden="true"
    >
        <div class="modal-dialog" style="width: 800px; max-width: 800px !important; padding:20px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importERDataModalLabel">Import ER Data from excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <form action="{{ route('erdata.importFromCSV') }}" method="POST" enctype="multipart/form-data" style="width:100%" class="d-flex justify-content-between">
                            @csrf
                            <input type="file" name="file" class="custom-file-input" id="customFile" accept=".xls, .xlsx">
                            <button class="btn btn-success">Import data</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div 
        class="modal fade" 
        id="deleteSelectedDataModal" 
        tabindex="-1" 
        aria-labelledby="deleteSelectedDataModalLabel" 
        aria-hidden="true"
    >
        <div class="modal-dialog" style="width: 800px; max-width: 800px !important; padding:20px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSelectedDataModalLabel">Delete selected data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 id="lblWarnDeleteSelectedData" name="lblWarnDeleteSelectedData"></h3>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" style="width:100%" id="btnDeleteData" name="btnDeleteData" onclick="deleteData(2)">Delete</button>
                    {{-- onclick="addData()" --}}
                </div>
            </div>
        </div>
    </div>

    <div 
        class="modal fade" 
        id="deleteDataModal" 
        tabindex="-1" 
        aria-labelledby="deleteDataModalLabel" 
        aria-hidden="true"
    >
        <div class="modal-dialog" style="width: 800px; max-width: 800px !important; padding:20px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDataModalLabel">Are you sure to delete this data?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div style="margin-top:10px" class="row">
                                <div class="col-12">
                                    <span><b>Stock Name</b></span>
                                    <input style="margin-top:5px" disabled="disabled" type="text" class="form-control" id="inputStockNameToDelete" name="inputStockNameToDelete">    
                                </div>
                            </div>
                            <div style="margin-top:10px" class="row">
                                <div class="col-6">
                                    <span><b>Stock Price</b></span>
                                    <input style="margin-top:5px" type="text" disabled="disabled" class="form-control" id="inputStockPriceToDelete" name="inputStockPriceToDelete">
                                </div>
                                <div class="col-6">
                                    <span><b>ER Date</b></span>
                                    <input style="margin-top:5px" type="text" disabled="disabled" class="form-control" id="inputERDateToDelete" name="inputERDateToDelete">
                                </div>
                            </div>
                            <div style="margin-top:10px" class="row">
                                <div class="col-6">
                                    <span><b>ER Type</b></span>
                                    <input style="margin-top:5px" type="text" disabled="disabled" class="form-control" id="inputERTypeToDelete" name="inputERTypeToDelete">
                                </div>
                                <div class="col-6">
                                    <span><b>Price Before</b></span>
                                    <input style="margin-top:5px" type="text" disabled="disabled" class="form-control" id="inputPriceBeforeToDelete" name="inputPriceBeforeToDelete">
                                </div>
                            </div>
                            <div style="margin-top:10px" class="row">
                                <div class="col-6">
                                    <span><b>Price After</b></span>
                                    <input style="margin-top:5px" type="text" disabled="disabled" class="form-control" id="inputPriceAfterToDelete" name="inputPriceAfterToDelete">
                                </div>
                                <div class="col-6">
                                    <span><b>% Change</b></span>
                                    <input style="margin-top:5px" type="text" disabled="disabled" class="form-control" id="inputPercentToDelete" name="inputPercentToDelete">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hiddenIdToDelete" name="hiddenIdToDelete">
                        <button class="btn btn-danger" style="width:100%" id="btnDeleteData" name="btnDeleteData" onclick="deleteData(1)">Delete</button>
                        {{-- onclick="addData()" --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function exportAsPdf()
    {
        window.location.href = "/erdata/export_pdf";
    }

    function exportAsCsv()
    {
        window.location.href = "/erdata/export_csv";
    }


    function showModalDeleteSelected()
    {
        var nCnt = 0;
        var listCheckData = document.getElementsByName("checkData");
        listCheckData.forEach(function(el){
            if(el.checked)
                nCnt++;
        })

        $('#lblWarnDeleteSelectedData').html("Are you sure to delete " + nCnt + " records?");
    }
    function deleteData(type)
    {
        var sendData = '';
        var nCnt = 0;
        if(type == 1)
        {
            sendData = $('#hiddenIdToDelete').val();
            if(sendData != '')
                nCnt++;
        }else if(type == 2){            
            var listCheckData = document.getElementsByName("checkData");
            listCheckData.forEach(function(element){
                if(element.checked)
                {
                    sendData += element.value + ",";
                    nCnt++;
                }
            });
        }
        if(nCnt == 0)
                return;
        $.ajax({
                url: "{{ route('erdata.delete') }}",
                type: 'POST',
                dataType: "json",
                data:{
                    deleteID : sendData
                },
                success:function(res){
                    window.location.reload();
                }
            });
        
    }
    function showDelModal(objData)
    {
        $('#inputStockNameToDelete').val(objData.stock_name);
        $('#inputStockPriceToDelete').val(objData.stock_price);
        $('#inputERDateToDelete').val(objData.er_date);
        $('#inputERTypeToDelete').val(objData.er_type);
        $('#inputPriceBeforeToDelete').val(objData.price_before);
        $('#inputPriceAfterToDelete').val(objData.price_after);
        if(objData.price_before > 0)
        {
            $('#inputPercentToDelete').val((objData.price_after * 100 / objData.price_before - 100).toFixed(2));
        }else{
            $('#inputPercentToDelete').val('');
        }
        $('#hiddenIdToDelete').val(objData.id);
    }
    function checkAllData()
    {
        var listData = document.getElementsByName("checkData");
        listData.forEach(element => {
            element.checked = $('#sendAllCheck').prop('checked');
        });
    }
    function resetSearch()
    {
        window.location.href = "/erdata";
    }
    function searchData()
    {
        var key = $('#selectSearchType').val();
        var value = $('#inputSearchData').val();
        if(value == '')
            return;
        window.location.href = "/erdata?key=" + key + "&value=" + value;
    }
    function changedSearchType()
    {
        if($('#selectSearchType').val() == '3') //  ER Date
        {
            $('#searchInputForm').html("<input type='date' class='form-control' id='inputSearchData'>");
        }
        else if($('#selectSearchType').val() == '4') //  ER Type
        {
            $('#searchInputForm').html(
                '<select id="inputSearchData" class="form-select" aria-label="Default select">' +
                    '<option value="1"  selected>Very Good</option>'+
                    '<option value="2">Bad</option>'+
                    '<option value="3" >Very Bad</option>'+
                '</select>'
            );
            
        }else{
            $('#searchInputForm').html("<input type='text' class='form-control' id='inputSearchData'>");
        }
    }
    function addERData()
    {
        if($('#inputERPriceAfter').val() == '' && 
            $('#inputERPriceBefore').val() == '' && 
            $('#inputERType').val() == '' && 
            $('#inputERDate').val() == '' && 
            $('#inputStockPrice').val() == '' && 
            $('#inputStockName').val() == '')
            return;
        $.ajax({
            url: "{{ route('erdata.add') }}",
            type: 'POST',
            dataType: "json",
            data: {
                er_stock_name:$('#inputStockName').val(),
                er_stock_price:$('#inputStockPrice').val(),
                er_date:$('#inputERDate').val(),
                er_type:$('#inputERType').val(),
                er_price_before:$('#inputERPriceBefore').val(),
                er_price_after:$('#inputERPriceAfter').val(),
            },
            success: function(data) {
                if(data.status == true)
                    window.location.reload();
            }
        });
    }
</script>
@endsection