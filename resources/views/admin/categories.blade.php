<div class="d-flex justify-content-between" style="padding:10px">
    <div class="d-flex justify-content-center align-items-center" style="margin-right:20px">
        Categories
        <div class="d-flex" style="margin-left:20px;">
            <div>
                <input
                    type="name"
                    class="form-control"
                    placeholder="NAME"
                    id = "nameNewCat"
                />
            </div>
            <div style="margin-left:20px">
                <button class="btn btn-primary" onclick="createNewCategory()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    New Category
                </button>
            </div>
        </div>
    </div>
    <div class="d-flex">
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
        <div style="margin-left:20px;">
            {{-- onclick="deleteCategory()" --}}
            <button data-bs-toggle="modal" data-bs-target="#categoryDeleteModal" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                    Delete Category
            </button>
        </div>

        <div class="modal fade" id="categoryDeleteModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Delete the Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <h2>{{$selected_category_name}}</h1>
                        </div>
                        <div style="margin-top:20px">
                            <h3>Are you sure to delete this?</h2>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteCategory()">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

function deleteCategory()
{
    var catID = document.getElementById('category_select').value;
    //window.location.href="/deleteCat?id='" + catID + "'";
    $.ajax({
        url: "{{ route('adminpage.deleteCat') }}",
        method: 'post',
        dataType: "json",
        data: {
            catID: catID,
        },
        success: function(data) {
            if(data.status == true)
            {
                document.getElementById('nameNewCat').value = "";
                getFieldsByCategory(document.getElementById('category_select').value);
            }
            if(data.status == false)
            {
                alert(data.msg);
            }
        }
    });
}

function getFieldsByCategory(category)
{
    window.location.href = "/adminpage/" + category ;
}

function createNewCategory()
{
    var name = document.getElementById('nameNewCat').value;
    if(name == "")
        return;
    $.ajax({
        url: "{{ route('adminpage.addCat') }}",
        type: 'POST',
        dataType: "json",
        data: {
            name: name,
        },
        success: function(data) {
            if(data.status == true)
            {
                document.getElementById('nameNewCat').value = "";
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