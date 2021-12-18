<table 
    class="table table-bordered table-row-dashed table-striped table-row-gray-300 align-middle gs-0 gy-4" 
    style=" font-size:14px; ">
    <thead class="table-light" >
        <th style="width:30px; background-color:#484848 !important">
            <input type="checkbox" name="sendAllCheck" id="sendAllCheck" onchange="checkAllData()">
        </th>
        <th style="background-color:#484848 !important; color:white">S.NO</th>
        <th style="background-color:#484848 !important; color:white">Stock Name</th>
        <th style="background-color:#484848 !important; color:white">Stock Price</th>
        <th style="background-color:#484848 !important; color:white">ER Date</th>
        <th style="background-color:#484848 !important; color:white">ER Type</th>
        <th style="background-color:#484848 !important; color:white">Price Before</th>
        <th style="background-color:#484848 !important; color:white">Price After</th>
        <th style="background-color:#484848 !important; color:white">% Change</th>
        <th style="background-color:#484848 !important; color:white; width:80px;">
            Actions
        </th>
    </thead>
    <tbody>
        @foreach ($er_datas as $key => $data)
        <tr>
            <td><input type="checkbox" name="checkData" value={{ $data->id }}></td>
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
            <td class="d-flex justify-content-center">
                <a 
                    data-toggle="tooltip" 
                    title="Delete record" 
                    style="cursor: pointer;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteDataModal" 
                    onclick="showDelModal({{ $data }})"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </a>
            </td>
        </tr>
        @endforeach
        
    </tbody>
</table>
<div class="d-flex justify-content-between" style="width:100%">
    <div>{{ $er_datas->links() }}</div>
    <button 
        class="btn btn-danger" 
        style="font-size:14px; width:80px;" 
        data-toggle="tooltip" 
        title="Delete selected data" 
        style="cursor: pointer;" 
        data-bs-toggle="modal" 
        data-bs-target="#deleteSelectedDataModal" 
        onclick="showModalDeleteSelected()">Delete</button>
</div>
