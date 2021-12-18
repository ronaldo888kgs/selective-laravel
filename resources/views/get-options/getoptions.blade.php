@extends('dashboard')
@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" rel="stylesheet"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>

<div id="messages-box" style="position:absolute; right:0; top:0;">
</div>
<div class="container">
    <div class="d-flex justify-content-center" style="padding: 0px; position: relative">
            <h1>Get Option Chain</h1>
    </div>
    <div class="row d-flex align-items-center" style="margin-top:30px;">
        <div class="col-2">
            <input class="form-control" type="text"  id='getOptionsKey' style="width:100%; height:100%"/>
        </div>
        <div class="col-2">
            <button type="button" class="btn btn-primary" onclick="">Get Options</button>
        </div>
    </div>
    <div class="row" style="margin-top:30px;">
        <div class="col-6">
            <div class="row">
                <div class="col-6">S.NO</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6"> Date Time</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Tracker</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Buy Date</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">QTY</div>
                <div class="col-6"></div>
            </div>    
            <div class="row">
                <div class="col-6">Symbol</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">  Expiration Date	</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">CallPut</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Strike Price	</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">@</div>
                <div class="col-6"></div>
            </div>   	
            <div class="row">
                <div class="col-6">Price</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">  Out Price</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Percentage</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Stock Price</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Sell Date</div>
                <div class="col-6"></div>
            </div>    	
            <div class="row">
                <div class="col-6"> Total Net</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">  Cumulative Total</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6"> Total Volume</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Open Interest</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Delta</div>
                <div class="col-6"></div>
            </div>    		
            <div class="row">
                <div class="col-6">  Days to Expire	</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6"> Trend Status</div>
                <div class="col-6"></div>
            </div>
            <div class="row">
                <div class="col-6">Status</div>
                <div class="col-6"></div>
            </div>    
        </div>
        <div class="col-6">
            <div id="treeview1" class="treeview"></div>
        </div>
    </div>
</div>
<script type="text/javascript">


</script>
@endsection